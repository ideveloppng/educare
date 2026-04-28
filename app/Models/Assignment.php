<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['school_id', 'teacher_id', 'school_class_id', 'subject_id', 'title', 'description', 'file_path', 'due_date', 'max_score'];
    protected $casts = ['due_date' => 'datetime'];

    public function submissions() { return $this->hasMany(AssignmentSubmission::class); }
    public function subject() { return $this->belongsTo(Subject::class); }
    public function schoolClass() { return $this->belongsTo(SchoolClass::class); }
}
