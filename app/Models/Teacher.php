<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['user_id', 'school_id', 'staff_id', 'phone', 'qualification', 'employment_date', 'base_salary', 'photo', 'status'];

    protected $casts = ['employment_date' => 'date'];

    public function user() { return $this->belongsTo(User::class); }
    
    public function assignments() {
        // A teacher has many assignments (Class + Subject)
        return $this->hasMany(TeacherAssignment::class, 'teacher_id');
    }

    
}
