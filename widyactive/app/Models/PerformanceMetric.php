<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerformanceMetric extends Model
{
    protected $fillable = [
        'athlete_id',
        'readiness_score',
        'performance_score',
        'speed',
        'strength',
        'endurance',
        'mental_score',
        'recorded_at',
    ];

    protected $casts = [
        'readiness_score' => 'integer',
        'performance_score' => 'integer',
        'speed' => 'float',
        'strength' => 'float',
        'endurance' => 'float',
        'mental_score' => 'integer',
        'recorded_at' => 'date',
    ];

    public function athlete(): BelongsTo
    {
        return $this->belongsTo(Athlete::class);
    }
}
