<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolBankDetail extends Model
{
    protected $fillable = ['school_id', 'bank_name', 'account_number', 'account_name', 'is_active'];
}
