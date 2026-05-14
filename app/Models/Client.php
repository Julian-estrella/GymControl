<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'membership_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function membershipHistories()
    {
        return $this->hasMany(MembershipHistory::class);
    }

    protected static function booted()
    {
        static::created(function ($client) {
            if (!$client->user_id && $client->email) {
                $user = User::where('email', $client->email)->first();
                if (!$user) {
                    $user = User::create([
                        'name' => $client->name,
                        'email' => $client->email,
                        'phone' => $client->phone,
                        'password' => bcrypt('password'),
                        'role' => User::ROLE_CLIENTE,
                        'is_active' => true,
                    ]);
                }
                $client->updateQuietly(['user_id' => $user->id]);
            }
        });

        static::updated(function ($client) {
            if ($client->user) {
                $client->user->updateQuietly([
                    'name' => $client->name,
                    'email' => $client->email,
                    'phone' => $client->phone,
                ]);
            }
        });
    }
}
