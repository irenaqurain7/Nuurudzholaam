@extends('layouts.admin')

@section('title', 'Detail Pendaftar PPDB')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0; color: var(--hijau-islam);">Detail Pendaftar</h1>
    <a href="{{ route('admin.ppdb.index') }}" class="admin-btn" style="text-decoration: none;">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    <!-- Main Info -->
    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <h2 style="color: var(--hijau-islam); margin-bottom: 25px; font-size: 24px;">
            {{ $registration->nama_lengkap }}
        </h2>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <div>
                <h4 style="color: var(--hijau-islam); margin-bottom: 8px; font-size: 14px; font-weight: 600; text-transform: uppercase;">Email</h4>
                <p style="color: var(--text-light); margin: 0; font-size: 16px;">{{ $registration->email }}</p>
            </div>
            <div>
                <h4 style="color: var(--hijau-islam); margin-bottom: 8px; font-size: 14px; font-weight: 600; text-transform: uppercase;">Nomor Telepon</h4>
                <p style="color: var(--text-light); margin: 0; font-size: 16px;">{{ $registration->no_telepon }}</p>
            </div>
            <div>
                <h4 style="color: var(--hijau-islam); margin-bottom: 8px; font-size: 14px; font-weight: 600; text-transform: uppercase;">Asal Sekolah</h4>
                <p style="color: var(--text-light); margin: 0; font-size: 16px;">{{ $registration->asal_sekolah }}</p>
            </div>
            <div>
                <h4 style="color: var(--hijau-islam); margin-bottom: 8px; font-size: 14px; font-weight: 600; text-transform: uppercase;">Tanggal Lahir</h4>
                <p style="color: var(--text-light); margin: 0; font-size: 16px;">{{ $registration->tanggal_lahir->format('d M Y') }}</p>
            </div>
            <div>
                <h4 style="color: var(--hijau-islam); margin-bottom: 8px; font-size: 14px; font-weight: 600; text-transform: uppercase;">Program Pilihan</h4>
                <p style="color: var(--text-light); margin: 0; font-size: 16px; text-transform: uppercase;">{{ $registration->program }}</p>
            </div>
            <div>
                <h4 style="color: var(--hijau-islam); margin-bottom: 8px; font-size: 14px; font-weight: 600; text-transform: uppercase;">Tanggal Daftar</h4>
                <p style="color: var(--text-light); margin: 0; font-size: 16px;">{{ $registration->tgl_daftar->format('d M Y H:i') }}</p>
            </div>
        </div>

        <div style="margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 30px;">
            <h3 style="color: var(--hijau-islam); margin-bottom: 15px; font-size: 16px;">Data Orang Tua/Wali</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <div>
                    <h4 style="color: var(--hijau-islam); margin-bottom: 8px; font-size: 14px; font-weight: 600; text-transform: uppercase;">Nama Orang Tua</h4>
                    <p style="color: var(--text-light); margin: 0; font-size: 16px;">{{ $registration->nama_ortu }}</p>
                </div>
                <div>
                    <h4 style="color: var(--hijau-islam); margin-bottom: 8px; font-size: 14px; font-weight: 600; text-transform: uppercase;">No Telepon Orang Tua</h4>
                    <p style="color: var(--text-light); margin: 0; font-size: 16px;">{{ $registration->no_ortu }}</p>
                </div>
            </div>
        </div>

        <div style="margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 30px;">
            <h3 style="color: var(--hijau-islam); margin-bottom: 15px; font-size: 16px;">Alamat</h3>
            <p style="color: var(--text-light); margin: 0; line-height: 1.8;">{{ $registration->alamat }}</p>
        </div>
    </div>

    <!-- Sidebar Status -->
    <div>
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); margin-bottom: 20px;">
            <h3 style="color: var(--hijau-islam); margin-bottom: 20px; font-size: 16px;">Status Aplikasi</h3>
            <div style="padding: 15px; background-color: #f7fafc; border-radius: 8px; text-align: center; margin-bottom: 20px;">
                <span style="display: inline-block; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 600;
                @if($registration->status === 'pending') background-color: #fff3cd; color: #856404;
                @elseif($registration->status === 'diterima') background-color: #d4edda; color: #155724;
                @else background-color: #f8d7da; color: #721c24;
                @endif
                ">
                    {{ ucfirst($registration->status) }}
                </span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 10px;">
                <form method="POST" action="{{ route('admin.ppdb.updateStatus', [$registration->id, 'diterima']) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="admin-btn" style="width: 100%; background-color: #28a745; border: none; cursor: pointer;">
                        <i class="fas fa-check"></i> Terima
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.ppdb.updateStatus', [$registration->id, 'ditolak']) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="admin-btn danger" style="width: 100%; border: none; cursor: pointer;">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.ppdb.updateStatus', [$registration->id, 'pending']) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="admin-btn warning" style="width: 100%; border: none; cursor: pointer;">
                        <i class="fas fa-clock"></i> Pending
                    </button>
                </form>
            </div>
        </div>

        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
            <h3 style="color: var(--hijau-islam); margin-bottom: 15px; font-size: 16px;">Dokumen</h3>
            <p style="color: var(--text-light); font-size: 14px; margin: 0;">Dokumen pendukung akan diminta langsung di kantor sekolah setelah verifikasi awal.</p>
        </div>
    </div>
</div>

@endsection
