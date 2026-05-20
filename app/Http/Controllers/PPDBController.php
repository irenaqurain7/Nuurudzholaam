<?php

namespace App\Http\Controllers;

use App\Models\PPDBRegistration;
use App\Models\SchoolInfo;
use Illuminate\Http\Request;

class PPDBController extends Controller
{
    public function index()
    {
        $schoolInfo = SchoolInfo::first();
        return view('ppdb', compact('schoolInfo'));
    }

    public function store(Request $request)
    {
        // Check PPDB status
        $schoolInfo = SchoolInfo::first();
        
        if (!$schoolInfo) {
            return redirect()->back()->with('error', 'Konfigurasi sekolah belum tersedia.');
        }

        // Check if PPDB is active
        if (!$schoolInfo->ppdb_active) {
            return redirect()->back()->with('error', 'Penerimaan Peserta Didik Baru sedang ditutup. Silakan coba lagi nanti.');
        }

        // Check if current date is within PPDB period
        $today = now()->toDateString();
        
        if ($schoolInfo->ppdb_start_date && $today < $schoolInfo->ppdb_start_date->toDateString()) {
            return redirect()->back()->with('error', 'Pendaftaran PPDB belum dibuka. Dibuka mulai tanggal ' . $schoolInfo->ppdb_start_date->format('d F Y') . '.');
        }

        if ($schoolInfo->ppdb_end_date && $today > $schoolInfo->ppdb_end_date->toDateString()) {
            return redirect()->back()->with('error', 'Pendaftaran PPDB telah ditutup sejak tanggal ' . $schoolInfo->ppdb_end_date->format('d F Y') . '.');
        }

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:ppdb_registrations',
            'no_telepon' => 'required|string|max:20',
            'asal_sekolah' => 'required|string|max:255',
            'nama_ortu' => 'required|string|max:255',
            'no_ortu' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'program' => 'required|in:ipa,ips,keagamaan',
            'alamat' => 'required|string',
        ]);

        PPDBRegistration::create($validated);

        return redirect()->back()->with('success', 'Pendaftaran PPDB berhasil! Kami akan menghubungi Anda segera.');
    }
}
