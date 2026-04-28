<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal',
        'gambar',
        'kategori',
        'visibility',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
