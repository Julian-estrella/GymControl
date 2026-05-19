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
        'reminder_sent_at',
    ];

    protected $casts = [
        'start_date'       => 'date',
        'end_date'         => 'date',
        'reminder_sent_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function membershipPlan()
    {
        return $this->belongsTo(MembershipPlan::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getComputedStatusAttribute()
    {
        if ($this->status === 'cancelado') {
            return 'cancelado';
        }

        if ($this->end_date && $this->end_date < now()->startOfDay()) {
            return 'expirado';
        }

        return $this->status;
    }
}
