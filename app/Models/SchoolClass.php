<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'school_classes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'school_id',
        'name',
        'section',
        'max_capacity',
    ];

    /**
     * ACCESSOR: Full Name
     * Combines the class name and the arm/section (e.g., "JSS 1" + "A" = "JSS 1A")
     * Usage in Blade: {{ $class->full_name }}
     */
    public function getFullNameAttribute()
    {
        return $this->section 
            ? "{$this->name} {$this->section}" 
            : $this->name;
    }

    /**
     * RELATIONSHIP: School
     * Each class belongs to one specific school institution.
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * RELATIONSHIP: Students
     * A class can have many enrolled students.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * RELATIONSHIP: Subjects
     * Many-to-Many relationship with Subjects via the class_subject pivot table.
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject', 'school_class_id', 'subject_id');
    }

    /**
     * RELATIONSHIP: Fees
     * A class can have multiple itemized fee components (Tuition, Uniform, etc.)
     */
    public function fees()
    {
        return $this->hasMany(ClassFee::class, 'school_class_id');
    }

    /**
     * RELATIONSHIP: Teacher Assignments
     * Linking specific teachers to subjects within this specific class arm.
     */
    public function assignments()
    {
        return $this->hasMany(TeacherAssignment::class, 'school_class_id');
    }
}