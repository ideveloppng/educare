<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = ['school_id', 'title', 'content', 'target_audience', 'priority', 'is_active', 'expires_at'];

    public function school() { return $this->belongsTo(School::class); }
}
