<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['school_id', 'type', 'title', 'category', 'amount', 'date', 'description'];
    
    protected $casts = ['date' => 'date'];
}