<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ResultToken extends Model
{
    protected $fillable = ['school_id', 'student_id', 'serial_number', 'pin', 'usage_limit', 'usage_count', 'batch_number', 'status'];

    public function school() { return $this->belongsTo(School::class); }
    public function student() { return $this->belongsTo(Student::class); }

    // Helper to check if token is valid for a specific student
    public function isValidFor(Student $student)
    {
        if ($this->status === 'expired') return false;
        if ($this->usage_count >= $this->usage_limit) return false;
        
        // Locked to the first student who uses it
        if ($this->student_id !== null && $this->student_id !== $student->id) return false;

        return true;
    }
}