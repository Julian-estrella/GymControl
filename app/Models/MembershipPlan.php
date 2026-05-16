<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'duration_days',
        'price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration_days' => 'integer',
        'price' => 'decimal:2',
    ];

    public function clientMemberships()
    {
        return $this->hasMany(ClientMembership::class);
    }
}
