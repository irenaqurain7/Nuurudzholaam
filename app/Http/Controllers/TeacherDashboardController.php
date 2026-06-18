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
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

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
        // Total students the teacher is responsible for (via grades relationship)
        $totalStudents = Grade::where('teacher_id', $teacher->id)->distinct('student_id')->count('student_id');

        // Determine homeroom/wali class (best-effort): prefer explicit `homeroom_class` on teacher model,
        // otherwise pick the class with the most students taught by this teacher (based on Grade -> Student.class).
        $homeroomClass = null;
        if (isset($teacher->homeroom_class) && $teacher->homeroom_class) {
            $homeroomClass = (string) $teacher->homeroom_class;
        } else {
            $topClass = Grade::where('teacher_id', $teacher->id)
                ->join('students', 'grades.student_id', '=', 'students.id')
                ->selectRaw('students.class as class_name, COUNT(*) as cnt')
                ->groupBy('students.class')
                ->orderByDesc('cnt')
                ->first();
            if ($topClass && $topClass->class_name) {
                $homeroomClass = (string) $topClass->class_name;
            }
        }

        // Compute today's name in Indonesian and count sessions for today
        $dayMap = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];
        $todayEnglish = \Carbon\Carbon::now()->format('l');
        $todayName = $dayMap[$todayEnglish] ?? $todayEnglish;

        $todayCount = \App\Models\Schedule::where('teacher_id', $teacher->id)
            ->where('day', $todayName)
            ->count();

        // Total distinct classes across schedule & grades (assignment-based across levels)
        $classesFromSchedules = \App\Models\Schedule::where('teacher_id', $teacher->id)
            ->whereHas('student', function ($q) { $q->whereNotNull('class'); })
            ->with('student')
            ->get()
            ->pluck('student.class')
            ->filter()
            ->unique();

        $classesFromGrades = Grade::where('teacher_id', $teacher->id)
            ->join('students', 'grades.student_id', '=', 'students.id')
            ->pluck('students.class')
            ->filter()
            ->unique();

        $totalClasses = $classesFromSchedules->merge($classesFromGrades)->unique()->count();

        return view('teacher.dashboard', [
            'user' => $user,
            'teacher' => $teacher,
            'totalStudents' => $totalStudents,
            'totalClasses' => $totalClasses,
            'homeroomClass' => $homeroomClass,
            'todayCount' => $todayCount,
            'todayName' => $todayName,
        ]);
    }

    /**
     * Show teacher schedule
     */
    public function schedule(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $selectedClass = trim((string)$request->query('class', ''));

        // Prepare an empty collection by default
        $schedules = collect();

        if ($selectedClass !== '') {
            // Match students whose `class` starts with the selected number (e.g. '1' matches '1A')
            $schedules = \App\Models\Schedule::where('teacher_id', $teacher->id)
                ->whereHas('student', function ($q) use ($selectedClass) {
                    $q->where('class', 'like', $selectedClass . '%');
                })->with('student')
                ->get()
                ->sortBy(function ($s) {
                    $order = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                    $idx = array_search($s->day, $order, true);
                    return $idx === false ? PHP_INT_MAX : $idx;
                })->values();

            // If DB has no schedules for this class, fallback to parsed JSON (if available)
            if ($schedules->isEmpty()) {
                $parsedPath = storage_path('app/jadwal_parsed.json');
                if (file_exists($parsedPath)) {
                    $json = json_decode(file_get_contents($parsedPath), true);
                    $fallback = collect();

                    // First: include entire groups whose header/items explicitly mention the class
                    if (is_array($json)) {
                        foreach ($json as $group) {
                            $day = $group['day'] ?? '';
                            $groupHasClass = false;
                            foreach ($group['items'] as $item) {
                                $subj = strtolower($item['subject'] ?? '');
                                if (preg_match('/kelas[^0-9]*\b' . preg_quote($selectedClass, '/') . '\b/i', $subj)) {
                                    $groupHasClass = true;
                                    break;
                                }
                            }
                            if ($groupHasClass) {
                                foreach ($group['items'] as $item) {
                                    $obj = new \stdClass();
                                    $obj->day = $day;
                                    $obj->subject = $item['subject'] ?? '';
                                    $start = $item['start_time'] ?? '';
                                    $end = $item['end_time'] ?? '';
                                    $obj->start_time = strlen($start) === 5 ? $start . ':00' : ($start ?: null);
                                    $obj->end_time = strlen($end) === 5 ? $end . ':00' : ($end ?: null);
                                    $obj->room = $item['room'] ?? null;
                                    $fallback->push($obj);
                                }
                            }
                        }

                        // If no group matched, try to include individual items that mention the class
                        if ($fallback->isEmpty()) {
                            foreach ($json as $group) {
                                $day = $group['day'] ?? '';
                                foreach ($group['items'] as $item) {
                                    $subj = strtolower($item['subject'] ?? '');
                                    if (preg_match('/kelas[^0-9]*\b' . preg_quote($selectedClass, '/') . '\b/i', $subj)) {
                                        $obj = new \stdClass();
                                        $obj->day = $day;
                                        $obj->subject = $item['subject'] ?? '';
                                        $start = $item['start_time'] ?? '';
                                        $end = $item['end_time'] ?? '';
                                        $obj->start_time = strlen($start) === 5 ? $start . ':00' : ($start ?: null);
                                        $obj->end_time = strlen($end) === 5 ? $end . ':00' : ($end ?: null);
                                        $obj->room = $item['room'] ?? null;
                                        $fallback->push($obj);
                                    }
                                }
                            }
                        }
                    }

                    // Only use fallback if we found explicit class matches
                    if ($fallback->isNotEmpty()) {
                        $schedules = $fallback->sortBy(function ($s) {
                            $order = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                            $idx = array_search($s->day, $order, true);
                            return $idx === false ? PHP_INT_MAX : $idx;
                        })->values();
                    }
                }
            }

            // If still empty, use a manual default schedule provided by user (school weekly planner)
            if ($schedules->isEmpty()) {
                $manual = [
                    'Senin' => [
                        'Sholat Duha', 'Upacara Bendera', 'Pendidikan Pancasila', 'Istirahat', 'Bahasa Indonesia'
                    ],
                    'Selasa' => [
                        'Sholat Duha', 'Ngosrek', 'Pendidikan Agama Islam', 'Istirahat', 'B. Sunda (menggantikan Matematika)'
                    ],
                    'Rabu' => [
                        'Sholat Duha', 'Kaulinan Sunda / MTK', 'Istirahat', 'Bahasa Inggris (menggantikan Bahasa Sunda)'
                    ],
                    'Kamis' => [
                        'Sholat Duha', 'Pembiasaan Literasi', 'Seni Budaya', 'Istirahat', 'Huruf Sambung'
                    ],
                    'Jumat' => [
                        'Sholat Duha', 'PJOK', 'Istirahat', 'TDBA / 8 Dimensi Profil Kelulusan'
                    ],
                ];

                $gen = collect();
                foreach ($manual as $dayName => $subjects) {
                    foreach ($subjects as $subj) {
                        $obj = new \stdClass();
                        $obj->day = $dayName;
                        $obj->subject = $subj;
                        $obj->start_time = null;
                        $obj->end_time = null;
                        $obj->room = null;
                        $gen->push($obj);
                    }
                }
                if ($gen->isNotEmpty()) {
                    $schedules = $gen->sortBy(function ($s) {
                        $order = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                        $idx = array_search($s->day, $order, true);
                        return $idx === false ? PHP_INT_MAX : $idx;
                    })->values();
                }
            }
        }

        // If no class selected, show unified timeline for today across all classes
        if ($selectedClass === '') {
            $dayMap = [
                'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
            ];
            $todayEnglish = \Carbon\Carbon::now()->format('l');
            $todayName = $dayMap[$todayEnglish] ?? $todayEnglish;

            $schedules = \App\Models\Schedule::where('teacher_id', $teacher->id)
                ->where('day', $todayName)
                ->with('student')
                ->orderBy('start_time')
                ->get();
        }

        // Diagnostic information for debugging purposes
        $parsedPath = storage_path('app/jadwal_parsed.json');
        $parsedExists = file_exists($parsedPath);
        $parsedGroups = 0;
        $parsedItemsTotal = 0;
        $detectedClasses = collect();
        if ($parsedExists) {
            $raw = @file_get_contents($parsedPath);
            $j = @json_decode($raw, true);
            if (is_array($j)) {
                $parsedGroups = count($j);
                foreach ($j as $g) {
                    $parsedItemsTotal += is_array($g['items'] ?? null) ? count($g['items']) : 0;
                    // detect classes mentioned in parsed items
                    if (is_array($g['items'] ?? null)) {
                        foreach ($g['items'] as $it) {
                            $subj = strtolower($it['subject'] ?? '');
                            if (strpos($subj, 'kelas') !== false) {
                                if (preg_match_all('/\d+/', $subj, $m)) {
                                    foreach ($m[0] as $num) {
                                        $detectedClasses->push((int)$num);
                                    }
                                }
                            }
                        }
                    }
                }
                $detectedClasses = $detectedClasses->unique()->sort()->values();
            }
        }

        // Prepare schedules array for debugging (limit size)
        $schedulesArray = $schedules->map(function ($s) {
            if (is_array($s)) return $s;
            if ($s instanceof \Illuminate\Database\Eloquent\Model) return $s->toArray();
            return (array) $s;
        })->take(50)->values();

        $diagnostic = [
            'selectedClass' => $selectedClass,
            'db_schedules_count' => isset($dbSchedulesCount) ? $dbSchedulesCount : ($schedules instanceof \Illuminate\Support\Collection ? $schedules->count() : null),
            'schedules_sample' => $schedulesArray,
            'parsed_file_exists' => $parsedExists,
            'parsed_groups' => $parsedGroups,
            'parsed_items_total' => $parsedItemsTotal,
            'detected_classes_in_parsed' => $detectedClasses->values(),
        ];

        Log::debug('TeacherScheduleDebug', $diagnostic);

        if ($request->boolean('debug')) {
            return response()->json($diagnostic);
        }

        return view('teacher.schedule', [
            'schedules' => $schedules,
            'selectedClass' => $selectedClass,
            'detectedClasses' => $detectedClasses,
        ]);
    }

    /**
     * Import parsed jadwal_parsed.json into schedules table for the selected class.
     * This action creates Schedule entries with teacher_id = current teacher and student_id = null.
     */
    public function importParsedToDb(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $validated = $request->validate([
            'class' => 'required|string|max:10'
        ]);

        $selectedClass = trim((string)$validated['class']);

        $parsedPath = storage_path('app/jadwal_parsed.json');
        if (!file_exists($parsedPath)) {
            return back()->with('error', 'File parsed tidak ditemukan. Jalankan parser terlebih dahulu.');
        }

        $json = @json_decode(file_get_contents($parsedPath), true);
        if (!is_array($json)) {
            return back()->with('error', 'File parsed tidak valid.');
        }

        $inserted = 0;
        foreach ($json as $group) {
            $day = $group['day'] ?? '';
            foreach ($group['items'] as $item) {
                $subj = strtolower($item['subject'] ?? '');
                if (preg_match('/kelas[^0-9]*\b' . preg_quote($selectedClass, '/') . '\b/i', $subj)) {
                    $subject = $item['subject'] ?? '';
                    $start = $item['start_time'] ?? null;
                    $end = $item['end_time'] ?? null;
                    $startTime = strlen($start) === 5 ? $start . ':00' : ($start ?: null);
                    $endTime = strlen($end) === 5 ? $end . ':00' : ($end ?: null);

                    // avoid duplicate: same teacher, day, subject, start_time
                    $exists = \App\Models\Schedule::where('teacher_id', $teacher->id)
                        ->where('day', $day)
                        ->where('subject', $subject)
                        ->where(function ($q) use ($startTime) {
                            if ($startTime) $q->where('start_time', $startTime); else $q->whereNull('start_time');
                        })->exists();

                    if (!$exists) {
                        \App\Models\Schedule::create([
                            'teacher_id' => $teacher->id,
                            'student_id' => null,
                            'subject' => $subject,
                            'day' => $day,
                            'start_time' => $startTime,
                            'end_time' => $endTime,
                            'room' => $item['room'] ?? null,
                        ]);
                        $inserted++;
                    }
                }
            }
        }

        return back()->with('success', "Import selesai. $inserted entri ditambahkan untuk Kelas $selectedClass.");
    }

    /**
     * Show students list
     */
    public function students(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;
        $search = $request->input('search', '');
        // Detect homeroom (same logic as dashboard index)
        $homeroomClass = null;
        if (isset($teacher->homeroom_class) && $teacher->homeroom_class) {
            $homeroomClass = (string) $teacher->homeroom_class;
        } else {
            $topClass = Grade::where('teacher_id', $teacher->id)
                ->join('students', 'grades.student_id', '=', 'students.id')
                ->selectRaw('students.class as class_name, COUNT(*) as cnt')
                ->groupBy('students.class')
                ->orderByDesc('cnt')
                ->first();
            if ($topClass && $topClass->class_name) {
                $homeroomClass = (string) $topClass->class_name;
            }
        }

        // Build list of classes that the teacher teaches (from schedules and grades)
        $classesFromSchedules = \App\Models\Schedule::where('teacher_id', $teacher->id)
            ->whereHas('student', function ($q) { $q->whereNotNull('class'); })
            ->with('student')
            ->get()
            ->pluck('student.class')
            ->filter()
            ->unique()
            ->values();

        $classesFromGrades = Grade::where('teacher_id', $teacher->id)
            ->join('students', 'grades.student_id', '=', 'students.id')
            ->pluck('students.class')
            ->filter()
            ->unique()
            ->values();

        $classesTaught = $classesFromSchedules->merge($classesFromGrades)->unique()->values();

        // If DB has student records and the teacher is wali/selected a class, load from DB
        $selectedClass = trim((string)$request->query('class', ''));

        $students = collect();
        $studentsByClass = collect();

        if (!empty($selectedClass) || !empty($homeroomClass)) {
            $targetClass = !empty($selectedClass) ? $selectedClass : $homeroomClass;
            $dbStudents = Student::with('user')
                ->where('class', $targetClass)
                ->orderBy('nisn')
                ->get();

            if ($dbStudents->isNotEmpty()) {
                $students = $dbStudents->map(function ($s) {
                    $s->id = $s->id;
                    return $s;
                });

                $studentsByClass = collect([$targetClass => $students]);
                return view('teacher.students', [
                    'students' => $students,
                    'studentsByClass' => $studentsByClass,
                    'search' => $search,
                    'homeroomClass' => $homeroomClass,
                    'classesTaught' => $classesTaught,
                    'selectedClass' => $selectedClass,
                ]);
            }
        }

        // Fallback static list when DB data is not present
        $provided = [
            '1' => [
                'Rehan',
                'Nurul hidayah',
                'Yunita kanesha ayra',
                'Salman',
                'Ratna gumilar',
                'Muhammad Ali',
            ],
            '2' => [
                'Rahma gustiani',
                'Vani',
                'M. Azmi ar rosyid',
                'Ajeng ayu',
                'Eti sumiati',
            ],
            '3' => [
                'Neng Anita',
                'Shelia indah Nugraha',
                "Syaidah Muthi'ah ali",
                'Muhammad Alfian',
                'Muhammad Arka',
                'Nur Muhammad firdaus',
                'Rizki Ridho Maulana',
            ],
            '4' => [
                'Mega rindiani',
                'Dea Nadia',
                'Widya selawati',
                'M Amir',
                'Muhammad Dapa Fitriyana',
            ],
            '5' => [
                'Farhan musthofa',
            ],
            '6' => [
                'Ayu Fatimah',
                'Siti Nur Amaliyah',
                'Ikbal Nurhakim',
                'Wildan Al Farizi',
            ],
            '7' => [
                'Mela puspita',
                'Novi putri yudiani',
                'Bagas arka',
            ],
            '8' => [
                'M. Raja syahputra',
                'M. Tamam',
                'Siti sagiva hijrina rijayani',
                'M. Rizky maulana',
                'M. Farid nursyamsi',
                'M. Rafi santika',
                'Suryani',
            ],
            '9' => [
                'Iwan kurniawan',
            ],
            '10' => [
                'Ade selva',
                'Asti ismania sita',
            ],
            '11' => [
                'Alwi ajiz',
            ],
        ];

        $studentsByClass = collect($provided)->map(function ($names, $class) {
            return collect($names)->map(function ($name) use ($class) {
                $student = new \stdClass();
                $student->class = $class;
                $user = new \stdClass();
                $user->name = $name;
                $student->user = $user;
                $student->nisn = '';
                $student->id = null; // static entries have no DB id
                return $student;
            });
        });

        // Provide a flat students collection for views expecting $students
        $students = $studentsByClass->flatten(1);

        return view('teacher.students', [
            'students' => $students,
            'studentsByClass' => $studentsByClass,
            'search' => $search,
            'homeroomClass' => $homeroomClass,
            'classesTaught' => $classesTaught,
            'selectedClass' => $selectedClass,
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

        $selectedStudentId = $request->query('student_id');
        $selectedStudent = null;
        $selectedClass = trim((string) $request->query('class', ''));
        $selectedSubject = trim((string) $request->query('subject', ''));

        if ($selectedStudentId) {
            $selectedStudent = Student::with('user')->find($selectedStudentId);
            if ($selectedStudent && $selectedClass === '') {
                $selectedClass = (string) ($selectedStudent->class ?? '');
            }
        }

        $defaultClasses = ['1A', '2A', '3A', '4A', '5A', '6A'];
        $existingClasses = Student::query()
            ->whereNotNull('class')
            ->distinct()
            ->orderBy('class')
            ->pluck('class')
            ->filter()
            ->values()
            ->toArray();

        $classes = collect($defaultClasses)
            ->merge($existingClasses)
            ->unique()
            ->values();

        $subjects = Grade::where('teacher_id', $teacher->id)
            ->whereNotNull('subject')
            ->distinct()
            ->orderBy('subject')
            ->pluck('subject')
            ->filter()
            ->values();

        $studentQuery = Student::with('user');
        if ($selectedClass !== '') {
            $studentQuery->where('class', $selectedClass);
        }

        $students = $studentQuery->orderBy('nisn')->get();

        $grades = collect();
        if ($selectedStudent) {
            $grades = Grade::where('teacher_id', $teacher->id)
                ->where('student_id', $selectedStudent->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('teacher.grades-simple', [
            'subjects' => $subjects,
            'grades' => $grades,
            'students' => $students,
            'classes' => $classes,
            'selectedStudent' => $selectedStudentId,
            'selectedClass' => $selectedClass,
            'selectedSubject' => $selectedSubject,
            'selectedStudentInfo' => $selectedStudent,
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
            $grade = Grade::updateOrCreate(
                [
                    'teacher_id' => $teacher->id,
                    'student_id' => $validated['student_id'],
                    'subject' => $validated['subject'],
                ],
                [
                    'grade' => $validated['grade'],
                    'notes' => $validated['notes'] ?? null,
                ]
            );
            
            return response()->json([
                'success' => true,
                'message' => $grade->wasRecentlyCreated ? 'Nilai berhasil ditambahkan' : 'Nilai berhasil diperbarui',
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
     * Batch save grades (accepts array of grade objects)
     */
    public function batchSaveGrades(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $validated = $request->validate([
            'grades' => 'required|array|min:1',
            'grades.*.student_id' => 'required|exists:students,id',
            'grades.*.subject' => 'required|string|max:255',
            'grades.*.grade' => 'nullable|numeric|min:0|max:100',
            'grades.*.notes' => 'nullable|string|max:500',
        ]);

        $results = [];
        $saved = 0;
        $failed = 0;

        foreach ($validated['grades'] as $index => $g) {
            try {
                $gradeValue = isset($g['grade']) && $g['grade'] !== '' ? (float) $g['grade'] : null;

                $grade = Grade::updateOrCreate(
                    [
                        'teacher_id' => $teacher->id,
                        'student_id' => $g['student_id'],
                        'subject' => $g['subject'],
                    ],
                    [
                        'grade' => $gradeValue,
                        'notes' => $g['notes'] ?? null,
                    ]
                );

                $results[] = [
                    'index' => $index,
                    'student_id' => $g['student_id'],
                    'subject' => $g['subject'],
                    'success' => true,
                    'grade_id' => $grade->id,
                ];
                $saved++;
            } catch (\Exception $e) {
                $results[] = [
                    'index' => $index,
                    'student_id' => $g['student_id'] ?? null,
                    'subject' => $g['subject'] ?? null,
                    'success' => false,
                    'message' => $e->getMessage(),
                ];
                $failed++;
            }
        }

        return response()->json([
            'success' => $failed === 0,
            'message' => $saved . ' tersimpan, ' . $failed . ' gagal',
            'saved' => $saved,
            'failed' => $failed,
            'results' => $results,
        ]);
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
            $extension = strtolower($file->getClientOriginalExtension());
            
            $imported = 0;
            $failed = 0;
            $errors = [];

            $rows = [];

            if (in_array($extension, ['xlsx', 'xls'], true)) {
                $spreadsheet = IOFactory::load($path);
                $worksheet = $spreadsheet->getActiveSheet();
                foreach ($worksheet->getRowIterator() as $rowIndex => $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    $rowData = [];
                    foreach ($cellIterator as $cell) {
                        $rowData[] = trim((string) $cell->getFormattedValue());
                    }

                    $rows[] = $rowData;
                }
            } else {
                if (($handle = fopen($path, 'r')) !== false) {
                    $sample = fgets($handle);
                    $delimiter = (substr_count((string) $sample, ';') > substr_count((string) $sample, ',')) ? ';' : ',';
                    rewind($handle);

                    while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                        $rows[] = $row;
                    }

                    fclose($handle);
                }
            }

            foreach ($rows as $index => $row) {
                if (count($row) < 3) {
                    $failed++;
                    continue;
                }

                $nisn = trim((string) ($row[0] ?? ''));
                $subject = trim((string) ($row[1] ?? ''));
                $grade = (float) trim((string) ($row[2] ?? ''));
                $notes = isset($row[3]) ? trim((string) $row[3]) : null;

                if ($index === 0) {
                    $firstCell = strtolower($nisn);
                    if (str_contains($firstCell, 'nisn') || str_contains($firstCell, 'nis')) {
                        continue;
                    }
                }

                try {
                    if (empty($nisn) || empty($subject) || $grade < 0 || $grade > 100) {
                        $failed++;
                        continue;
                    }

                    $student = Student::where('nisn', $nisn)->first();

                    if (!$student) {
                        $failed++;
                        continue;
                    }

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
     * Filter students by class and keyword via AJAX.
     */
    public function studentsByClass(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $validated = $request->validate([
            'class' => 'required|string|max:20',
            'search' => 'nullable|string|max:100',
            'subject' => 'nullable|string|max:255',
        ]);

        $search = trim((string) ($validated['search'] ?? ''));
        $subject = trim((string) ($validated['subject'] ?? ''));

        $studentsQuery = Student::with('user')
            ->where('class', $validated['class'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%');
                    })->orWhere('nisn', 'like', '%' . $search . '%');
                });
            });

        $students = $studentsQuery->orderBy('nisn')->limit(50)->get()->map(function ($student) use ($teacher, $subject) {
            $grade = null;

            if ($subject !== '') {
                $grade = Grade::where('teacher_id', $teacher->id)
                    ->where('student_id', $student->id)
                    ->where('subject', $subject)
                    ->first();
            }

            return [
                'id' => $student->id,
                'name' => $student->user->name ?? '-',
                'nisn' => $student->nisn ?? '-',
                'class' => $student->class ?? '-',
                'grade_id' => $grade->id ?? null,
                'grade' => $grade ? $grade->grade : null,
                'notes' => $grade->notes ?? '',
                'updated_at' => $grade ? $grade->updated_at->format('d M Y H:i') : null,
            ];
        });

        return response()->json([
            'success' => true,
            'students' => $students,
        ]);
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
     * Export grades to Excel using PhpSpreadsheet (Improved)
     */
    public function exportGradesExcelProper(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $selectedClass = $request->query('class');
        $selectedStudent = $request->query('student_id');

        $query = Grade::where('teacher_id', $teacher->id)
            ->with(['student' => function ($q) {
                $q->with('user');
            }]);

        if ($selectedClass) {
            $query->whereHas('student', function ($q) use ($selectedClass) {
                $q->where('class', $selectedClass);
            });
        }

        if ($selectedStudent) {
            $query->where('student_id', $selectedStudent);
        }

        $grades = $query->orderBy('subject')->orderBy('created_at', 'desc')->get();

        // Create spreadsheet using PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Nilai');

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(15);

        // Add header
        $sheet->setCellValue('A1', 'LAPORAN NILAI SISWA');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $sheet->setCellValue('A2', 'Guru: ' . $user->name);
        $sheet->mergeCells('A2:G2');
        $sheet->getStyle('A2')->getFont()->setSize(10);

        $sheet->setCellValue('A3', 'Tanggal: ' . date('d-m-Y H:i:s'));
        $sheet->mergeCells('A3:G3');
        $sheet->getStyle('A3')->getFont()->setSize(10);

        // Column headers
        $headers = ['NISN', 'Nama Siswa', 'Kelas', 'Mata Pelajaran', 'Nilai', 'Keterangan', 'Tanggal'];
        foreach ($headers as $col => $header) {
            $sheet->setCellValueByColumnAndRow($col + 1, 5, $header);
            $sheet->getStyle('A5:G5')->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'));
            $sheet->getStyle('A5:G5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FF2D4438'); // Green color
        }

        // Add data
        $row = 6;
        foreach ($grades as $grade) {
            $sheet->setCellValueByColumnAndRow(1, $row, $grade->student->nisn ?? '-');
            $sheet->setCellValueByColumnAndRow(2, $row, $grade->student->user->name ?? '-');
            $sheet->setCellValueByColumnAndRow(3, $row, $grade->student->class ?? '-');
            $sheet->setCellValueByColumnAndRow(4, $row, $grade->subject);
            $sheet->setCellValueByColumnAndRow(5, $row, $grade->grade);
            $sheet->setCellValueByColumnAndRow(6, $row, $grade->notes ?? '-');
            $sheet->setCellValueByColumnAndRow(7, $row, $grade->created_at->format('d-m-Y'));

            // Number format for grade column
            $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('0.00');

            $row++;
        }

        // Add totals/stats row
        if ($grades->count() > 0) {
            $avgRow = $row + 1;
            $sheet->setCellValue('A' . $avgRow, 'Statistik:');
            $sheet->setCellValue('D' . $avgRow, 'Rata-rata Nilai:');
            $sheet->setCellValue('E' . $avgRow, $grades->avg('grade'));
            $sheet->getStyle('E' . $avgRow)->getNumberFormat()->setFormatCode('0.00');
            $sheet->getStyle('D' . $avgRow . ':E' . $avgRow)->getFont()->setBold(true);
        }

        // Output file
        $filename = 'Laporan_Nilai_' . ($selectedClass ? $selectedClass : 'Semua') . '_' . date('Y-m-d_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Get report summary data for a class
     */
    public function getReportSummary(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $selectedClass = $request->query('class');

        if (!$selectedClass) {
            return view('teacher.report-summary', [
                'classes' => collect(),
                'selectedClass' => null,
                'students' => collect(),
                'summary' => null,
            ]);
        }

        // Get all students in the class
        $students = Student::where('class', $selectedClass)
            ->with('user')
            ->orderBy('nisn')
            ->get();

        // Get all grades for these students from this teacher
        $studentIds = $students->pluck('id');
        $grades = Grade::where('teacher_id', $teacher->id)
            ->whereIn('student_id', $studentIds)
            ->get();

        // Group by student and calculate stats
        $studentSummary = [];
        foreach ($students as $student) {
            $studentGrades = $grades->where('student_id', $student->id);
            $avg = $studentGrades->avg('grade') ?? 0;
            $totalSubjects = $studentGrades->count();

            $studentSummary[] = [
                'student' => $student,
                'grades' => $studentGrades,
                'average' => $avg,
                'total_subjects' => $totalSubjects,
                'status' => $avg >= 70 ? 'Lulus' : 'Butuh Remediasi',
            ];
        }

        $classStudents = Student::where('class', $selectedClass)->distinct('class')->get();
        $classes = ['1A', '2A', '3A', '4A', '5A', '6A'];

        return view('teacher.report-summary', [
            'classes' => collect($classes),
            'selectedClass' => $selectedClass,
            'students' => $students,
            'studentSummary' => $studentSummary,
            'averageClass' => collect($studentSummary)->avg('average'),
        ]);
    }

    /**
     * Export report summary to PDF
     */
    public function exportReportPDF(Request $request)
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $selectedClass = $request->query('class');

        if (!$selectedClass) {
            return redirect()->route('teacher.grades')->with('error', 'Pilih kelas terlebih dahulu');
        }

        $students = Student::where('class', $selectedClass)
            ->with('user')
            ->orderBy('nisn')
            ->get();

        $studentIds = $students->pluck('id');
        $grades = Grade::where('teacher_id', $teacher->id)
            ->whereIn('student_id', $studentIds)
            ->get();

        $studentSummary = [];
        foreach ($students as $student) {
            $studentGrades = $grades->where('student_id', $student->id);
            $avg = $studentGrades->avg('grade') ?? 0;
            $totalSubjects = $studentGrades->count();

            $studentSummary[] = [
                'student' => $student,
                'average' => $avg,
                'total_subjects' => $totalSubjects,
                'status' => $avg >= 70 ? 'Lulus' : 'Butuh Remediasi',
            ];
        }

        // Use dompdf if available, otherwise return view for manual PDF generation
        $html = view('teacher.report-pdf', [
            'teacher' => $teacher,
            'user' => $user,
            'selectedClass' => $selectedClass,
            'studentSummary' => $studentSummary,
            'averageClass' => collect($studentSummary)->avg('average'),
        ])->render();

        $filename = 'Laporan_Kelas_' . $selectedClass . '_' . date('Y-m-d_His') . '.html';
        header('Content-Type: text/html; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        return $html;
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
        $announcements = Announcement::where('status', 'aktif')->orderBy('created_at', 'desc')->get();

        return view('teacher.informasi', [
            'announcements' => $announcements,
        ]);
    }

    /**
     * Show teacher kegiatan page
     */
    public function kegiatan()
    {
        $activities = Activity::orderBy('tanggal', 'desc')->get();

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

