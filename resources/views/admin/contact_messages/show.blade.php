@extends('layouts.admin')

@section('title', 'Detail Pesan')@section('page-title', 'Detail Pesan')
@section('content')
<div class="admin-page">
    <div class="page-header" style="margin-bottom:18px;">
        <div>
            <h1>Detail Pesan</h1>
            <p class="subtitle">Dilihat dari formulir Kontak</p>
        </div>
        <div>
            <a href="{{ route('admin.contact-messages.index') }}" class="admin-btn secondary">Kembali</a>
        </div>
    </div>

    <div class="card" style="padding:20px;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px;">
            <div style="flex:1;">
                <h3 style="margin-bottom:6px;">{{ $message->subjek }}</h3>
                <p style="color:var(--text-muted); margin:0 0 12px 0;">Dari: <strong>{{ $message->nama }}</strong> &middot; {{ $message->email }}</p>
                <div style="background:#fff; border:1px solid #eee; padding:16px; border-radius:6px; white-space:pre-wrap; color:var(--text-dark);">{{ $message->pesan }}</div>
            </div>
            <aside style="width:260px;">
                <div style="background:#fff; border:1px solid #eee; padding:14px; border-radius:8px;">
                    <p style="margin:0 0 8px 0; font-weight:700;">Info Pesan</p>
                    <p style="margin:6px 0; color:var(--text-muted);">Tanggal: <br><strong>{{ $message->created_at->format('Y-m-d H:i') }}</strong></p>
                    <p style="margin:6px 0; color:var(--text-muted);">IP: <br><strong>{{ $message->ip ?? '-' }}</strong></p>
                </div>
                <div style="margin-top:12px; display:flex; gap:8px;">
                    <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="admin-btn danger">Hapus Pesan</button>
                    </form>
                </div>
            </aside>
        </div>
    </div>
</div>

@endsection
