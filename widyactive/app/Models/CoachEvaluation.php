<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoachEvaluation extends Model
{
    protected $fillable = [
        'athlete_id',
        'coach_name',
        'strengths',
        'weaknesses',
        'recommendations',
        'mental_notes',
    ];

    public function athlete(): BelongsTo
    {
        return $this->belongsTo(Athlete::class);
    }
}
