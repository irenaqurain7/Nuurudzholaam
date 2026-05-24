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
    public function students()
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        // Get unique students taught by this teacher
        $students = Student::whereHas('grades', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->with('user')->get();

        return view('teacher.students', [
            'students' => $students,
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
}
