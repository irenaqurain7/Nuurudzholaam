<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\FAQ;
use App\Models\PPDBRegistration;
use App\Models\Program;
use App\Models\SchoolInfo;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Schedule;
use App\Exports\PPDBExcelExport;
use App\Services\PPDBExportService;
use App\Services\BulkUserValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\ScheduleImportService;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AdminController extends Controller
{
    // DASHBOARD
    public function dashboard()
    {
        $totalUsers = \App\Models\User::count();
        $totalSiswa = \App\Models\User::where('role', 'siswa')->count();
        $totalGuru = \App\Models\User::where('role', 'guru')->count();
        $totalPPDB = \App\Models\PPDBRegistration::count();

        // PPDB registrations by level (case-insensitive check)
        $ppdbTK = \App\Models\PPDBRegistration::whereRaw('LOWER(jenjang) = ?', ['tk'])->count();
        $ppdbSD = \App\Models\PPDBRegistration::whereRaw('LOWER(jenjang) = ?', ['sd'])->count();
        $ppdbSMP = \App\Models\PPDBRegistration::whereRaw('LOWER(jenjang) = ?', ['smp'])->count();
        $ppdbSMK = \App\Models\PPDBRegistration::whereRaw('LOWER(jenjang) = ?', ['smk'])->count();

        // PPDB progress statistics
        $ppdbPending = \App\Models\PPDBRegistration::where('status', 'pending')->count();
        $ppdbApproved = \App\Models\PPDBRegistration::where('status', 'diterima')->count();
        $ppdbRejected = \App\Models\PPDBRegistration::where('status', 'ditolak')->count();

        // Latest registrations (max 5)
        $latestRegistrations = \App\Models\PPDBRegistration::orderBy('tgl_daftar', 'desc')->limit(5)->get();

        // Latest announcements (max 3)
        $latestAnnouncements = \App\Models\Announcement::orderBy('created_at', 'desc')->limit(3)->get();

        // Today's schedule summary
        $todayEnglish = \Carbon\Carbon::now()->format('l');
        $dayMap = [
            'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
        ];
        $todayIndonesian = $dayMap[$todayEnglish] ?? $todayEnglish;

        $todayTeacherSchedule = \App\Models\Schedule::whereIn('day', [$todayEnglish, $todayIndonesian])->count();

        $todayStudentSchedule = 0;
        $studentSchedulesToday = \App\Models\StudentSchedule::whereIn('day', [$todayEnglish, $todayIndonesian])->get();
        if ($studentSchedulesToday->isNotEmpty()) {
            foreach ($studentSchedulesToday as $ss) {
                if (is_array($ss->activities)) {
                    $todayStudentSchedule += count($ss->activities);
                } else {
                    $todayStudentSchedule++;
                }
            }
        } else {
            $todayStudentSchedule = \App\Models\Schedule::whereNotNull('class')->whereIn('day', [$todayEnglish, $todayIndonesian])->count();
        }

        // Recent Activities feed
        $recentActivities = collect();

        // 1. Fetch recent users
        $recentUsers = \App\Models\User::orderBy('created_at', 'desc')->limit(5)->get();
        foreach ($recentUsers as $u) {
            $roleName = $u->role === 'guru' ? 'Guru' : ($u->role === 'siswa' ? 'Siswa' : 'User');
            $recentActivities->push([
                'time' => $u->created_at ?: now(),
                'icon' => 'fas fa-user-plus',
                'color' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                'message' => "{$roleName} baru ditambahkan: <strong>{$u->name}</strong>"
            ]);
        }

        // 2. Fetch recent announcements
        $recentAnnouncements = \App\Models\Announcement::orderBy('created_at', 'desc')->limit(5)->get();
        foreach ($recentAnnouncements as $a) {
            $recentActivities->push([
                'time' => $a->created_at ?: now(),
                'icon' => 'fas fa-bullhorn',
                'color' => 'bg-blue-100 text-blue-800 border-blue-200',
                'message' => "Pengumuman baru diterbitkan: <strong>{$a->judul}</strong>"
            ]);
        }

        // 3. Fetch recent PPDB registrations
        $recentPPDB = \App\Models\PPDBRegistration::orderBy('tgl_daftar', 'desc')->limit(5)->get();
        foreach ($recentPPDB as $p) {
            $recentActivities->push([
                'time' => $p->tgl_daftar ?: $p->created_at ?: now(),
                'icon' => 'fas fa-file-signature',
                'color' => 'bg-amber-100 text-amber-800 border-amber-200',
                'message' => "Pendaftar PPDB baru masuk: <strong>{$p->nama_lengkap}</strong> (" . strtoupper($p->jenjang) . ")"
            ]);
        }

        // Sort all activities by time descending and take 5
        $recentActivities = $recentActivities->sortByDesc('time')->take(5);

        return view('admin.dashboard', compact(
            'totalUsers', 'totalSiswa', 'totalGuru', 'totalPPDB',
            'ppdbTK', 'ppdbSD', 'ppdbSMP', 'ppdbSMK',
            'ppdbPending', 'ppdbApproved', 'ppdbRejected',
            'latestRegistrations', 'latestAnnouncements',
            'todayTeacherSchedule', 'todayStudentSchedule',
            'recentActivities'
        ));
    }

    // PPDB REGISTRATIONS
    public function ppdbIndex(Request $request, PPDBExportService $ppdbExportService)
    {
        $registrations = $ppdbExportService->filteredQuery($request)
            ->orderBy('tgl_daftar', 'desc')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.ppdb.index', compact('registrations'));
    }

    public function ppdbShow($id)
    {
        $registration = PPDBRegistration::findOrFail($id);
        return view('admin.ppdb.show', compact('registration'));
    }

    public function ppdbUpdateStatus($id, $status)
    {
        $registration = PPDBRegistration::findOrFail($id);
        $registration->update(['status' => $status]);
        return redirect()->back()->with('success', 'Status pendaftar diperbarui.');
    }

    public function ppdbExport(Request $request, PPDBExportService $ppdbExportService)
    {
        return $this->ppdbExportExcel($request, $ppdbExportService);
    }

    public function ppdbExportExcel(Request $request, PPDBExportService $ppdbExportService)
    {
        $registrations = $ppdbExportService->filteredQuery($request)
            ->orderBy('tgl_daftar', 'desc')
            ->orderByDesc('id')
            ->get();

        $rows = $ppdbExportService->mapExportRows($registrations);

        $school = SchoolInfo::first();
        $export = new PPDBExcelExport(
            $rows,
            $school?->nama_sekolah ?? config('app.name', 'Sekolah Nururudzholam'),
            now()->format('d-m-Y')
        );

        $filename = 'data_pendaftar_ppdb_' . now()->format('Y-m-d_His') . '.xlsx';

        return response()->streamDownload(function () use ($export) {
            $export->output();
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function ppdbExportPdf(Request $request, PPDBExportService $ppdbExportService)
    {
        $registrations = $ppdbExportService->filteredQuery($request)
            ->orderBy('tgl_daftar', 'desc')
            ->orderByDesc('id')
            ->get();

        $school = SchoolInfo::first();

        $logoBase64 = null;
        if ($school && $school->logo) {
            $logoPath = storage_path('app/public/' . $school->logo);

            if (file_exists($logoPath)) {
            $logoBase64 = 'data:' . mime_content_type($logoPath) . ';base64,' . base64_encode(file_get_contents($logoPath));
            }
        }

        $rows = $ppdbExportService->mapExportRows($registrations);

        $pdf = Pdf::loadView('admin.ppdb.export-pdf', [
            'school' => $school,
            'logoBase64' => $logoBase64,
            'rows' => $rows,
            'totalData' => $rows->count(),
            'exportDate' => now()->format('d-m-Y H:i'),
        ])->setPaper('a4', 'landscape');

        $filename = 'data_pendaftar_ppdb_' . now()->format('Y-m-d_His') . '.pdf';

        return $pdf->download($filename);
    }

    // PROGRAMS
    public function programIndex(Request $request)
    {
        $query = Program::query();

        if ($request->filled('search')) {
            $query->where('nama_program', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }

        $programs = $query->paginate(10)->withQueryString();
        return view('admin.program.index', compact('programs'));
    }

    public function programCreate()
    {
        return view('admin.program.create');
    }

    public function programStore(Request $request)
    {
        $validated = $request->validate([
            'nama_program' => 'required|string',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('programs', 'public');
        }

        Program::create($validated);
        return redirect()->route('admin.program.index')->with('success', 'Program berhasil ditambahkan.');
    }

    public function programEdit($id)
    {
        $program = Program::findOrFail($id);
        return view('admin.program.edit', compact('program'));
    }

    public function programUpdate(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        $validated = $request->validate([
            'nama_program' => 'required|string',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('programs', 'public');
        }

        $program->update($validated);
        return redirect()->route('admin.program.index')->with('success', 'Program berhasil diperbarui.');
    }

    public function programDestroy($id)
    {
        Program::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Program berhasil dihapus.');
    }

    // ACTIVITIES
    public function activityIndex(Request $request)
    {
        $query = Activity::query();

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('visibility')) {
            $query->where('visibility', $request->visibility);
        }

        $activities = $query->orderBy('tanggal', 'desc')->paginate(10)->withQueryString();
        return view('admin.activity.index', compact('activities'));
    }

    public function activityCreate()
    {
        return view('admin.activity.create');
    }

    public function activityStore(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'kategori' => 'required|in:kegiatan,dokumentasi,berita,pengumuman',
            'visibility' => 'required|in:guru,ortu,publik',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('activities', 'public');
        }

        Activity::create($validated);
        return redirect()->route('admin.activity.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function activityEdit($id)
    {
        $activity = Activity::findOrFail($id);
        return view('admin.activity.edit', compact('activity'));
    }

    public function activityUpdate(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'kategori' => 'required|in:kegiatan,dokumentasi,berita,pengumuman',
            'visibility' => 'required|in:guru,ortu,publik',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('activities', 'public');
        }

        $activity->update($validated);
        return redirect()->route('admin.activity.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function activityDestroy($id)
    {
        Activity::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Kegiatan berhasil dihapus.');
    }

    // Update activity descriptions
    public function activityUpdateDescriptions()
    {
        $descriptions = [
            'Buka Bersama (Iftar Bersama)' => 'Kegiatan buka bersama atau iftar bersama merupakan salah satu program rutin sekolah untuk mempererat hubungan antar warga sekolah. Kegiatan ini dilakukan untuk membangun kebersamaan dan saling berbagi dalam suasana yang hangat.',
            'Hari Santri Nasional' => 'Peringatan Hari Santri Nasional merupakan momentum untuk mengenang jasa para santri dalam mempertahankan kemerdekaan Indonesia. Sekolah mengadakan berbagai kegiatan edukatif untuk memahami peran santri dalam sejarah bangsa.',
            'Maulid Nabi Muhammad' => 'Peringatan Maulid Nabi Muhammad SAW adalah tradisi tahunan untuk merayakan kelahiran Nabi Muhammad. Sekolah menyelenggarakan rangkaian acara yang penuh makna untuk meningkatkan penghayatan nilai-nilai Islam.',
            'Memperingati Hari Guru' => 'Peringatan Hari Guru Nasional adalah momen apresiasi kepada seluruh guru yang telah berdedikasi dalam pendidikan. Sekolah mengadakan berbagai kegiatan untuk menghargai jasa-jasa guru.',
            'Memperingati Hari Kartini' => 'Peringatan Hari Kartini adalah upaya untuk mengenang semangat perjuangan R.A. Kartini dalam memperjuangkan pendidikan wanita. Kegiatan ini menginspirasi siswa siswi untuk terus berkontribusi bagi bangsa.',
            'Memperingati Hari Pramuka' => 'Hari Pramuka merupakan hari bersejarah bagi gerakan kepramukaan di Indonesia. Sekolah merayakan dengan mengadakan berbagai aktivitas outdoor dan pelatihan kepramukaan.',
            'Pentas Seni (Perpisahan Sekolah)' => 'Pentas seni perpisahan sekolah adalah ajang apresiasi atas karya seni siswa selama menuntut ilmu di sekolah. Acara ini menampilkan berbagai pertunjukan seni dari musik, tari, dan drama.',
            'Santunan Anak Yatim dan Piatu' => 'Program santunan anak yatim dan piatu adalah wujud kepedulian sekolah terhadap sesama. Kegiatan ini mengajarkan siswa tentang pentingnya berbagi dan membantu mereka yang membutuhkan.'
        ];

        foreach ($descriptions as $title => $desc) {
            Activity::where('judul', $title)->update(['deskripsi' => $desc]);
        }

        return redirect()->route('admin.activity.index')->with('success', 'Deskripsi kegiatan berhasil diperbarui.');
    }

    // ANNOUNCEMENTS
    public function announcementIndex()
    {
        $announcements = Announcement::orderBy('tanggal_mulai', 'desc')->paginate(10);
        return view('admin.announcement.index', compact('announcements'));
    }

    public function announcementCreate()
    {
        return view('admin.announcement.create');
    }

    public function announcementStore(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string',
            'konten' => 'required|string',
            'tipe' => 'required|in:umum,ppdb,libur,penting',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,arsip',
        ]);

        Announcement::create($validated);
        return redirect()->route('admin.announcement.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function announcementEdit($id)
    {
        $announcement = Announcement::findOrFail($id);
        return view('admin.announcement.edit', compact('announcement'));
    }

    public function announcementUpdate(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string',
            'konten' => 'required|string',
            'tipe' => 'required|in:umum,ppdb,libur,penting',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,arsip',
        ]);

        $announcement->update($validated);
        return redirect()->route('admin.announcement.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function announcementDestroy($id)
    {
        Announcement::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Pengumuman berhasil dihapus.');
    }

    // FAQS
    public function faqIndex(Request $request)
    {
        $query = FAQ::query();

        if ($request->filled('search')) {
            $query->where('pertanyaan', 'like', '%' . $request->search . '%')
                  ->orWhere('jawaban', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $faqs = $query->orderBy('urutan')->paginate(10)->withQueryString();
        return view('admin.faq.index', compact('faqs'));
    }

    public function faqCreate()
    {
        return view('admin.faq.create');
    }

    public function faqStore(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
            'kategori' => 'required|in:umum,ppdb,akademik,fasilitas',
            'urutan' => 'required|integer',
        ]);

        FAQ::create($validated);
        return redirect()->route('admin.faq.index')->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function faqEdit($id)
    {
        $faq = FAQ::findOrFail($id);
        return view('admin.faq.edit', compact('faq'));
    }

    public function faqUpdate(Request $request, $id)
    {
        $faq = FAQ::findOrFail($id);

        $validated = $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
            'kategori' => 'required|in:umum,ppdb,akademik,fasilitas',
            'urutan' => 'required|integer',
        ]);

        $faq->update($validated);
        return redirect()->route('admin.faq.index')->with('success', 'FAQ berhasil diperbarui.');
    }

    public function faqDestroy($id)
    {
        FAQ::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'FAQ berhasil dihapus.');
    }

    // SCHOOL INFO
    public function schoolInfoEdit()
    {
        $school = SchoolInfo::first() ?? new SchoolInfo();
        return view('admin.school-info.edit', compact('school'));
    }

    public function schoolInfoUpdate(Request $request)
    {
        $validated = $request->validate([
            'nama_sekolah' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'gambar_utama' => 'nullable|image|max:2048',
            'ppdb_active' => 'nullable|boolean',
            'ppdb_start_date' => 'nullable|date',
            'ppdb_end_date' => 'nullable|date|after_or_equal:ppdb_start_date',
            'pilar_pendidikan' => 'nullable|array',
            'pilar_pendidikan.*.icon' => 'nullable|string',
            'pilar_pendidikan.*.judul' => 'nullable|string',
            'pilar_pendidikan.*.deskripsi' => 'nullable|string',
        ]);

        $school = SchoolInfo::first() ?? new SchoolInfo();

        $updates = [];

        // Only set fields that were provided (non-empty) to avoid overwriting existing data with empty values
        $fields = ['nama_sekolah','deskripsi','visi','misi','alamat','no_telepon','email','website','pilar_pendidikan','ppdb_start_date','ppdb_end_date'];
        foreach ($fields as $f) {
            if ($request->filled($f)) {
                $updates[$f] = $request->input($f);
            }
        }

        // Files: logo and gambar_utama
        if ($request->hasFile('logo')) {
            $updates['logo'] = $request->file('logo')->store('school', 'public');
        }

        if ($request->hasFile('gambar_utama')) {
            $updates['gambar_utama'] = $request->file('gambar_utama')->store('school', 'public');
        }

        // Checkbox: always set based on presence
        $updates['ppdb_active'] = $request->has('ppdb_active');

        if ($school->exists) {
            if (!empty($updates)) {
                $school->update($updates);
            }
        } else {
            // For create, use validated values (some may be null)
            $createData = array_merge($validated, ['ppdb_active' => $request->has('ppdb_active')]);
            SchoolInfo::create($createData);
        }

        return redirect()->back()->with('success', 'Informasi sekolah berhasil diperbarui.');
    }

    // PPDB SETTINGS
    public function ppdbSettingsEdit()
    {
        $school = SchoolInfo::first() ?? new SchoolInfo();
        return view('admin.ppdb.settings', compact('school'));
    }

    public function ppdbSettingsUpdate(Request $request)
    {
        $school = SchoolInfo::first();

        // Jika belum ada school info, buat baru dengan data minimal
        if (!$school) {
            $school = SchoolInfo::create([
                'nama_sekolah' => 'Sekolah Nuurudzholaam',
                'deskripsi' => 'Deskripsi sekolah belum diisi. Silakan update di halaman Informasi Sekolah.',
                'alamat' => 'Alamat belum diisi',
                'no_telepon' => '-',
                'email' => 'info@nuurudzholaam.sch.id',
            ]);
        }

        $validated = $request->validate([
            'ppdb_active' => 'nullable|boolean',
            'ppdb_start_date' => 'nullable|date',
            'ppdb_end_date' => 'nullable|date|after_or_equal:ppdb_start_date',
        ]);

        // Handle checkbox conversion
        $validated['ppdb_active'] = $request->has('ppdb_active');

        $school->update($validated);
        return redirect()->back()->with('success', 'Pengaturan PPDB berhasil diperbarui.');
    }

    // USER MANAGEMENT
    public function usersIndex(Request $request)
    {
        $query = User::with(['student', 'teacher'])->where('role', '!=', 'admin');

        // Search logic
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($sq) use ($search) {
                      $sq->where('nisn', 'like', "%{$search}%");
                  })
                  ->orWhereHas('teacher', function ($tq) use ($search) {
                      $tq->where('nip', 'like', "%{$search}%");
                  });
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Jenjang filter (only applies to siswa)
        if ($request->filled('jenjang')) {
            $jenjang = $request->jenjang;
            $query->whereHas('student', function ($q) use ($jenjang) {
                $q->where('jenjang', $jenjang);
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Global stats (unfiltered)
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalOrangtua = User::where('role', 'orangtua')->count();

        return view('admin.users.index', compact('users', 'totalSiswa', 'totalGuru', 'totalOrangtua'));
    }

    public function usersCreate()
    {
        return view('admin.users.create');
    }

    public function usersStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:siswa,guru',
            'jenjang' => 'required_if:role,siswa|in:TK,SD,SMP,SMK|nullable',
            'nisn' => [
                Rule::requiredIf(fn () => $request->role == 'siswa' && $request->jenjang != 'TK'),
                'nullable',
                'unique:users'
            ],
            'class' => 'required_if:role,siswa|nullable|string',
            'nip' => 'required_if:role,guru|nullable|unique:users',
            'specialization' => 'required_if:role,guru|nullable|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000',
            'profile_photo' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        $user = User::create($validated);

        // Create related records
        if ($user->role === 'siswa') {
            Student::create([
                'user_id' => $user->id,
                'jenjang' => $validated['jenjang'] ?? 'SD',
                'nisn' => $validated['nisn'],
                'class' => $validated['class'],
            ]);
        } elseif ($user->role === 'guru') {
            Teacher::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'],
                'specialization' => $validated['specialization'],
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat.');
    }

    public function usersEdit($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin') {
            abort(403);
        }
        return view('admin.users.edit', compact('user'));
    }

    public function usersUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:siswa,guru',
            'jenjang' => 'required_if:role,siswa|in:TK,SD,SMP,SMK|nullable',
            'nisn' => [
                Rule::requiredIf(fn () => $request->role == 'siswa' && $request->jenjang != 'TK'),
                'nullable',
                'unique:users,nisn,' . $user->id
            ],
            'class' => 'required_if:role,siswa|nullable|string',
            'nip' => 'required_if:role,guru|nullable|unique:users,nip,' . $user->id,
            'specialization' => 'required_if:role,guru|nullable|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000',
            'profile_photo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        } else {
            unset($validated['profile_photo']);
        }

        $user->update($validated);

        if ($validated['role'] === 'siswa') {
            if ($user->teacher) {
                $user->teacher()->delete();
            }

            if ($user->student) {
                $user->student->update([
                    'jenjang' => $validated['jenjang'] ?? 'SD',
                    'nisn' => $validated['nisn'],
                    'class' => $validated['class'],
                ]);
            } else {
                Student::create([
                    'user_id' => $user->id,
                    'jenjang' => $validated['jenjang'] ?? 'SD',
                    'nisn' => $validated['nisn'],
                    'class' => $validated['class'],
                ]);
            }
        } else {
            if ($user->student) {
                $user->student()->delete();
            }

            if ($user->teacher) {
                $user->teacher->update([
                    'nip' => $validated['nip'],
                    'specialization' => $validated['specialization'],
                ]);
            } else {
                Teacher::create([
                    'user_id' => $user->id,
                    'nip' => $validated['nip'],
                    'specialization' => $validated['specialization'],
                ]);
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function usersDelete($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function usersResetPassword($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            abort(403);
        }

        // Generate temporary password
        $tempPassword = 'Sekolah@' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $user->update(['password' => Hash::make($tempPassword)]);

        return redirect()->back()->with('success', 'Password telah direset ke: ' . $tempPassword . ' (harap segera ubah password saat login pertama)');
    }

    // TEACHER SCHEDULES (Monitoring Dashboard)
    public function scheduleTeacherIndex(Request $request)
    {
        // 1. Fetch all teachers (role = guru) first, apply search filter if any
        $teachersQuery = \App\Models\User::where('role', 'guru');

        if ($request->filled('search_guru')) {
            $search = $request->search_guru;
            $teachersQuery->where('name', 'like', '%' . $search . '%');
        }

        $teachers = $teachersQuery->get();
        $groupedSchedules = [];

        foreach ($teachers as $user) {
            // Get or create Teacher profile
            $teacher = $user->teacher;
            if (!$teacher) {
                $teacher = \App\Models\Teacher::create([
                    'user_id' => $user->id,
                    'nip' => '-' . $user->id,
                    'specialization' => '-'
                ]);
            }

            $teacherId = $teacher->id;
            $groupedSchedules[$teacherId] = [
                'teacher_id' => $teacherId,
                'name' => $user->name,
                'subjects' => [],
                'total_classes' => [],
                'total_minutes' => 0,
                'schedules' => [],
                'has_conflict' => false
            ];
        }

        // 2. Fetch schedules
        $query = Schedule::with('teacher.user');

        if ($request->filled('level')) {
            $query->where('education_level', $request->level);
        }

        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }

        if ($request->filled('search_guru')) {
            $search = $request->search_guru;
            $query->whereHas('teacher.user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $schedules = $query->get();

        // Agregasi untuk statistik ringkas
        $totalGuru = \App\Models\User::where('role', 'guru')->count();
        $guruMemilikiJadwal = $schedules->pluck('teacher_id')->filter()->unique()->count();
        $totalJadwal = $schedules->count();
        $totalKonflik = 0;

        foreach ($schedules as $schedule) {
            $teacherId = $schedule->teacher_id;

            // Skip if teacher_id is null or if this teacher wasn't found in our predefined list
            // (e.g. if their role changed but schedule remained, though rare)
            if (!$teacherId || !isset($groupedSchedules[$teacherId])) continue;

            // Collect unique subjects
            if ($schedule->subject) {
                $groupedSchedules[$teacherId]['subjects'][$schedule->subject] = true;
            }

            // Collect unique classes
            if ($schedule->class) {
                $groupedSchedules[$teacherId]['total_classes'][$schedule->class] = true;
            }

            // Calculate duration
            if ($schedule->start_time && $schedule->end_time) {
                $start = \Carbon\Carbon::parse($schedule->start_time);
                $end = \Carbon\Carbon::parse($schedule->end_time);
                $diff = $start->diffInMinutes($end);
                $groupedSchedules[$teacherId]['total_minutes'] += $diff;
            }

            $groupedSchedules[$teacherId]['schedules'][] = $schedule;
        }

        // Detect conflicts for each teacher
        foreach ($groupedSchedules as $teacherId => &$data) {
            $teacherSchedules = collect($data['schedules']);

            // Group by day to check overlaps
            $byDay = $teacherSchedules->groupBy('day');
            $hasConflict = false;

            foreach ($byDay as $day => $dailySchedules) {
                // Sort by start_time
                $sorted = $dailySchedules->sortBy('start_time')->values();

                for ($i = 0; $i < $sorted->count() - 1; $i++) {
                    $current = $sorted[$i];
                    $next = $sorted[$i + 1];

                    // Logic overlap: next start_time < current end_time
                    // but we also ensure they are distinct schedules if they have different classes
                    if ($current->end_time > $next->start_time && $current->id !== $next->id) {
                        $hasConflict = true;
                        break 2; // break both loops
                    }
                }
            }

            $data['has_conflict'] = $hasConflict;
            if ($hasConflict) {
                $totalKonflik++;
            }

            // Convert array keys to string and count
            $data['classes_str'] = implode(', ', array_keys($data['total_classes']));
            $data['total_classes'] = count($data['total_classes']);
            $data['subjects_str'] = implode(', ', array_keys($data['subjects']));

            // Format total duration (hours and minutes)
            $hours = floor($data['total_minutes'] / 60);
            $minutes = $data['total_minutes'] % 60;
            $data['formatted_duration'] = ($hours > 0 ? $hours . ' Jam ' : '') . ($minutes > 0 ? $minutes . ' Menit' : '');
            if ($data['formatted_duration'] == '') $data['formatted_duration'] = '0 Menit';
        }

        // Sort by teacher name
        usort($groupedSchedules, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        // Convert array to pagination-like structure or just pass as array since it's grouped.
        // If we need pagination, we can manually slice it. For now, we'll pass the full grouped array.
        // A custom paginator can be created if needed, but for dashboard grouping, array is fine.

        // Paginate the grouped results
        $page = $request->get('page', 1);
        $perPage = 15;
        $offset = ($page - 1) * $perPage;
        $paginatedItems = array_slice($groupedSchedules, $offset, $perPage);
        $groupedSchedulesPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedItems,
            count($groupedSchedules),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.schedule.teacher.index', compact(
            'groupedSchedulesPaginated',
            'totalGuru',
            'guruMemilikiJadwal',
            'totalJadwal',
            'totalKonflik'
        ));
    }

    public function scheduleTeacherShow($id)
    {
        $teacher = \App\Models\Teacher::with(['user', 'schedules' => function($q) {
            $q->orderBy('day')->orderBy('start_time');
        }])->findOrFail($id);

        $schedules = $teacher->schedules;

        $subjects = [];
        $classes = [];
        $totalMinutes = 0;

        foreach ($schedules as $schedule) {
            if ($schedule->subject) $subjects[$schedule->subject] = true;
            if ($schedule->class) $classes[$schedule->class] = true;

            if ($schedule->start_time && $schedule->end_time) {
                $start = \Carbon\Carbon::parse($schedule->start_time);
                $end = \Carbon\Carbon::parse($schedule->end_time);
                $totalMinutes += $start->diffInMinutes($end);
            }
        }

        $subjectsStr = implode(', ', array_keys($subjects));
        $classesStr = implode(', ', array_keys($classes));
        $totalClasses = count($classes);

        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        $formattedDuration = ($hours > 0 ? $hours . ' Jam ' : '') . ($minutes > 0 ? $minutes . ' Menit' : '');
        if ($formattedDuration == '') $formattedDuration = '0 Menit';

        // Detect conflicts
        $hasConflict = false;
        $byDay = $schedules->groupBy('day');
        foreach ($byDay as $day => $dailySchedules) {
            $sorted = $dailySchedules->sortBy('start_time')->values();
            for ($i = 0; $i < $sorted->count() - 1; $i++) {
                if ($sorted[$i]->end_time > $sorted[$i + 1]->start_time && $sorted[$i]->id !== $sorted[$i + 1]->id) {
                    $hasConflict = true;
                    break 2;
                }
            }
        }

        return view('admin.schedule.teacher.show', compact(
            'teacher', 'schedules', 'subjectsStr', 'classesStr', 'totalClasses', 'formattedDuration', 'hasConflict'
        ));
    }

    // STUDENT SCHEDULES (SD-friendly: activities list per class & day)
    public function scheduleStudentIndex()
    {
        $allSchedules = \App\Models\Schedule::with('teacher.user')->orderBy('class')->orderBy('day')->orderBy('start_time')->get();
        $schedules = \App\Models\Schedule::with('teacher.user')->orderBy('class')->orderBy('day')->orderBy('start_time')->paginate(15);

        return view('admin.schedule.student.index', compact('schedules', 'allSchedules'));
    }

    public function scheduleStudentCreate()
    {
        // Redirect to new wizard step 1
        return redirect()->route('admin.schedule.student.wizard.step1');
    }

    public function scheduleStudentStore(Request $request)
    {
        // Not used directly anymore, replaced by wizard
        return redirect()->route('admin.schedule.student.wizard.step1');
    }

    public function scheduleStudentEdit($id)
    {
        $schedule = \App\Models\Schedule::findOrFail($id);
        $teachers = \App\Models\Teacher::with('user')->get();
        $educationLevels = ['TK', 'SD', 'SMP', 'SMK'];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return view('admin.schedule.student.edit', compact('schedule', 'teachers', 'educationLevels', 'days'));
    }

    public function scheduleStudentUpdate(Request $request, $id)
    {
        $schedule = \App\Models\Schedule::findOrFail($id);

        $validated = $request->validate([
            'education_level' => 'required|string',
            'class' => 'required|string',
            'subject' => 'required|string',
            'teacher_id' => 'required|exists:teachers,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ], [
            'education_level.required' => 'Jenjang harus dipilih',
            'class.required' => 'Kelas harus diisi',
            'subject.required' => 'Mata pelajaran harus diisi',
            'teacher_id.required' => 'Guru harus dipilih',
            'end_time.after' => 'Jam selesai harus lebih besar dari jam mulai'
        ]);

        // Cek Konflik Guru
        $guruKonflik = \App\Models\Schedule::where('teacher_id', $validated['teacher_id'])
            ->where('day', $validated['day'])
            ->where('id', '!=', $id)
            ->where(function($query) use ($validated) {
                // start_time or end_time inside another schedule
                $query->where(function($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>', $validated['start_time']);
                });
            })->first();

        if ($guruKonflik) {
            return back()->withErrors(['teacher_id' => 'Konflik Guru: Guru ini sudah memiliki jadwal mengajar lain pada hari dan jam tersebut.'])->withInput();
        }

        // Cek Konflik Kelas
        $kelasKonflik = \App\Models\Schedule::where('class', $validated['class'])
            ->where('day', $validated['day'])
            ->where('id', '!=', $id)
            ->where(function($query) use ($validated) {
                $query->where(function($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>', $validated['start_time']);
                });
            })->first();

        if ($kelasKonflik) {
            return back()->withErrors(['class' => 'Konflik Kelas: Kelas ini sudah memiliki mata pelajaran lain pada hari dan jam tersebut.'])->withInput();
        }

        $schedule->update([
            'education_level' => $validated['education_level'],
            'class' => $validated['class'],
            'subject' => $validated['subject'],
            'teacher_id' => $validated['teacher_id'],
            'day' => $validated['day'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);

        return redirect()->route('admin.schedule.student.index')->with('success', 'Jadwal siswa berhasil diperbarui.');
    }

    public function scheduleStudentDestroy($id)
    {
        $schedule = \App\Models\Schedule::findOrFail($id);
        $schedule->delete();
        return redirect()->back()->with('success', 'Jadwal siswa berhasil dihapus.');
    }

    // WIZARD STEP 1: Select education level, semester, academic year, upload method
    public function scheduleStudentWizardStep1(Request $request)
    {
        $educationLevels = ['TK', 'SD', 'SMP', 'SMK'];
        $semesters = ['Ganjil', 'Genap'];
        $years = ['2024/2025','2025/2026','2026/2027'];

        return view('admin.schedule.student.wizard.step1', compact('educationLevels','semesters','years'));
    }

    public function scheduleStudentWizardStoreStep1(Request $request)
    {
        $validated = $request->validate([
            'education_level' => ['required','in:TK,SD,SMP,SMK'],
            'semester' => ['required','in:Ganjil,Genap'],
            'academic_year' => ['required','string'],
            'upload_method' => ['required','in:bulk,manual'],
        ]);

        // Store selections in session
        session([ 'wizard_education_level' => $validated['education_level'],
                  'wizard_semester' => $validated['semester'],
                  'wizard_academic_year' => $validated['academic_year'],
                  'wizard_upload_method' => $validated['upload_method']
        ]);

        return redirect()->route('admin.schedule.student.wizard.step2');
    }

    // WIZARD STEP 2: Upload file or manual input
    public function scheduleStudentWizardStep2(Request $request)
    {
        $uploadMethod = session('wizard_upload_method', 'bulk');
        $educationLevel = session('wizard_education_level');

        $previewItems = session('wizard_items', []);
        $service = new ScheduleImportService();
        $previewValidation = $service->validateConflicts($previewItems);

        $teachers = \App\Models\Teacher::with('user')->get();

        return view('admin.schedule.student.wizard.step2', compact('uploadMethod','educationLevel','previewItems','previewValidation','teachers'));
    }

    public function scheduleStudentWizardStoreStep2(Request $request)
    {
        $uploadMethod = session('wizard_upload_method', 'bulk');

        if ($uploadMethod === 'bulk') {
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls,csv',
            ]);

            $file = $request->file('file');

            try {
                $spreadsheet = IOFactory::load($file->getRealPath());
                $array = $spreadsheet->getActiveSheet()->toArray();
                // take first sheet
                $rows = $array[0] ?? [];

                $items = [];
                $teachersCache = []; // Cache names to IDs to optimize query loop

                foreach ($rows as $index => $row) {
                    // skip header heuristically
                    if ($index === 0) continue;

                    $teacherName = trim($row[5] ?? '');
                    if (empty($teacherName)) {
                        return redirect()->back()->withErrors(['file' => "Baris ke-" . ($index + 1) . ": Nama Guru wajib diisi."]);
                    }

                    // Check cache first
                    if (isset($teachersCache[$teacherName])) {
                        $teacherId = $teachersCache[$teacherName]['id'];
                        $teacherRealName = $teachersCache[$teacherName]['name'];
                    } else {
                        // Find user with role guru matching the name closely
                        $user = \App\Models\User::where('role', 'guru')
                            ->where('name', 'like', '%' . $teacherName . '%')
                            ->first();

                        if (!$user) {
                            return redirect()->back()->withErrors(['file' => "Baris ke-" . ($index + 1) . ": Guru bernama '{$teacherName}' tidak ditemukan di sistem. Pastikan guru terdaftar di menu Manajer User dengan role 'guru'."]);
                        }

                        // Ensure teacher record exists
                        $teacher = \App\Models\Teacher::where('user_id', $user->id)->first();
                        if (!$teacher) {
                            return redirect()->back()->withErrors(['file' => "Baris ke-" . ($index + 1) . ": Guru bernama '{$teacherName}' ditemukan, namun profil detail gurunya belum lengkap."]);
                        }

                        $teacherId = $teacher->id;
                        $teacherRealName = $user->name;
                        $teachersCache[$teacherName] = ['id' => $teacherId, 'name' => $teacherRealName];
                    }

                    // expecting columns: class,subject,day,start_time,end_time,teacher
                    $items[] = [
                        'class' => $row[0] ?? null,
                        'subject' => $row[1] ?? null,
                        'day' => $row[2] ?? null,
                        'start_time' => $row[3] ?? null,
                        'end_time' => $row[4] ?? null,
                        'teacher' => $teacherRealName,
                        'teacher_id' => $teacherId,
                    ];
                }

                session(['wizard_items' => $items]);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['file' => 'Gagal memproses file: '.$e->getMessage()]);
            }

            return redirect()->route('admin.schedule.student.wizard.step3');
        }

        // Manual input adding a single schedule row into session
        $validated = $request->validate([
            'class' => 'required|string',
            'subject' => 'required|string',
            'day' => 'required|string',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'teacher_id' => 'required|exists:teachers,id',
            'room' => 'nullable|string',
        ], [
            'teacher_id.required' => 'Guru wajib dipilih',
            'teacher_id.exists' => 'Guru tidak valid',
        ]);

        $teacher = \App\Models\Teacher::with('user')->find($validated['teacher_id']);

        $items = session('wizard_items', []);
        $validated['teacher'] = $teacher->user->name ?? 'Unknown';
        $items[] = $validated;
        session(['wizard_items' => $items]);

        return redirect()->route('admin.schedule.student.wizard.step2');
    }

    public function scheduleStudentWizardUpdateItem(Request $request, $index)
    {
        $items = session('wizard_items', []);

        if (!array_key_exists((int) $index, $items)) {
            return redirect()->route('admin.schedule.student.wizard.step2')->withErrors(['wizard_item' => 'Data jadwal yang dipilih tidak ditemukan.']);
        }

        $validated = $request->validate([
            'class' => 'required|string',
            'subject' => 'required|string',
            'day' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'teacher_id' => 'required|exists:teachers,id',
            'room' => 'nullable|string',
        ], [
            'teacher_id.required' => 'Guru wajib dipilih',
            'teacher_id.exists' => 'Guru tidak valid',
            'day.in' => 'Hari tidak valid',
        ]);

        $startTime = $this->normalizeWizardTime($validated['start_time']);
        $endTime = $this->normalizeWizardTime($validated['end_time']);

        if (!$startTime || !$endTime) {
            return redirect()->route('admin.schedule.student.wizard.step2')->withErrors(['wizard_item' => 'Format jam harus HH:MM (contoh: 07:30).']);
        }

        if (strtotime($startTime) >= strtotime($endTime)) {
            return redirect()->route('admin.schedule.student.wizard.step2')->withErrors(['wizard_item' => 'Jam selesai harus lebih besar dari jam mulai.']);
        }

        $teacher = \App\Models\Teacher::with('user')->find($validated['teacher_id']);

        $items[(int) $index] = [
            'class' => trim((string) $validated['class']),
            'subject' => trim((string) $validated['subject']),
            'day' => $validated['day'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'teacher_id' => $teacher->id,
            'teacher' => $teacher->user->name ?? 'Unknown',
            'room' => isset($validated['room']) ? trim((string) $validated['room']) : null,
        ];

        session(['wizard_items' => array_values($items)]);

        return redirect()->route('admin.schedule.student.wizard.step2')->with('success', 'Baris jadwal berhasil diperbarui.');
    }

    public function scheduleStudentWizardDeleteItem($index)
    {
        $items = session('wizard_items', []);

        if (!array_key_exists((int) $index, $items)) {
            return redirect()->route('admin.schedule.student.wizard.step2')->withErrors(['wizard_item' => 'Data jadwal yang dipilih tidak ditemukan.']);
        }

        unset($items[(int) $index]);
        session(['wizard_items' => array_values($items)]);

        return redirect()->route('admin.schedule.student.wizard.step2')->with('success', 'Baris jadwal berhasil dihapus.');
    }

    protected function normalizeWizardTime(?string $time): ?string
    {
        $time = trim((string) $time);

        if ($time === '') {
            return null;
        }

        if (preg_match('/^\d{2}:\d{2}$/', $time)) {
            return $time;
        }

        if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $time)) {
            return substr($time, 0, 5);
        }

        $parsed = strtotime($time);
        if ($parsed === false) {
            return null;
        }

        return date('H:i', $parsed);
    }

    // WIZARD STEP 3: Review & validation
    public function scheduleStudentWizardStep3(Request $request)
    {
        $items = session('wizard_items', []);
        $educationLevel = session('wizard_education_level');
        $semester = session('wizard_semester');
        $academicYear = session('wizard_academic_year');

        $service = new ScheduleImportService();
        $validation = $service->validateConflicts($items);

        return view('admin.schedule.student.wizard.step3', compact('items','validation','educationLevel','semester','academicYear'));
    }

    // Publish wizard data into DB
    public function scheduleStudentPublish(Request $request)
    {
        $items = session('wizard_items', []);
        $educationLevel = session('wizard_education_level');
        $semester = session('wizard_semester');
        $academicYear = session('wizard_academic_year');

        if (empty($items)) {
            return redirect()->route('admin.schedule.student.wizard.step2')->withErrors(['no_items' => 'Tidak ada data untuk dipublikasikan.']);
        }

        $service = new ScheduleImportService();
        $validation = $service->validateConflicts($items);

        $validItems = array_filter($validation, function($v){ return $v['status'] === 'valid'; });

        DB::transaction(function() use($validItems, $educationLevel, $semester, $academicYear) {
            foreach ($validItems as $row) {
                $teacherId = $row['teacher_id'];

                // create into schedules table
                Schedule::create([
                    'teacher_id' => $teacherId,
                    'student_id' => null,
                    'subject' => $row['subject'] ?? null,
                    'class' => $row['class'] ?? null,
                    'day' => $row['day'] ?? null,
                    'start_time' => $row['start_time'] ?? null,
                    'end_time' => $row['end_time'] ?? null,
                    'room' => null,
                    'education_level' => $educationLevel,
                    'semester' => $semester,
                    'academic_year' => $academicYear,
                ]);
            }
        });

        // clear wizard session
        session()->forget(['wizard_items','wizard_education_level','wizard_semester','wizard_academic_year','wizard_upload_method']);

        return redirect()->route('admin.schedule.student.index')->with('success', 'Jadwal berhasil dipublikasikan.');
    }

    // 1. Fungsi Download Template CSV (Updated dengan NISN/NIP, Jenjang, Kelas)
public function usersDownloadTemplate()
{
    $headers = [
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=template_siswa_guru.csv",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    // Updated columns dengan NISN/NIP, Jenjang, Kelas
    $columns = ['Nama Lengkap', 'Email', 'Password', 'Role (siswa/guru)', 'NISN/NIP', 'Jenjang (Siswa) / Spesialisasi (Guru)', 'Kelas / -', 'No Telepon', 'Alamat'];

    $callback = function() use($columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        // Contoh data siswa: NISN 13 digit, Jenjang: TK/SD/SMP/SMA/SMK, Kelas: sesuai
        fputcsv($file, ['Ahmad Fauzi', 'ahmad@nuurudzholaam.sch.id', 'rahasia123', 'siswa', '0012345678901', 'SD', '5A', '08123456789', 'Purwakarta']);
        // Contoh data guru: NIP 18 digit, Spesialisasi, Kelas: -
        fputcsv($file, ['Siti Aminah', 'siti@nuurudzholaam.sch.id', 'passwordguru', 'guru', '123456789012345678', 'Matematika', '-', '08987654321', 'Bungursari']);
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
    }
    // 2. Validasi File & Preview sebelum import
    public function usersValidateImport(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file_excel');
        $validator = new \App\Services\BulkUserValidator();
        $result = $validator->parseAndValidate($file);

        return view('admin.users.import-preview', [
            'valid_rows' => $result['valid_rows'] ?? [],
            'invalid_rows' => $result['invalid_rows'] ?? [],
            'warnings' => $result['warnings'] ?? [],
            'summary' => $result['summary'] ?? ['total' => 0, 'valid' => 0, 'invalid' => 0],
            'validation_errors' => $result['errors'] ?? [],
        ]);
    }

    // 3. Proses simpan data setelah validasi berhasil
    public function usersProcessImport(Request $request)
    {
        $request->validate([
            'validated_data' => 'required|json',
        ]);

        $validatedData = json_decode($request->validated_data, true);
        if (!is_array($validatedData)) {
            return redirect()->back()->withErrors(['Data validasi tidak valid.']);
        }

        $suksesCount = 0;
        $errorCount = 0;

        foreach ($validatedData as $row) {
            try {
                $user = User::create([
                    'name'     => $row['name'],
                    'email'    => $row['email'],
                    'password' => Hash::make($row['password']),
                    'role'     => $row['role'],
                    'phone'    => $row['phone'],
                    'address'  => $row['address'],
                    'nisn'     => $row['role'] === 'siswa' ? $row['nisn_nip'] : null,
                    'nip'      => $row['role'] === 'guru' ? $row['nisn_nip'] : null,
                    'class'    => $row['role'] === 'siswa' ? $row['kelas'] : null,
                    'is_active' => true,
                ]);

                if ($row['role'] === 'siswa') {
                    Student::create([
                        'user_id' => $user->id,
                        'nisn' => $row['nisn_nip'],
                        'class' => $row['kelas'] ?? '-'
                    ]);
                } elseif ($row['role'] === 'guru') {
                    Teacher::create([
                        'user_id' => $user->id,
                        'nip' => $row['nisn_nip'],
                        'specialization' => $row['jenjang_spesialisasi']
                    ]);
                }

                $suksesCount++;
            } catch (\Exception $e) {
                $errorCount++;
                Log::error('Error importing user: ' . $e->getMessage(), $row);
            }
        }

        $message = "Berhasil menambahkan $suksesCount data";
        if ($errorCount > 0) {
            $message .= ", tetapi $errorCount data gagal disimpan.";
        } else {
            $message .= " secara massal!";
        }

        return redirect()->route('admin.users.index')->with('success', $message);
    }

    // Backward compatibility: usersImport sekarang redirect ke validateImport
    public function usersImport(Request $request)
    {
        return $this->usersValidateImport($request);
    }

}
