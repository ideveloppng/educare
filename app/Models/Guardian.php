<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    protected $fillable = ['user_id', 'school_id', 'phone', 'occupation', 'address'];

    public function user() { return $this->belongsTo(User::class); }
    
    public function students() { 
        return $this->belongsToMany(Student::class, 'guardian_student', 'guardian_id', 'student_id'); 
    }
}