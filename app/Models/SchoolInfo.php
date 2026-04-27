<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolInfo extends Model
{
    use HasFactory;

    protected $table = 'school_info';

    protected $fillable = [
        'nama_sekolah',
        'deskripsi',
        'visi',
        'misi',
        'alamat',
        'no_telepon',
        'email',
        'website',
        'logo',
        'gambar_utama',
    ];
}
