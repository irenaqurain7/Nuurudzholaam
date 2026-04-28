<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\FAQ;
use App\Models\Gallery;
use App\Models\PPDBRegistration;
use App\Models\Program;
use App\Models\SchoolInfo;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // DASHBOARD
    public function dashboard()
    {
        $totalPPDB = PPDBRegistration::count();
        $ppdbBaru = PPDBRegistration::where('status', 'pending')->count();
        $totalKegiatan = Activity::count();
        $totalProgram = Program::count();

        return view('admin.dashboard', compact('totalPPDB', 'ppdbBaru', 'totalKegiatan', 'totalProgram'));
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
        ]);

        $school = SchoolInfo::first() ?? new SchoolInfo();

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('school', 'public');
        }

        if ($request->hasFile('gambar_utama')) {
            $validated['gambar_utama'] = $request->file('gambar_utama')->store('school', 'public');
        }

        if ($school->exists) {
            $school->update($validated);
        } else {
            SchoolInfo::create($validated);
        }

        return redirect()->back()->with('success', 'Informasi sekolah berhasil diperbarui.');
    }
}
