<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Announcement;
use App\Models\Activity;
use App\Models\SchoolInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeacherDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            if ($user->role !== 'guru') {
                return redirect('/');
            }
            if (!$user->teacher) {
                return redirect('/')->with('error', 'Data guru tidak ditemukan. Hubungi admin.');
            }
            return $next($request);
        });
    }

    /**
     * Show teacher dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $teacher = $user->teacher;
        $totalStudents = Grade::where('teacher_id', $teacher->id)->distinct('student_id')->count('student_id');
        $totalClasses = Grade::where('teacher_id', $teacher->id)->distinct('subject')->count('subject');

        return view('teacher.dashboard', [
            'user' => $user,
            'teacher' => $teacher,
            'totalStudents' => $totalStudents,
            'totalClasses' => $totalClasses,
        ]);
    }

    /**
     * Show teacher schedule
     */
    public function schedule()
    {
        $user = Auth::user();
        $teacher = $user->teacher;
        $schedules = $teacher->schedule()->orderBy('day')->get();

        return view('teacher.schedule', [
            'schedules' => $schedules,
        ]);
    }

    /**
     * Show students list
     */
    public function students(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;
        $search = $request->input('search', '');

        // Get unique students taught by this teacher
        $query = Student::whereHas('grades', function ($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->with('user');

        // Apply search filter if search query is provided
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%');
                })->orWhere('nisn', 'like', '%' . $search . '%');
            });
        }

        $students = $query->get();

        $classOrder = ['1A', '2A', '3A', '4A', '5A', '6A'];
        $studentsByClass = $students
            ->sortBy(function ($student) use ($classOrder) {
                $classIndex = array_search($student->class, $classOrder, true);
                $classIndex = $classIndex === false ? PHP_INT_MAX : $classIndex;

                return [$classIndex, strtolower($student->user->name ?? ''), $student->nisn ?? ''];
            })
            ->groupBy('class');

        return view('teacher.students', [
            'students' => $students,
            'studentsByClass' => $studentsByClass,
            'search' => $search,
        ]);
    }

    /**
     * Show student detail
     */
    public function studentDetail($id)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $student = Student::with('user')->findOrFail($id);

        // Verify that teacher teaches this student
        $hasStudent = Grade::where('teacher_id', $teacher->id)
            ->where('student_id', $student->id)
            ->exists();

        if (!$hasStudent) {
            abort(403, 'Anda tidak mengajar siswa ini');
        }

        $grades = Grade::where('student_id', $student->id)
            ->where('teacher_id', $teacher->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('teacher.student-detail', [
            'student' => $student,
            'grades' => $grades,
        ]);
    }

    /**
     * Show grades for specific student or all students
     */
    public function grades(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $query = Grade::where('teacher_id', $teacher->id)->with('student.user');

        if ($request->has('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $grades = $query->get();

        // Get students taught by this teacher
        $students = Student::whereHas('grades', function ($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->with('user')->get();

        // Derive class list from students and include default classes 1..6
        $studentClasses = $students->pluck('class')->unique()->filter()->values()->toArray();
        $defaultClasses = ['1A','2A','3A','4A','5A','6A'];

        // Merge preserving defaults order, then append any additional classes
        $classes = collect($defaultClasses)->merge(array_values(array_diff($studentClasses, $defaultClasses)))->filter()->values();

        return view('teacher.grades', [
            'grades' => $grades,
            'students' => $students,
            'classes' => $classes,
            'selectedStudent' => $request->student_id,
            'selectedClass' => $request->class ?? null,
        ]);
    }

    /**
     * Show form to add/edit grade
     */
    public function editGrade(Request $request, $id = null)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $grade = null;
        if ($id) {
            $grade = Grade::findOrFail($id);
            if ($grade->teacher_id !== $teacher->id) {
                abort(403);
            }
        }

        $students = Student::whereHas('grades', function ($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })->with('user')->get();

        // Allow preselecting a student via query param ?student_id=..
        $selectedStudentId = $request->query('student_id');

        return view('teacher.edit-grade', [
            'grade' => $grade,
            'students' => $students,
            'selectedStudentId' => $selectedStudentId,
        ]);
    }

    /**
     * Store or update grade
     */
    public function storeGrade(Request $request, $id = null)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject' => 'required|string|max:255',
            'grade' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($id) {
            $grade = Grade::findOrFail($id);
            if ($grade->teacher_id !== $teacher->id) {
                abort(403);
            }
            foreach ($validated as $key => $value) {
                $grade->$key = $value;
            }
            $grade->save();
            $message = 'Nilai berhasil diperbarui';
        } else {
            $validated['teacher_id'] = $teacher->id;
            Grade::create($validated);
            $message = 'Nilai berhasil ditambahkan';
        }

        if ($request->boolean('from_student_detail')) {
            return redirect()->route('teacher.students.show', $validated['student_id'])->with('success', $message);
        }

        return redirect()->route('teacher.grades')->with('success', $message);
    }

    /**
     * Delete grade
     */
    public function deleteGrade($id)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $grade = Grade::findOrFail($id);
        if ($grade->teacher_id !== $teacher->id) {
            abort(403);
        }

        $grade->delete();
        return redirect()->route('teacher.grades')->with('success', 'Nilai berhasil dihapus');
    }

    /**
     * Store grade via AJAX (no page reload)
     */
    public function storeGradeAjax(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject' => 'required|string|max:255',
            'grade' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $validated['teacher_id'] = $teacher->id;
            $grade = Grade::create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Nilai berhasil ditambahkan',
                'grade' => [
                    'id' => $grade->id,
                    'subject' => $grade->subject,
                    'grade' => number_format($grade->grade, 2),
                    'notes' => $grade->notes ?? '-',
                    'created_at' => $grade->created_at->format('d M Y'),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Import grades from CSV file (bulk import)
     */
    public function importGrades(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx|max:2048'
        ]);

        try {
            $file = $request->file('file');
            $path = $file->getRealPath();
            
            $imported = 0;
            $failed = 0;
            $errors = [];

            // Open and read CSV
            if (($handle = fopen($path, 'r')) !== false) {
                $header = fgetcsv($handle);
                
                while (($row = fgetcsv($handle)) !== false) {
                    if (count($row) < 4) continue;

                    try {
                        $nisn = trim($row[0]);
                        $subject = trim($row[1]);
                        $grade = (float) trim($row[2]);
                        $notes = isset($row[3]) ? trim($row[3]) : null;

                        // Validate data
                        if (empty($nisn) || empty($subject) || $grade < 0 || $grade > 100) {
                            $failed++;
                            continue;
                        }

                        // Find student by NISN
                        $student = Student::where('nisn', $nisn)
                            ->whereHas('grades', function ($q) use ($teacher) {
                                $q->where('teacher_id', $teacher->id);
                            })
                            ->first();

                        if (!$student) {
                            $failed++;
                            continue;
                        }

                        // Create grade
                        Grade::create([
                            'student_id' => $student->id,
                            'teacher_id' => $teacher->id,
                            'subject' => $subject,
                            'grade' => $grade,
                            'notes' => $notes,
                        ]);

                        $imported++;
                    } catch (\Exception $e) {
                        $failed++;
                    }
                }
                fclose($handle);
            }

            return response()->json([
                'success' => true,
                'message' => "Berhasil import $imported nilai, $failed baris gagal",
                'imported' => $imported,
                'failed' => $failed,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal import file: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Export grades report to CSV
     */
    public function exportGrades(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $grades = Grade::where('teacher_id', $teacher->id)
            ->with(['student' => function ($q) {
                $q->with('user');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        // Create CSV
        $filename = 'laporan_nilai_' . date('Y-m-d_His') . '.csv';
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Add BOM for Excel UTF-8 compatibility
        fwrite($handle, "\xEF\xBB\xBF");

        // Header row
        fputcsv($handle, ['NISN', 'Nama Siswa', 'Kelas', 'Mata Pelajaran', 'Nilai', 'Keterangan', 'Tanggal'], ';');

        // Data rows
        foreach ($grades as $grade) {
            fputcsv($handle, [
                $grade->student->nisn ?? '-',
                $grade->student->user->name ?? '-',
                $grade->student->class ?? '-',
                $grade->subject,
                number_format($grade->grade, 2),
                $grade->notes ?? '-',
                $grade->created_at->format('d-m-Y H:i:s')
            ], ';');
        }

        fclose($handle);
        exit;
    }

    /**
     * Export grades report to Excel (XLSX)
     */
    public function exportGradesExcel(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $grades = Grade::where('teacher_id', $teacher->id)
            ->with(['student' => function ($q) {
                $q->with('user');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'laporan_nilai_' . date('Y-m-d_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');

        // Generate Excel XML format
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns:html="http://www.w3.org/TR/REC-html40">';
        echo '<Styles>';
        echo '<Style ss:ID="Header"><Interior ss:Color="#2D4438" ss:Pattern="Solid"/><Font ss:Bold="1" ss:Color="white" ss:Size="11"/><Alignment ss:Horizontal="Center" ss:Vertical="Center"/></Style>';
        echo '<Style ss:ID="Data"><Font ss:Size="10"/></Style>';
        echo '</Styles>';
        echo '<Worksheet ss:Name="Laporan Nilai">';
        echo '<Table>';

        // Header row
        echo '<Row ss:StyleID="Header">';
        echo '<Cell><Data ss:Type="String">NISN</Data></Cell>';
        echo '<Cell><Data ss:Type="String">Nama Siswa</Data></Cell>';
        echo '<Cell><Data ss:Type="String">Kelas</Data></Cell>';
        echo '<Cell><Data ss:Type="String">Mata Pelajaran</Data></Cell>';
        echo '<Cell><Data ss:Type="String">Nilai</Data></Cell>';
        echo '<Cell><Data ss:Type="String">Keterangan</Data></Cell>';
        echo '<Cell><Data ss:Type="String">Tanggal</Data></Cell>';
        echo '</Row>';

        // Data rows
        foreach ($grades as $grade) {
            echo '<Row ss:StyleID="Data">';
            echo '<Cell><Data ss:Type="String">' . htmlspecialchars($grade->student->nisn ?? '-') . '</Data></Cell>';
            echo '<Cell><Data ss:Type="String">' . htmlspecialchars($grade->student->user->name ?? '-') . '</Data></Cell>';
            echo '<Cell><Data ss:Type="String">' . htmlspecialchars($grade->student->class ?? '-') . '</Data></Cell>';
            echo '<Cell><Data ss:Type="String">' . htmlspecialchars($grade->subject) . '</Data></Cell>';
            echo '<Cell ss:StyleID="Data"><Data ss:Type="Number">' . $grade->grade . '</Data></Cell>';
            echo '<Cell><Data ss:Type="String">' . htmlspecialchars($grade->notes ?? '-') . '</Data></Cell>';
            echo '<Cell><Data ss:Type="String">' . $grade->created_at->format('d-m-Y H:i:s') . '</Data></Cell>';
            echo '</Row>';
        }

        echo '</Table>';
        echo '</Worksheet>';
        echo '</Workbook>';

        exit;
    }

    /**
     * Show teacher profile
     */
    public function profile()
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        return view('teacher.profile', [
            'user' => $user,
            'teacher' => $teacher,
        ]);
    }

    /**
     * Update teacher profile
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000',
        ]);

        foreach ($validated as $key => $value) {
            $user->$key = $value;
        }
        $user->save();

        return redirect()->route('teacher.profile')->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Show change password form
     */
    public function showChangePassword()
    {
        return view('teacher.change-password');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|confirmed|min:8|different:current_password',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('teacher.profile')->with('success', 'Password berhasil diubah');
    }

    /**
     * Show upload profile photo form
     */
    public function showUploadPhoto()
    {
        return view('teacher.upload-photo');
    }

    /**
     * Upload profile photo
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        /** @var User $user */
        $user = Auth::user();

        // Delete old photo if exists
        if ($user->profile_photo && Storage::exists('public/' . $user->profile_photo)) {
            Storage::delete('public/' . $user->profile_photo);
        }

        // Store new photo
        $path = $request->file('photo')->store('profile-photos', 'public');

        $user->profile_photo = $path;
        $user->save();

        return redirect()->route('teacher.profile')->with('success', 'Foto profil berhasil diubah');
    }

    /**
     * Show teacher informasi page
     */
    public function informasi()
    {
        $announcements = Announcement::where('status', 'published')->orderBy('created_at', 'desc')->get();

        return view('teacher.informasi', [
            'announcements' => $announcements,
        ]);
    }

    /**
     * Show teacher kegiatan page
     */
    public function kegiatan()
    {
        $activities = Activity::where('status', 'published')->orderBy('created_at', 'desc')->get();

        return view('teacher.kegiatan', [
            'activities' => $activities,
        ]);
    }

    /**
     * Show teacher kontak page
     */
    public function kontak()
    {
        $schoolInfo = SchoolInfo::first();

        return view('teacher.kontak', [
            'schoolInfo' => $schoolInfo,
        ]);
    }

    /**
     * API endpoint for live student search
     */
    public function searchStudents(Request $request)
    {
        $search = $request->input('q', '');
        $user = Auth::user();
        $teacher = $user->teacher;

        if (strlen($search) < 1) {
            return response()->json([]);
        }

        $students = Student::whereHas('grades', function ($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })
        ->with('user')
        ->where(function ($q) use ($search) {
            $q->whereHas('user', function ($userQuery) use ($search) {
                $userQuery->where('name', 'like', '%' . $search . '%');
            })->orWhere('nisn', 'like', '%' . $search . '%');
        })
        ->limit(10)
        ->get()
        ->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->user->name,
                'nisn' => $student->nisn,
                'class' => $student->class,
                'url' => route('teacher.students.show', $student->id),
            ];
        });

        return response()->json($students);
    }
}

