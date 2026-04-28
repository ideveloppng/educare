<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildLinkingRequest extends Model
{
   protected $fillable = ['guardian_id', 'school_id', 'admission_number', 'student_name', 'status', 'admin_notes'];
    public function guardian() { return $this->belongsTo(Guardian::class); }
}
