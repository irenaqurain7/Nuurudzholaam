<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\FAQ;
use App\Models\Gallery;
use App\Models\Program;
use App\Models\SchoolInfo;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    protected function schoolInfo(): SchoolInfo
    {
        return SchoolInfo::first() ?? new SchoolInfo();
    }

    public function index()
    {
        $school = $this->schoolInfo();
        $announcements = Announcement::where('status', 'aktif')->orderBy('tanggal_mulai', 'desc')->take(3)->get();
        $activities = Activity::where('visibility', 'publik')->orderBy('tanggal', 'desc')->take(6)->get();
        $programs = Program::all();
        $galleries = Gallery::orderBy('tanggal', 'desc')->take(8)->get();
        
        return view('index', compact('school', 'announcements', 'activities', 'programs', 'galleries'));
    }

    public function ppdb()
    {
        $school = $this->schoolInfo();
        $programs = Program::all();
        $announcements = Announcement::where('status', 'aktif')->where('tipe', 'ppdb')->first();
        
        return view('ppdb', compact('school', 'programs', 'announcements'));
    }

    public function kegiatan()
    {
        $school = $this->schoolInfo();
        $activities = Activity::where('visibility', 'publik')->orderBy('tanggal', 'desc')->paginate(9);
        
        return view('kegiatan', compact('school', 'activities'));
    }

    public function program()
    {
        $school = $this->schoolInfo();
        $programs = Program::all();
        
        return view('program', compact('school', 'programs'));
    }

    public function profil()
    {
        $school = $this->schoolInfo();
        $galleries = Gallery::orderBy('tanggal', 'desc')->take(12)->get();
        
        return view('profil', compact('school', 'galleries'));
    }

    public function kontak()
    {
        $school = $this->schoolInfo();
        
        return view('kontak', compact('school'));
    }

    public function faq()
    {
        $school = $this->schoolInfo();
        $faqs = FAQ::orderBy('urutan')->get();
        
        return view('faq', compact('school', 'faqs'));
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email',
            'subjek' => 'required|string',
            'pesan' => 'required|string',
        ]);

        // TODO: Simpan pesan kontak ke database atau kirim email
        // Untuk sekarang, hanya redirect dengan pesan sukses
        
        return redirect()->back()->with('success', 'Pesan Anda telah dikirim. Terima kasih!');
    }
}
