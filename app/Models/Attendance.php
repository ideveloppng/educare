<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'school_id',
        'teacher_id',
        'school_class_id',
        'student_id',
        'date',
        'status',
        'remarks',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
