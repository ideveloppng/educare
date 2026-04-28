<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassFee extends Model
{
    protected $fillable = ['school_id', 'school_class_id', 'title', 'amount'];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}