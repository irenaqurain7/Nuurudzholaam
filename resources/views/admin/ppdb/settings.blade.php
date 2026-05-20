@extends('layouts.admin')

@section('title', 'Pengaturan PPDB')

@section('content')
<div style="padding: 30px;">
    <!-- Header -->
    <div style="margin-bottom: 40px;">
        <h1 style="font-size: 28px; font-weight: bold; color: var(--hijau-islam); margin-bottom: 8px;">
            <i class="fas fa-calendar-check" style="margin-right: 10px;"></i>Pengaturan PPDB
        </h1>
        <p style="color: var(--text-light); font-size: 14px;">Atur tanggal dan status pendaftaran peserta didik baru secara independen</p>
    </div>

    @if ($errors->any())
        <div style="background: #fee; border-left: 4px solid #c33; padding: 15px; margin-bottom: 30px; border-radius: 4px;">
            <h4 style="color: #c33; margin-bottom: 10px; font-weight: bold;">Terjadi kesalahan:</h4>
            <ul style="color: #c33; margin-left: 20px; font-size: 14px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div style="background: #efe; border-left: 4px solid #5c3; padding: 15px; margin-bottom: 30px; border-radius: 4px; color: #5c3; font-weight: 500;">
            <i class="fas fa-check-circle" style="margin-right: 8px;"></i>{{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
        <!-- Main Form -->
        <div>
            <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <form action="{{ route('admin.ppdb.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Status PPDB -->
                    <div style="margin-bottom: 25px;">
                        <label style="display: flex; align-items: center; gap: 12px; cursor: pointer;">
                            <input type="checkbox" name="ppdb_active" value="1" {{ $school && $school->ppdb_active ? 'checked' : '' }} style="width: 20px; height: 20px; cursor: pointer;">
                            <span style="font-weight: 600; color: var(--hijau-islam); font-size: 16px;">
                                Aktifkan PPDB
                            </span>
                        </label>
                        <p style="color: var(--text-light); font-size: 13px; margin-top: 8px; margin-left: 32px;">
                            Ketika diaktifkan, halaman pendaftaran akan tersedia untuk calon peserta didik
                        </p>
                    </div>

                    <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 30px 0;">

                    <!-- Tanggal Mulai -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: var(--hijau-islam); margin-bottom: 8px; font-size: 14px;">
                            <i class="fas fa-calendar" style="margin-right: 6px;"></i>Tanggal Mulai Pendaftaran
                        </label>
                        <input type="date" name="ppdb_start_date" value="{{ $school && $school->ppdb_start_date ? $school->ppdb_start_date->format('Y-m-d') : '' }}" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; font-family: inherit;">
                        <p style="color: var(--text-light); font-size: 12px; margin-top: 6px;">Pendaftaran akan dibuka pada tanggal ini</p>
                    </div>

                    <!-- Tanggal Selesai -->
                    <div style="margin-bottom: 30px;">
                        <label style="display: block; font-weight: 600; color: var(--hijau-islam); margin-bottom: 8px; font-size: 14px;">
                            <i class="fas fa-calendar" style="margin-right: 6px;"></i>Tanggal Selesai Pendaftaran
                        </label>
                        <input type="date" name="ppdb_end_date" value="{{ $school && $school->ppdb_end_date ? $school->ppdb_end_date->format('Y-m-d') : '' }}" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; font-family: inherit;">
                        <p style="color: var(--text-light); font-size: 12px; margin-top: 6px;">Pendaftaran akan ditutup pada tanggal ini</p>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" style="width: 100%; background: var(--hijau-islam); color: white; padding: 12px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; transition: all 0.3s; font-size: 14px;">
                        <i class="fas fa-save" style="margin-right: 8px;"></i>Simpan Pengaturan
                    </button>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div>
            <!-- Status Badge -->
            <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 20px;">
                <h3 style="font-weight: 600; color: var(--hijau-islam); margin-bottom: 15px; font-size: 14px;">
                    <i class="fas fa-info-circle" style="margin-right: 6px;"></i>Status PPDB
                </h3>

                @if($school && $school->ppdb_active)
                    <div style="background: rgba(46, 125, 50, 0.1); border-left: 4px solid #2e7d32; padding: 15px; border-radius: 6px; margin-bottom: 15px;">
                        <p style="color: #2e7d32; font-weight: 600; font-size: 14px;">
                            <i class="fas fa-check-circle" style="margin-right: 6px;"></i>PPDB Aktif
                        </p>
                    </div>
                @else
                    <div style="background: rgba(212, 175, 55, 0.1); border-left: 4px solid #d4af37; padding: 15px; border-radius: 6px; margin-bottom: 15px;">
                        <p style="color: #d4af37; font-weight: 600; font-size: 14px;">
                            <i class="fas fa-ban" style="margin-right: 6px;"></i>PPDB Tidak Aktif
                        </p>
                    </div>
                @endif

                <!-- Periode Info -->
                @if($school && $school->ppdb_start_date && $school->ppdb_end_date)
                    <div style="background: #f5f5f5; padding: 15px; border-radius: 6px;">
                        <p style="color: var(--text-light); font-size: 12px; text-transform: uppercase; font-weight: 600; margin-bottom: 10px;">Periode Pendaftaran:</p>
                        <p style="color: var(--hijau-islam); font-weight: 600; font-size: 14px; margin-bottom: 5px;">
                            {{ $school->ppdb_start_date->format('d F Y') }}
                        </p>
                        <p style="color: var(--text-light); font-size: 12px; margin-bottom: 10px;">hingga</p>
                        <p style="color: var(--hijau-islam); font-weight: 600; font-size: 14px;">
                            {{ $school->ppdb_end_date->format('d F Y') }}
                        </p>
                    </div>
                @else
                    <div style="background: #f5f5f5; padding: 15px; border-radius: 6px;">
                        <p style="color: var(--text-light); font-size: 12px;">Belum ada periode pendaftaran yang diatur.</p>
                    </div>
                @endif
            </div>

            <!-- Helper Info -->
            <div style="background: rgba(25, 118, 210, 0.05); border-left: 4px solid #1976d2; padding: 20px; border-radius: 8px;">
                <h4 style="color: #1976d2; font-weight: 600; margin-bottom: 12px; font-size: 13px;">
                    <i class="fas fa-lightbulb" style="margin-right: 6px;"></i>Tips Pengaturan PPDB
                </h4>
                <ul style="color: var(--text-light); font-size: 12px; line-height: 1.8; margin-left: 15px;">
                    <li>✓ Centang "Aktifkan PPDB" untuk membuka pendaftaran</li>
                    <li>✓ Atur tanggal mulai dan selesai sesuai kebutuhan</li>
                    <li>✓ Calon peserta didik hanya dapat mendaftar dalam periode yang ditentukan</li>
                    <li>✓ Status PPDB akan ditampilkan di halaman beranda</li>
                    <li>✓ Perubahan akan langsung berlaku</li>
                </ul>
            </div>

            <!-- Link ke School Info -->
            <div style="margin-top: 20px; padding: 15px; background: rgba(31, 127, 95, 0.08); border-left: 4px solid var(--hijau-islam); border-radius: 8px;">
                <p style="color: var(--text-light); font-size: 12px; margin-bottom: 10px;">Perlu mengubah informasi sekolah?</p>
                <a href="{{ route('admin.school-info.edit') }}" style="color: var(--hijau-islam); font-weight: 600; text-decoration: none; font-size: 13px;">
                    <i class="fas fa-arrow-right" style="margin-right: 4px;"></i>Edit Informasi Sekolah
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    input[type="date"] {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    button:hover {
        background: #1f7f5f !important;
        box-shadow: 0 4px 12px rgba(31, 127, 95, 0.2);
        transform: translateY(-1px);
    }
</style>
@endsection
