<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GymClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gym_classes';

    protected $fillable = [
        'name',
        'description',
        'trainer_id',
        'schedule',
        'max_capacity',
        'is_active',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'max_capacity' => 'integer',
        'schedule'     => 'array',
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}
