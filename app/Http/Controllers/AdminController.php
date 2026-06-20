<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\FAQ;
use App\Models\Gallery;
use App\Models\PPDBRegistration;
use App\Models\Program;
use App\Models\SchoolInfo;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\ScheduleImportService;

class AdminController extends Controller
{
    // DASHBOARD
    public function dashboard()
    {
        $totalPPDB = PPDBRegistration::count();
        $ppdbBaru = PPDBRegistration::where('status', 'pending')->count();
        $totalKegiatan = Activity::count();
        $totalProgram = Program::count();
        $latestPPDB = PPDBRegistration::orderBy('tgl_daftar', 'desc')->limit(10)->get();

        return view('admin.dashboard', compact('totalPPDB', 'ppdbBaru', 'totalKegiatan', 'totalProgram', 'latestPPDB'));
    }

    // PPDB REGISTRATIONS
    public function ppdbIndex()
    {
        $registrations = PPDBRegistration::orderBy('tgl_daftar', 'desc')->paginate(15);
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

    public function ppdbExport()
    {
        // TODO: Implement Excel export
        return redirect()->back()->with('info', 'Fitur export sedang dalam pengembangan.');
    }

    // PROGRAMS
    public function programIndex()
    {
        $programs = Program::paginate(10);
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
            'kurikulum' => 'nullable|string',
            'kuota' => 'required|integer|min:1',
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
            'kurikulum' => 'nullable|string',
            'kuota' => 'required|integer|min:1',
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
    public function activityIndex()
    {
        $activities = Activity::orderBy('tanggal', 'desc')->paginate(10);
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

    // GALLERIES
    public function galleryIndex()
    {
        $galleries = Gallery::orderBy('tanggal', 'desc')->paginate(12);
        return view('admin.gallery.index', compact('galleries'));
    }

    public function galleryCreate()
    {
        return view('admin.gallery.create');
    }

    public function galleryStore(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'kategori' => 'required|in:kegiatan,acara,fasilitas,dokumentasi',
            'gambar' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('galleries', 'public');
        }

        Gallery::create($validated);
        return redirect()->route('admin.gallery.index')->with('success', 'Foto berhasil ditambahkan.');
    }

    public function galleryDestroy($id)
    {
        Gallery::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Foto berhasil dihapus.');
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
    public function faqIndex()
    {
        $faqs = FAQ::orderBy('urutan')->paginate(10);
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
            'nama_sekolah' => 'required|string',
            'deskripsi' => 'required|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string',
            'email' => 'required|email',
            'website' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'gambar_utama' => 'nullable|image|max:2048',
            'ppdb_active' => 'nullable|boolean',
            'ppdb_start_date' => 'nullable|date',
            'ppdb_end_date' => 'nullable|date|after_or_equal:ppdb_start_date',
        ]);

        $school = SchoolInfo::first() ?? new SchoolInfo();

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('school', 'public');
        }

        if ($request->hasFile('gambar_utama')) {
            $validated['gambar_utama'] = $request->file('gambar_utama')->store('school', 'public');
        }

        // Handle checkbox conversion
        $validated['ppdb_active'] = $request->has('ppdb_active');

        if ($school->exists) {
            $school->update($validated);
        } else {
            SchoolInfo::create($validated);
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
    public function usersIndex()
    {
        $users = User::where('role', '!=', 'admin')->orderBy('created_at', 'desc')->paginate(15);
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
            'nisn' => 'required_if:role,siswa|nullable|unique:users',
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
            'nisn' => 'required_if:role,siswa|nullable|unique:users,nisn,' . $user->id,
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
                    'nisn' => $validated['nisn'],
                    'class' => $validated['class'],
                ]);
            } else {
                Student::create([
                    'user_id' => $user->id,
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

    // TEACHER SCHEDULES
    private function getTemporaryTeacherNames(): array
    {
        return [
            1 => 'A. Dede Ali, S.Pd',
            2 => 'Ade Royani, S.Pd',
            3 => 'Ananda Jihan Kamilah',
            4 => 'Dinda Aulia Putri',
            5 => 'Kurnia Amelia',
            6 => 'Mochamad Fazhri Syamsi',
            7 => 'Rinda Maryani, S.Pd',
            8 => 'Siti Aminah',
            9 => 'Siti Rokayah',
            10 => 'Warnengsih',
            11 => 'Wiwi Suherti, S.Pd',
        ];
    }

    public function scheduleTeacherIndex()
    {
        $schedules = Schedule::whereNotNull('teacher_id')
            ->orderBy('day')
            ->paginate(15);

        $teacherNames = $this->getTemporaryTeacherNames();

        return view('admin.schedule.teacher.index', compact('schedules', 'teacherNames'));
    }

    public function scheduleTeacherCreate()
    {
        $teachers = $this->getTemporaryTeacherNames();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return view('admin.schedule.teacher.create', compact('teachers', 'days'));
    }

    public function scheduleTeacherStore(Request $request)
    {
        $teachers = $this->getTemporaryTeacherNames();
        $validated = $request->validate([
            'teacher_id' => ['required', Rule::in(array_keys($teachers))],
            'subject' => 'required|string',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string',
        ], [
            'teacher_id.required' => 'Guru harus dipilih',
            'teacher_id.in' => 'Guru tidak ditemukan',
            'subject.required' => 'Mata pelajaran harus diisi',
            'day.required' => 'Hari harus dipilih',
            'start_time.required' => 'Waktu mulai harus diisi',
            'end_time.required' => 'Waktu selesai harus diisi',
            'end_time.after' => 'Waktu selesai harus lebih besar dari waktu mulai',
        ]);

        Schedule::create($validated);
        return redirect()->route('admin.schedule.teacher.index')->with('success', 'Jadwal guru berhasil ditambahkan.');
    }

    public function scheduleTeacherEdit($id)
    {
        $schedule = Schedule::whereNotNull('teacher_id')->findOrFail($id);
        $teachers = $this->getTemporaryTeacherNames();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return view('admin.schedule.teacher.edit', compact('schedule', 'teachers', 'days'));
    }

    public function scheduleTeacherUpdate(Request $request, $id)
    {
        $schedule = Schedule::whereNotNull('teacher_id')->findOrFail($id);
        $teachers = $this->getTemporaryTeacherNames();

        $validated = $request->validate([
            'teacher_id' => ['required', Rule::in(array_keys($teachers))],
            'subject' => 'required|string',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string',
        ], [
            'teacher_id.required' => 'Guru harus dipilih',
            'teacher_id.in' => 'Guru tidak ditemukan',
            'subject.required' => 'Mata pelajaran harus diisi',
            'day.required' => 'Hari harus dipilih',
            'start_time.required' => 'Waktu mulai harus diisi',
            'end_time.required' => 'Waktu selesai harus diisi',
            'end_time.after' => 'Waktu selesai harus lebih besar dari waktu mulai',
        ]);

        $schedule->update($validated);
        return redirect()->route('admin.schedule.teacher.index')->with('success', 'Jadwal guru berhasil diperbarui.');
    }

    public function scheduleTeacherDestroy($id)
    {
        $schedule = Schedule::whereNotNull('teacher_id')->findOrFail($id);
        $schedule->delete();
        return redirect()->back()->with('success', 'Jadwal guru berhasil dihapus.');
    }

    // STUDENT SCHEDULES (SD-friendly: activities list per class & day)
    public function scheduleStudentIndex()
    {
        $schedules = \App\Models\StudentSchedule::orderBy('class')->orderBy('day')->get();

        return view('admin.schedule.student.index', compact('schedules'));
    }

    public function scheduleStudentCreate()
    {
        // Redirect to new wizard step 1
        return redirect()->route('admin.schedule.student.wizard.step1');
    }

    public function scheduleStudentStore(Request $request)
    {
        $validated = $request->validate([
            'class' => 'required|string',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'activities' => 'required|array|min:1',
            'activities.*' => 'required|string',
        ], [
            'class.required' => 'Kelas harus dipilih',
            'day.required' => 'Hari harus dipilih',
            'activities.required' => 'Daftar kegiatan harus diisi',
        ]);

        \App\Models\StudentSchedule::create([
            'class' => $validated['class'],
            'day' => $validated['day'],
            'activities' => $validated['activities'],
        ]);

        return redirect()->route('admin.schedule.student.index')->with('success', 'Jadwal siswa berhasil ditambahkan.');
    }

    public function scheduleStudentEdit($id)
    {
        $schedule = \App\Models\StudentSchedule::findOrFail($id);
        $classes = Student::distinct()
            ->orderBy('class')
            ->pluck('class')
            ->toArray();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return view('admin.schedule.student.edit', compact('schedule', 'classes', 'days'));
    }

    public function scheduleStudentUpdate(Request $request, $id)
    {
        $schedule = \App\Models\StudentSchedule::findOrFail($id);

        $validated = $request->validate([
            'class' => 'required|string',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'activities' => 'required|array|min:1',
            'activities.*' => 'required|string',
        ], [
            'class.required' => 'Kelas harus dipilih',
            'day.required' => 'Hari harus dipilih',
            'activities.required' => 'Daftar kegiatan harus diisi',
        ]);

        $schedule->update([
            'class' => $validated['class'],
            'day' => $validated['day'],
            'activities' => $validated['activities'],
        ]);

        return redirect()->route('admin.schedule.student.index')->with('success', 'Jadwal siswa berhasil diperbarui.');
    }

    public function scheduleStudentDestroy($id)
    {
        $schedule = \App\Models\StudentSchedule::findOrFail($id);
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

        return view('admin.schedule.student.wizard.step2', compact('uploadMethod','educationLevel','previewItems'));
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
                $array = Excel::toArray([], $file);
                // take first sheet
                $rows = $array[0] ?? [];

                $items = [];
                foreach ($rows as $index => $row) {
                    // skip header heuristically
                    if ($index === 0) continue;
                    // expecting columns: class,subject,day,start_time,end_time,teacher,room
                    $items[] = [
                        'class' => $row[0] ?? null,
                        'subject' => $row[1] ?? null,
                        'day' => $row[2] ?? null,
                        'start_time' => $row[3] ?? null,
                        'end_time' => $row[4] ?? null,
                        'teacher' => $row[5] ?? null,
                        'room' => $row[6] ?? null,
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
            'teacher' => 'nullable|string',
            'room' => 'nullable|string',
        ]);

        $items = session('wizard_items', []);
        $items[] = $validated;
        session(['wizard_items' => $items]);

        return redirect()->route('admin.schedule.student.wizard.step2');
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
                // create into schedules table
                Schedule::create([
                    'teacher_id' => null,
                    'student_id' => null,
                    'subject' => $row['subject'] ?? null,
                    'class' => $row['class'] ?? null,
                    'day' => $row['day'] ?? null,
                    'start_time' => $row['start_time'] ?? null,
                    'end_time' => $row['end_time'] ?? null,
                    'room' => $row['room'] ?? null,
                    'education_level' => $educationLevel,
                    'semester' => $semester,
                    'academic_year' => $academicYear,
                ]);
            }
        });

        // Also persist grouped StudentSchedule preview (simple grouping)
        $grouped = [];
        foreach ($validItems as $row) {
            $key = ($row['class'] ?? 'Umum') . '|' . ($row['day'] ?? '');
            $grouped[$key][] = ($row['subject'] ?? '-') . ' (' . ($row['start_time'] ?? '') . '-' . ($row['end_time'] ?? '') . ')';
        }

        foreach ($grouped as $key => $acts) {
            [$class, $day] = explode('|', $key);
            \App\Models\StudentSchedule::create([
                'class' => $class,
                'day' => $day,
                'activities' => $acts,
            ]);
        }

        // clear wizard session
        session()->forget(['wizard_items','wizard_education_level','wizard_semester','wizard_academic_year','wizard_upload_method']);

        return redirect()->route('admin.schedule.student.index')->with('success', 'Jadwal berhasil dipublikasikan.');
    }

