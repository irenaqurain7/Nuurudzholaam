<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Teacher;
use App\Models\Announcement;
use App\Models\Activity;
use App\Models\SchoolInfo;
use App\Models\StudentSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'siswa') {
                return redirect('/');
            }
            return $next($request);
        });
    }

    /**
     * Show student dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->firstOrFail();
        $todayName = Carbon::now()->format('l');
        $todayLabel = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ][$todayName] ?? $todayName;

        // Tambahkan query ini untuk mengambil pengumuman aktif terbaru
        $announcements = Announcement::where('status', 'aktif')
            ->orderBy('tanggal_mulai', 'desc')
            ->take(5) // Mengambil 5 pengumuman terbaru untuk dashboard
            ->get();

        $todaySchedules = StudentSchedule::query()
            ->where('class', $student->class)
            ->where('day', $todayName)
            ->orderBy('created_at')
            ->get();

        if ($todaySchedules->isEmpty()) {
            $todaySchedules = StudentSchedule::query()
                ->where('class', $student->class)
                ->where('day', $todayLabel)
                ->orderBy('created_at')
                ->get();
        }

        $todayScheduleItems = $todaySchedules
            ->flatMap(function (StudentSchedule $schedule) {
                return collect($schedule->activities ?? []);
            })
            ->filter(function ($activity) {
                return is_string($activity) && trim($activity) !== '';
            })
            ->values();

        $semesterSummaries = $this->buildSemesterSummaries($student);

        return view('student.dashboard', [
            'user' => $user,
            'student' => $student,
            'announcements' => $announcements, // Kirim variabel ke view blade
            'todayLabel' => $todayLabel,
            'todayScheduleItems' => $todayScheduleItems,
            'semesterSummaries' => $semesterSummaries,
        ]);
    }

    /**
     * Show student schedule
     */
    public function schedule()
    {
        return redirect()->route('student.dashboard');
    }

    private function buildSemesterSummaries(Student $student)
    {
        $gradeGroups = $student->grades()
            ->orderBy('created_at')
            ->get()
            ->filter(function (Grade $grade) {
                return is_numeric($grade->grade);
            })
            ->groupBy(function (Grade $grade) {
                $semesterValue = trim((string) data_get($grade, 'semester', ''));

                if ($semesterValue !== '') {
                    return 'semester:' . $semesterValue;
                }

                $createdAt = $grade->created_at;
                if (!$createdAt) {
                    return 'semester:unknown';
                }

                $academicYear = $createdAt->month >= 7
                    ? $createdAt->year . '/' . ($createdAt->year + 1)
                    : ($createdAt->year - 1) . '/' . $createdAt->year;
                $term = $createdAt->month >= 7 ? 'ganjil' : 'genap';

                return 'period:' . $academicYear . ':' . $term;
            })
            ->map(function ($grades, $groupKey) {
                $firstGrade = $grades->sortBy('created_at')->first();

                return [
                    'group_key' => $groupKey,
                    'period_key' => $firstGrade && $firstGrade->created_at ? $firstGrade->created_at->timestamp : PHP_INT_MAX,
                    'average' => round((float) $grades->avg('grade'), 2),
                    'total_subjects' => $grades->count(),
                    'period_label' => $this->resolveSemesterPeriodLabel($firstGrade),
                ];
            })
            ->sortBy('period_key')
            ->values()
            ->map(function (array $summary, int $index) {
                $summary['label'] = 'Semester ' . ($index + 1);
                return $summary;
            });

        return $gradeGroups;
    }

    private function resolveSemesterPeriodLabel(?Grade $grade): string
    {
        if (!$grade || !$grade->created_at) {
            return '-';
        }

        $createdAt = $grade->created_at;
        $academicYear = $createdAt->month >= 7
            ? $createdAt->year . '/' . ($createdAt->year + 1)
            : ($createdAt->year - 1) . '/' . $createdAt->year;

        return $academicYear . ' ' . ($createdAt->month >= 7 ? 'Ganjil' : 'Genap');
    }

    /**
     * Show student grades
     */
    public function grades()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->firstOrFail();
        $grades = $student->grades()->with('teacher.user')->get();

        // Demo fallback: auto-create a few grades in local env so UI is never empty.
        if ($grades->isEmpty() && app()->environment('local')) {
            $teacher = Teacher::query()->first();
            if ($teacher) {
                $subjects = ['Matematika', 'Bahasa Indonesia', 'IPA'];

                foreach ($subjects as $index => $subject) {
                    Grade::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'teacher_id' => $teacher->id,
                            'subject' => $subject,
                        ],
                        [
                            'grade' => 75 + ($index * 5),
                            'notes' => 'Nilai dummy otomatis untuk tampilan demo',
                        ]
                    );
                }

                $grades = $student->grades()->with('teacher.user')->get();
            }
        }

        return view('student.grades', [
            'grades' => $grades,
        ]);
    }

    /**
     * Show student profile
     */
    public function profile()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->firstOrFail();

        return view('student.profile', [
            'user' => $user,
            'student' => $student,
        ]);
    }

    /**
     * Update student profile
     */
    public function updateProfile(Request $request)
    {
        abort(403, 'Profil siswa bersifat read-only dan tidak dapat diperbarui.');
    }

    /**
     * Show change password form
     */
    public function showChangePassword()
    {
        return view('student.change-password');
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

        return redirect()->route('student.profile')->with('success', 'Password berhasil diubah');
    }

    /**
     * Show upload profile photo form
     */
    public function showUploadPhoto()
    {
        return view('student.upload-photo');
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

        if ($user->profile_photo && Storage::exists('public/' . $user->profile_photo)) {
            Storage::delete('public/' . $user->profile_photo);
        }

        $path = $request->file('photo')->store('profile-photos', 'public');

        $user->profile_photo = $path;
        $user->save();

        return redirect()->route('student.profile')->with('success', 'Foto profil berhasil diubah');
    }

    /**
     * Show student informasi page
     */
    public function informasi()
    {
        $announcements = Announcement::where('status', 'aktif')
            ->where('tipe', 'penting')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('student.informasi', [
            'announcements' => $announcements,
        ]);
    }

    /**
     * Show student kegiatan page
     */
    public function kegiatan()
    {
        $activities = Activity::where('visibility', 'publik')->orderBy('created_at', 'desc')->get();

        return view('student.kegiatan', [
            'activities' => $activities,
        ]);
    }

    /**
     * Show student kontak page
     */
    public function kontak()
    {
        $schoolInfo = SchoolInfo::first();

        return view('student.kontak', [
            'schoolInfo' => $schoolInfo,
        ]);
    }
}
