<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserArchiveFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'archive_name',
        'category',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
        'graduation_year',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
