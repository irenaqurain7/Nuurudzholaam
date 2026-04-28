<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPDBRegistration extends Model
{
    use HasFactory;

    protected $table = 'ppdb_registrations';
    
    protected $fillable = [
        'nama_lengkap',
        'email',
        'no_telepon',
        'asal_sekolah',
        'nama_ortu',
        'no_ortu',
        'tanggal_lahir',
        'program',
        'alamat',
        'file_ijazah',
        'file_ktp',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tgl_daftar' => 'datetime',
    ];
}
