<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPDBRegistration extends Model
{
    use HasFactory;

    protected $table = 'ppdb_registrations';
    
    protected $fillable = [
        'jenjang',
        'nama_lengkap',
        'nisn',
        'nik',
        'tempat_lahir',
        'jenis_kelamin',
        'email',
        'no_telepon',
        'asal_sekolah',
        'nama_ayah',
        'nama_ibu',
        'nama_ortu',
        'no_ortu',
        'tanggal_lahir',
        'program',
        'jurusan',
        'alamat',
        'file_ijazah',
        'file_ktp',
        'status',
        'is_archived',
        'archive_year',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tgl_daftar' => 'datetime',
    ];
}
