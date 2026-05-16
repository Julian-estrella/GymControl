<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'folio',
        'client_id',
        'client_membership_id',
        'membership_plan_id',
        'amount',
        'payment_method',
        'status',
        'registered_by',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function clientMembership()
    {
        return $this->belongsTo(ClientMembership::class);
    }

    public function membershipPlan()
    {
        return $this->belongsTo(MembershipPlan::class);
    }

    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    protected static function booted()
    {
        static::creating(function ($payment) {
            if (empty($payment->folio)) {
                $payment->folio = 'PAY-' . strtoupper(substr(uniqid(), -6));
            }
        });
    }
}
