<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'plan_id',
        'amount',
        'transaction_id',
        'proof_of_payment',
        'status',
        'admin_notes'
    ];

    public function school() { return $this->belongsTo(School::class); }
    public function plan() { return $this->belongsTo(Plan::class); }
}