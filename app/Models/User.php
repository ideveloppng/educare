<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'school_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * RELATIONSHIP: School
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * RELATIONSHIP: Teacher Profile
     */
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    /**
     * RELATIONSHIP: Student Profile
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    /**
     * RELATIONSHIP: Parent/Guardian Profile
     */
    public function guardian()
    {
        return $this->hasOne(Guardian::class);
    }

    /**
     * THE FIX: Non-Academic Staff Profile (Accountant, Librarian, etc.)
     */
    public function staff()
    {
        return $this->hasOne(Staff::class);
    }
}