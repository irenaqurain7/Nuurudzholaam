<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEducationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'user_id', 'academic_year', 'jenjang', 'class', 'status', 'note', 'processed_by'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
