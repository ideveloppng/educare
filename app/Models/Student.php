<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'school_id', 
        'school_class_id', 
        'admission_number', 
        'gender', 
        'date_of_birth', 
        'parent_phone', 
        'address', 
        'student_photo', 
        'status'
    ];

    /**
     * THE DEFINITIVE FIX: 
     * This method tells Laravel 11 to convert the DB string to a Date object.
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function guardians() { 
        return $this->belongsToMany(Guardian::class, 'guardian_student', 'student_id', 'guardian_id'); 
    }
}