<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
        protected $fillable = [
        'school_id', 'user_id', 'month', 'year', 'gross_amount', 
        'tax_deduction', 'pension_deduction', 'union_dues', 'cooperative_deduction',
        'housing_allowance', 'feeding_allowance', 'transport_allowance', 'medical_benefit',
        'amount', 'payment_date', 'reference'
    ];
    public function user() { return $this->belongsTo(User::class); }
}
