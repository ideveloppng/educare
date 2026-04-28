<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'slug', 
        'email', 
        'phone', 
        'address', 
        'logo', 
        'status', 
        'current_session', 
        'current_term',
        'reg_key',
        'student_reg_active',
        'teacher_reg_active',
        'staff_reg_active',
        'parent_reg_active', // THE FIX: Add this line
        'trial_ends_at',
        'subscription_amount',
        'subscription_expires_at'
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'subscription_amount' => 'decimal:2',
        'subscription_expires_at' => 'datetime',
        'student_reg_active' => 'boolean',
        'teacher_reg_active' => 'boolean',
        'staff_reg_active' => 'boolean',
        'parent_reg_active' => 'boolean', // Add this cast too
    ];

    public function hasActiveSubscription()
    {
        if ($this->status !== 'active') return false;
        if ($this->trial_ends_at && now()->lessThanOrEqualTo($this->trial_ends_at)) return true;
        if ($this->subscription_expires_at && now()->lessThanOrEqualTo($this->subscription_expires_at)) return true;
        return false;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($school) {
            if (!$school->reg_key) {
                $school->reg_key = Str::random(32);
            }
        });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Add these relationships to your School model
    public function students() { return $this->hasMany(Student::class); }
    public function teachers() { return $this->hasMany(Teacher::class); }
    public function staff() { return $this->hasMany(Staff::class); }
    public function guardians() { return $this->hasMany(Guardian::class); }
}