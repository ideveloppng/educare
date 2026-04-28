<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * These must match the columns in your results migration.
     */
    protected $fillable = [
    'school_id', 'student_id', 'subject_id', 'school_class_id', 'teacher_id',
    'term', 'session', 'ca1', 'ca2', 'ca3', 'exam', 'total', 'grade', 'remarks', 'is_published'
];

    /**
     * RELATIONSHIPS
     */

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}