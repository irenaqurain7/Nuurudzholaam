<?php

namespace App\Http\Controllers;

use App\Models\PPDBRegistration;
use Illuminate\Http\Request;

class PPDBController extends Controller
{
    public function store(Request $request)
    {
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