    // 1. Fungsi Download Template CSV
public function usersDownloadTemplate()
{
    $headers = [
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=template_siswa_guru.csv",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $columns = ['Nama Lengkap', 'Email', 'Password', 'Role (siswa/guru)', 'No Telepon', 'Alamat'];

    $callback = function() use($columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);
        fputcsv($file, ['Ahmad Fauzi', 'ahmad@nuurudzholaam.sch.id', 'rahasia123', 'siswa', '08123456789', 'Purwakarta']);
        fputcsv($file, ['Siti Aminah', 'siti@nuurudzholaam.sch.id', 'passwordguru', 'guru', '08987654321', 'Bungursari']);
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
    }
    // 2. Fungsi Proses File CSV
    public function usersImport(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('file_excel');
        $handle = fopen($file->getRealPath(), "r");
        fgetcsv($handle); // Lewati header kolom

        $suksesCount = 0;

        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (empty($row[0]) || empty($row[1])) {
                continue;
            }

            User::create([
                'name'     => $row[0],
                'email'    => $row[1],
                'password' => Hash::make($row[2]),
                'role'     => strtolower($row[3]), // Menyimpan sebagai 'siswa' atau 'guru'
                'phone'    => $row[4] ?? null,
                'address'  => $row[5] ?? null,
            ]);

            $suksesCount++;
        }

        fclose($handle);

        return redirect()->back()->with('success', "Berhasil menambahkan $suksesCount data secara massal!");
    }

}
