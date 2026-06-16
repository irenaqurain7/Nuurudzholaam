<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSchedule extends Model
{
    use HasFactory;

    protected $table = 'student_schedules';

    protected $fillable = [
        'class',
        'day',
        'activities',
    ];

    protected $casts = [
        'activities' => 'array',
    ];
}
