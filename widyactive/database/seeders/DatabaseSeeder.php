<?php

namespace Database\Seeders;

use App\Models\Athlete;
use App\Models\Attendance;
use App\Models\CoachEvaluation;
use App\Models\PerformanceMetric;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create a Default Coach
        $coach = User::create([
            'name' => 'Coach Marcus',
            'email' => 'coach@widyactive.com',
            'password' => Hash::make('password'),
        ]);

        // 2. Define Sample Athletes
        $athletesData = [
            ['name' => 'Alexander Thompson', 'email' => 'alex@widyactive.com', 'sport' => 'Basketball', 'date_of_birth' => '2004-03-12'],
            ['name' => 'Sarah Jenkins', 'email' => 'sarah@widyactive.com', 'sport' => 'Running', 'date_of_birth' => '2005-08-22'],
            ['name' => 'Marcus Aurelius', 'email' => 'marcus@widyactive.com', 'sport' => 'Swimming', 'date_of_birth' => '2003-11-05'],
            ['name' => 'Elena Rostova', 'email' => 'elena@widyactive.com', 'sport' => 'Gymnastics', 'date_of_birth' => '2006-05-18'],
            ['name' => 'Kenji Tanaka', 'email' => 'kenji@widyactive.com', 'sport' => 'Basketball', 'date_of_birth' => '2004-09-30'],
        ];

        $athletes = [];
        foreach ($athletesData as $data) {
            $athletes[] = Athlete::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'sport' => $data['sport'],
                'date_of_birth' => $data['date_of_birth'],
            ]);
        }

        // 3. Create historical Performance Metrics (over past 4 weeks)
        foreach ($athletes as $athlete) {
            // Base values for stats
            $baseReadiness = rand(65, 85);
            $basePerformance = rand(60, 85);
            $baseSpeed = rand(50, 90) / 10;
            $baseStrength = rand(50, 90) / 10;
            $baseEndurance = rand(50, 90) / 10;
            $baseMental = rand(65, 85);

            for ($week = 4; $week >= 0; $week--) {
                $date = now()->subWeeks($week)->subDays(rand(0, 3))->format('Y-m-d');
                
                PerformanceMetric::create([
                    'athlete_id' => $athlete->id,
                    'readiness_score' => min(100, max(0, $baseReadiness + rand(-10, 15))),
                    'performance_score' => min(100, max(0, $basePerformance + rand(-10, 15))),
                    'speed' => min(10.0, max(0.0, $baseSpeed + (rand(-10, 15) / 10))),
                    'strength' => min(10.0, max(0.0, $baseStrength + (rand(-10, 15) / 10))),
                    'endurance' => min(10.0, max(0.0, $baseEndurance + (rand(-10, 15) / 10))),
                    'mental_score' => min(100, max(0, $baseMental + rand(-10, 15))),
                    'recorded_at' => $date,
                ]);
            }

            // 4. Create Coach Evaluations
            CoachEvaluation::create([
                'athlete_id' => $athlete->id,
                'coach_name' => $coach->name,
                'strengths' => 'Strong discipline, matches performance targets regularly.',
                'weaknesses' => 'Focus drops when fatigue kicks in after intensive intervals.',
                'recommendations' => 'Incorporate core stability routines and dynamic recovery sessions.',
                'mental_notes' => 'Determined mindset, responds well to direct feedback.',
            ]);

            // 5. Create Attendance Records
            $statuses = ['present', 'present', 'present', 'present', 'late', 'absent'];
            for ($day = 10; $day >= 1; $day--) {
                $status = $statuses[array_rand($statuses)];
                Attendance::create([
                    'athlete_id' => $athlete->id,
                    'status' => $status,
                    'recorded_date' => now()->subDays($day)->format('Y-m-d'),
                    'notes' => $status === 'late' ? 'Tardiness due to transport issues' : ($status === 'absent' ? 'Medical leave approval' : 'Standard check-in'),
                ]);
            }
        }
    }
}
