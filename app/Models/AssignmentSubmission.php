<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id', 
        'student_id', 
        'student_notes', 
        'file_path', 
        'grade', 
        'teacher_feedback', 
        'status', 
        'submitted_at'
    ];

    /**
     * THE FIX: Cast the custom timestamp to a datetime object
     */
    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}