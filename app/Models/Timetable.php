<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = [
        'school_id', 'school_class_id', 'subject_id', 'teacher_id', 
        'type', 'activity_name', 'day', 'start_time', 'end_time'
    ];

    public function schoolClass() { return $this->belongsTo(SchoolClass::class); }
    public function subject() { return $this->belongsTo(Subject::class); }
    public function teacher() { return $this->belongsTo(Teacher::class); }
}