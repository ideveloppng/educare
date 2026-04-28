<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = ['user_id', 'school_id', 'staff_id', 'phone', 'designation', 'employment_date', 'base_salary', 'photo', 'status'];
    protected $casts = ['employment_date' => 'date'];

    public function user() { return $this->belongsTo(User::class); }
}
