<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\Attendance;
use App\Models\PerformanceMetric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Athletes
        $totalAthletes = Athlete::count();

        // Avg Performance & Readiness Scores
        $avgPerformance = round(PerformanceMetric::avg('performance_score') ?? 0, 1);
        $avgReadiness = round(PerformanceMetric::avg('readiness_score') ?? 0, 1);

        // Overall Attendance Rate
        $totalAttendanceRecords = Attendance::count();
        $attendedRecords = Attendance::whereIn('status', ['present', 'late'])->count();
        $attendanceRate = $totalAttendanceRecords > 0 
            ? round(($attendedRecords / $totalAttendanceRecords) * 100, 1) 
            : 0.0;

        // Top Athletes Leaderboard
        $athletes = Athlete::all();
        $leaderboard = $athletes->map(function ($athlete) {
            return [
                'athlete' => $athlete,
                'avg_performance' => $athlete->average_performance,
                'avg_readiness' => $athlete->average_readiness,
                'prediction' => $athlete->prediction,
            ];
        })->sortByDesc('avg_performance')->take(5);

        // Recent metrics logs
        $recentMetrics = PerformanceMetric::with('athlete')
            ->orderBy('recorded_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Stats by sport
        $sportStats = Athlete::select('sport', DB::raw('count(*) as count'))
            ->whereNotNull('sport')
            ->groupBy('sport')
            ->get()
            ->map(function ($stat) {
                // Get avg performance for this sport
                $athleteIds = Athlete::where('sport', $stat->sport)->pluck('id');
                $avgPerf = round(PerformanceMetric::whereIn('athlete_id', $athleteIds)->avg('performance_score') ?? 0, 1);
                return [
                    'sport' => $stat->sport,
                    'count' => $stat->count,
                    'avg_performance' => $avgPerf,
                ];
            });

        // Weekly performance trend (past 6 weeks)
        $weeklyTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $dateStart = now()->subWeeks($i)->startOfWeek()->format('Y-m-d');
            $dateEnd = now()->subWeeks($i)->endOfWeek()->format('Y-m-d');
            
            $avgPerfWeek = PerformanceMetric::whereBetween('recorded_at', [$dateStart, $dateEnd])->avg('performance_score') ?? 0;
            $avgReadWeek = PerformanceMetric::whereBetween('recorded_at', [$dateStart, $dateEnd])->avg('readiness_score') ?? 0;
            
            $weeklyTrend[] = [
                'week' => 'Wk ' . (now()->subWeeks($i)->weekOfYear),
                'performance' => round($avgPerfWeek, 1),
                'readiness' => round($avgReadWeek, 1),
            ];
        }

        return view('dashboard.index', compact(
            'totalAthletes',
            'avgPerformance',
            'avgReadiness',
            'attendanceRate',
            'leaderboard',
            'recentMetrics',
            'sportStats',
            'weeklyTrend'
        ));
    }
}
