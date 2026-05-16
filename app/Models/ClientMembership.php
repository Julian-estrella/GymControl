<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'membership_plan_id',
        'start_date',
        'end_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function membershipPlan()
    {
        return $this->belongsTo(MembershipPlan::class);
    }
}
