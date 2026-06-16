<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Athlete extends Model
{
    protected $fillable = [
        'name',
        'email',
        'date_of_birth',
        'sport',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function performanceMetrics(): HasMany
    {
        return $this->hasMany(PerformanceMetric::class)->orderBy('recorded_at', 'desc');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class)->orderBy('recorded_date', 'desc');
    }

    public function coachEvaluations(): HasMany
    {
        return $this->hasMany(CoachEvaluation::class)->orderBy('created_at', 'desc');
    }

    // Average Readiness Score helper
    public function getAverageReadinessAttribute(): float
    {
        return round($this->performanceMetrics()->avg('readiness_score') ?? 0, 1);
    }

    // Average Performance Score helper
    public function getAveragePerformanceAttribute(): float
    {
        return round($this->performanceMetrics()->avg('performance_score') ?? 0, 1);
    }

    // Latest Performance Score helper
    public function getLatestPerformanceScoreAttribute(): int
    {
        $latest = $this->performanceMetrics()->first();
        return $latest ? $latest->performance_score : 0;
    }

    // Latest Readiness Score helper
    public function getLatestReadinessScoreAttribute(): int
    {
        $latest = $this->performanceMetrics()->first();
        return $latest ? $latest->readiness_score : 0;
    }

    // Attendance Rate (Present + Late / Total)
    public function getAttendanceRateAttribute(): float
    {
        $total = $this->attendances()->count();
        if ($total === 0) return 0.0;
        
        $attended = $this->attendances()->whereIn('status', ['present', 'late'])->count();
        return round(($attended / $total) * 100, 1);
    }

    // Predict performance level
    public function getPredictionAttribute(): string
    {
        $avgPerf = $this->average_performance;
        $avgRead = $this->average_readiness;
        
        if ($avgPerf >= 85 && $avgRead >= 80) {
            return 'Elite Candidate';
        } elseif ($avgPerf >= 70 && $avgRead >= 70) {
            return 'Consistent Performer';
        } elseif ($avgPerf < 60 || $avgRead < 60) {
            return 'Needs Focus';
        }
        
        return 'Development Level';
    }
}
