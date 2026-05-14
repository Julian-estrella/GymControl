<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'status',
        'observations',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
