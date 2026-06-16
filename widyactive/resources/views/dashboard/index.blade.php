@extends('layouts.app')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">Dashboard Overview</h1>
            <p class="text-sm text-slate-400 mt-1">Real-time team readiness and athletic diagnostics</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('athletes.create') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-orange-500 to-amber-500 hover:opacity-95 text-slate-950 font-bold text-sm tracking-wide transition flex items-center space-x-2 shadow-lg shadow-orange-500/10">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Add Athlete</span>
            </a>
            <a href="{{ route('attendance.index') }}" class="px-5 py-2.5 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 text-white font-semibold text-sm tracking-wide transition flex items-center space-x-2">
                <svg class="h-4 w-4 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-4v-4m-2 4h-2m-2-4H4m8-8H4m8-8h8"/>
                </svg>
                <span>Track Attendance</span>
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Card 1 -->
        <div class="glass-card p-6 border border-white/5 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <svg class="h-16 w-16 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Athletes</p>
                <h3 class="text-4xl font-extrabold text-white mt-2">{{ $totalAthletes }}</h3>
            </div>
            <div class="mt-4 text-xs text-slate-400">
                Active squad size
            </div>
        </div>

        <!-- Card 2 -->
        <div class="glass-card p-6 border border-white/5 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <svg class="h-16 w-16 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Avg Performance</p>
                <h3 class="text-4xl font-extrabold text-white mt-2">{{ $avgPerformance }}<span class="text-lg font-normal text-slate-500">/100</span></h3>
            </div>
            <div class="mt-4">
                <div class="w-full bg-slate-800 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-500 to-yellow-400 h-1.5 rounded-full" style="width: {{ $avgPerformance }}%"></div>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="glass-card p-6 border border-white/5 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <svg class="h-16 w-16 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Avg Readiness</p>
                <h3 class="text-4xl font-extrabold text-white mt-2">{{ $avgReadiness }}<span class="text-lg font-normal text-slate-500">/100</span></h3>
            </div>
            <div class="mt-4">
                <div class="w-full bg-slate-800 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500 to-amber-500 h-1.5 rounded-full" style="width: {{ $avgReadiness }}%"></div>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="glass-card p-6 border border-white/5 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <svg class="h-16 w-16 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Attendance Rate</p>
                <h3 class="text-4xl font-extrabold text-white mt-2">{{ $attendanceRate }}<span class="text-lg font-normal text-slate-500">%</span></h3>
            </div>
            <div class="mt-4">
                <div class="w-full bg-slate-800 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-1.5 rounded-full" style="width: {{ $attendanceRate }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Breakdown Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Performance Trend Line Chart -->
        <div class="glass-card p-6 border border-white/5 lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-white">Squad Performance Trend</h3>
                    <p class="text-xs text-slate-400">Weekly average metrics (Performance vs Readiness)</p>
                </div>
                <div class="flex items-center space-x-4 text-xs">
                    <span class="flex items-center"><span class="h-3 w-3 rounded-full bg-orange-500 inline-block mr-1.5"></span>Readiness</span>
                    <span class="flex items-center"><span class="h-3 w-3 rounded-full bg-amber-400 inline-block mr-1.5"></span>Performance</span>
                </div>
            </div>

            <!-- Custom Premium SVG Line Chart -->
            <div class="relative w-full h-64 bg-slate-950/40 rounded-xl border border-white/5 p-4 flex flex-col justify-between overflow-hidden">
                @php
                    // Compute SVG points
                    $perfPoints = [];
                    $readPoints = [];
                    $cnt = count($weeklyTrend);
                    foreach($weeklyTrend as $idx => $trend) {
                        $x = ($cnt > 1) ? round(($idx / ($cnt - 1)) * 100, 1) : 50;
                        // Map 0-100 score to 0-80 chart height (inverted, lower y is higher score)
                        // Height is 180px, padding top 20px, bottom 20px
                        $yPerf = 180 - round(($trend['performance'] / 100) * 140);
                        $yRead = 180 - round(($trend['readiness'] / 100) * 140);
                        $perfPoints[] = "$x%,$yPerf";
                        $readPoints[] = "$x%,$yRead";
                    }
                    $perfPath = implode(' ', $perfPoints);
                    $readPath = implode(' ', $readPoints);
                @endphp
                <div class="absolute inset-0 flex flex-col justify-between py-6 px-10 pointer-events-none opacity-10">
                    <div class="border-b border-white w-full"></div>
                    <div class="border-b border-white w-full"></div>
                    <div class="border-b border-white w-full"></div>
                    <div class="border-b border-white w-full"></div>
                </div>
                
                <div class="relative w-full flex-1">
                    <svg class="w-full h-full" overflow="visible">
                        <!-- Readiness Path -->
                        <polyline fill="none" stroke="#f97316" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" points="
                            @foreach($weeklyTrend as $idx => $trend)
                                {{ ($cnt > 1) ? ($idx / ($cnt - 1)) * 480 + 30 : 250 }},{{ 170 - ($trend['readiness'] / 100) * 130 }}
                            @endforeach
                        " class="drop-shadow-[0_4px_8px_rgba(249,115,22,0.3)]"/>
                        
                        <!-- Performance Path -->
                        <polyline fill="none" stroke="#fbbf24" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" points="
                            @foreach($weeklyTrend as $idx => $trend)
                                {{ ($cnt > 1) ? ($idx / ($cnt - 1)) * 480 + 30 : 250 }},{{ 170 - ($trend['performance'] / 100) * 130 }}
                            @endforeach
                        " class="drop-shadow-[0_4px_8px_rgba(251,191,36,0.3)]"/>

                        <!-- Interactive Nodes -->
                        @foreach($weeklyTrend as $idx => $trend)
                            @php
                                $cx = ($cnt > 1) ? ($idx / ($cnt - 1)) * 480 + 30 : 250;
                                $cyRead = 170 - ($trend['readiness'] / 100) * 130;
                                $cyPerf = 170 - ($trend['performance'] / 100) * 130;
                            @endphp
                            <circle cx="{{ $cx }}" cy="{{ $cyRead }}" r="5" fill="#f97316" stroke="#090d16" stroke-width="1.5"/>
                            <circle cx="{{ $cx }}" cy="{{ $cyPerf }}" r="5" fill="#fbbf24" stroke="#090d16" stroke-width="1.5"/>
                        @endforeach
                    </svg>
                </div>
                
                <div class="flex justify-between text-[10px] text-slate-500 font-semibold px-4 mt-2">
                    @foreach($weeklyTrend as $trend)
                        <span>{{ $trend['week'] }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sports Performance Breakdown -->
        <div class="glass-card p-6 border border-white/5">
            <h3 class="text-lg font-bold text-white mb-6">Sports Distribution</h3>
            
            <div class="space-y-5">
                @forelse($sportStats as $stat)
                    <div>
                        <div class="flex justify-between items-center text-xs mb-1.5">
                            <span class="font-bold text-slate-300">{{ strtoupper($stat['sport']) }}</span>
                            <span class="text-slate-400 font-semibold">{{ $stat['count'] }} Athletes &bull; <span class="text-amber-400 font-bold">{{ $stat['avg_performance'] }}%</span></span>
                        </div>
                        <div class="w-full bg-slate-900 rounded-full h-2 overflow-hidden border border-white/5">
                            <div class="bg-gradient-to-r from-orange-500 to-amber-500 h-2 rounded-full shadow-lg shadow-orange-500/10" style="width: {{ $stat['avg_performance'] }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 text-center py-10">No sports registered yet.</p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Leaderboard & Recent Performance Logs -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Athlete Leaderboard -->
        <div class="glass-card p-6 border border-white/5">
            <h3 class="text-lg font-bold text-white mb-5 flex items-center">
                <svg class="h-5 w-5 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span>Top Performers Leaderboard</span>
            </h3>
            
            <div class="divide-y divide-white/5">
                @forelse($leaderboard as $entry)
                    <div class="py-3.5 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="h-9 w-9 rounded-lg bg-orange-950/40 border border-orange-500/10 flex items-center justify-center font-bold text-orange-400">
                                {{ substr($entry['athlete']->name, 0, 1) }}
                            </div>
                            <div>
                                <a href="{{ route('athletes.show', $entry['athlete']->id) }}" class="text-sm font-semibold text-white hover:text-orange-400 transition-colors">
                                    {{ $entry['athlete']->name }}
                                </a>
                                <p class="text-xs text-slate-400">{{ $entry['athlete']->sport }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-bold text-white">
                                {{ $entry['avg_performance'] }}
                                <span class="text-[10px] text-slate-500">Perf</span>
                            </div>
                            <!-- Badge -->
                            <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                @if($entry['prediction'] === 'Elite Candidate')
                                    bg-yellow-950/40 text-yellow-400 border border-yellow-500/20
                                @elseif($entry['prediction'] === 'Consistent Performer')
                                    bg-orange-950/40 text-orange-400 border border-orange-500/20
                                @elseif($entry['prediction'] === 'Needs Focus')
                                    bg-red-950/40 text-red-400 border border-red-500/20
                                @else
                                    bg-slate-900 text-slate-400 border border-white/5
                                @endif">
                                {{ $entry['prediction'] }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 text-center py-10">No metrics logged yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Activities / Logs -->
        <div class="glass-card p-6 border border-white/5">
            <h3 class="text-lg font-bold text-white mb-5 flex items-center">
                <svg class="h-5 w-5 text-orange-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Recent Diagnostics Log</span>
            </h3>

            <div class="space-y-4">
                @forelse($recentMetrics as $metric)
                    <div class="p-3.5 rounded-xl bg-slate-900/50 border border-white/5 flex justify-between items-center">
                        <div class="space-y-1">
                            <a href="{{ route('athletes.show', $metric->athlete->id) }}" class="text-sm font-semibold text-white hover:text-orange-400 transition-colors">
                                {{ $metric->athlete->name }}
                            </a>
                            <div class="flex items-center space-x-2 text-[10px] text-slate-500">
                                <span>Recorded on {{ $metric->recorded_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="px-2.5 py-1.5 rounded-lg bg-orange-950/40 border border-orange-500/20 text-center">
                                <span class="block text-[8px] font-bold text-orange-400 uppercase tracking-widest leading-none">Readiness</span>
                                <span class="text-xs font-black text-orange-400 leading-none mt-1 inline-block">{{ $metric->readiness_score }}</span>
                            </div>
                            <div class="px-2.5 py-1.5 rounded-lg bg-amber-950/40 border border-amber-500/20 text-center">
                                <span class="block text-[8px] font-bold text-amber-400 uppercase tracking-widest leading-none">Perf</span>
                                <span class="text-xs font-black text-amber-400 leading-none mt-1 inline-block">{{ $metric->performance_score }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500 text-center py-10">No recent metrics logged.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
