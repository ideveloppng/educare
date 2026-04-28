<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportContact extends Model
{
    protected $fillable = [
        'platform', 'label', 'value', 'link', 'icon', 'is_active'
    ];
}
