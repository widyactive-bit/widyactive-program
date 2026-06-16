@extends('layouts.app')

@section('content')
<div class="space-y-8">

    <!-- Back button & actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('athletes.index') }}" class="text-xs font-semibold text-slate-400 hover:text-white transition flex items-center space-x-1.5">
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
            </svg>
            <span>Back to Directory</span>
        </a>
        <div class="flex space-x-2">
            <a href="{{ route('athletes.edit', $athlete->id) }}" class="px-4 py-2 rounded-lg bg-white/5 border border-white/10 hover:bg-white/10 text-xs font-semibold tracking-wide text-white transition flex items-center space-x-1">
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>Edit Profile</span>
            </a>
            <form action="{{ route('athletes.destroy', $athlete->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this athlete and all their diagnostic history?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 rounded-lg bg-red-950/40 border border-red-500/20 hover:bg-red-900/35 text-xs font-semibold tracking-wide text-red-400 transition flex items-center space-x-1 cursor-pointer">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span>Delete Athlete</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Profile Overview Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Profile Card & Predicted Potential -->
        <div class="space-y-6">
            <!-- Profile Info Card -->
            <div class="glass-card p-6 border border-white/5 bg-slate-900/40 relative overflow-hidden text-center">
                <div class="absolute -top-10 -right-10 w-24 h-24 bg-orange-500/5 rounded-full blur-2xl pointer-events-none"></div>
                
                <div class="mx-auto h-20 w-20 rounded-2xl bg-gradient-to-tr from-accent to-gold flex items-center justify-center font-black text-slate-950 text-3xl shadow-lg neon-glow-orange mb-4">
                    {{ substr($athlete->name, 0, 1) }}
                </div>
                
                <h2 class="text-2xl font-bold text-white">{{ $athlete->name }}</h2>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-widest mt-1">{{ $athlete->sport }}</p>
                
                <div class="mt-6 border-t border-b border-white/5 py-4 grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="block text-slate-500 font-medium">Email</span>
                        <span class="block text-slate-200 font-semibold mt-0.5 truncate">{{ $athlete->email }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-500 font-medium">Age</span>
                        <span class="block text-slate-200 font-semibold mt-0.5">{{ $athlete->date_of_birth->age }} years old</span>
                    </div>
                </div>

                <div class="mt-6 flex flex-col items-center justify-center">
                    <span class="text-slate-500 text-[10px] uppercase font-bold tracking-widest block mb-2">Predicted Intelligence Level</span>
                    <span class="inline-block px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider
                        @if($athlete->prediction === 'Elite Candidate')
                            bg-yellow-950/40 text-yellow-400 border border-yellow-500/20 neon-glow-gold
                        @elseif($athlete->prediction === 'Consistent Performer')
                            bg-orange-950/40 text-orange-400 border border-orange-500/20 neon-glow-orange
                        @elseif($athlete->prediction === 'Needs Focus')
                            bg-red-950/40 text-red-400 border border-red-500/20
                        @else
                            bg-slate-900 text-slate-400 border border-white/5
                        @endif">
                        {{ $athlete->prediction }}
                    </span>
                </div>
            </div>

            <!-- Performance Rings -->
            <div class="glass-card p-6 border border-white/5 bg-slate-900/40">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-5">Average Diagnostic Index</h3>
                <div class="grid grid-cols-3 gap-2 text-center">
                    <div>
                        <span class="block text-[10px] text-slate-500 uppercase font-bold tracking-wider">Performance</span>
                        <span class="block text-2xl font-black text-amber-400 mt-2">{{ $athlete->average_performance }}%</span>
                    </div>
                    <div>
                        <span class="block text-[10px] text-slate-500 uppercase font-bold tracking-wider">Readiness</span>
                        <span class="block text-2xl font-black text-orange-400 mt-2">{{ $athlete->average_readiness }}%</span>
                    </div>
                    <div>
                        <span class="block text-[10px] text-slate-500 uppercase font-bold tracking-wider">Attendance</span>
                        <span class="block text-2xl font-black text-emerald-400 mt-2">{{ $athlete->attendance_rate }}%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Tabs (Timeline, Metrics Logger, Coach Evaluation, Attendance) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Tabs Nav -->
            <div class="flex border-b border-white/5 space-x-8 text-sm font-medium">
                <button onclick="switchTab('diagnostics')" id="tab-btn-diagnostics" class="tab-btn border-b-2 border-orange-500 text-orange-400 pb-4 transition-all focus:outline-none">
                    Diagnostics History
                </button>
                <button onclick="switchTab('log-metrics')" id="tab-btn-log-metrics" class="tab-btn border-b-2 border-transparent text-slate-400 hover:text-white pb-4 transition-all focus:outline-none">
                    Log Metrics
                </button>
                <button onclick="switchTab('evaluations')" id="tab-btn-evaluations" class="tab-btn border-b-2 border-transparent text-slate-400 hover:text-white pb-4 transition-all focus:outline-none">
                    Coach Evaluations ({{ count($evaluations) }})
                </button>
                <button onclick="switchTab('attendance')" id="tab-btn-attendance" class="tab-btn border-b-2 border-transparent text-slate-400 hover:text-white pb-4 transition-all focus:outline-none">
                    Attendance Log
                </button>
            </div>

            <!-- Tab Contents -->
            <div>
                
                <!-- Tab 1: Diagnostics History -->
                <div id="tab-content-diagnostics" class="tab-panel space-y-6">
                    <!-- Historical SVG Line Chart -->
                    <div class="glass-card p-5 border border-white/5 bg-slate-900/40">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-sm font-bold text-white">Performance Timeline</h4>
                            <div class="flex space-x-3 text-[10px] font-semibold">
                                <span class="flex items-center"><span class="h-2.5 w-2.5 rounded-full bg-orange-500 inline-block mr-1"></span>Readiness</span>
                                <span class="flex items-center"><span class="h-2.5 w-2.5 rounded-full bg-amber-400 inline-block mr-1"></span>Performance</span>
                            </div>
                        </div>
                        
                        @if(count($chartData) > 0)
                            <!-- Dynamic SVG chart -->
                            <div class="w-full h-48 bg-slate-950/40 rounded-lg p-2 relative">
                                <svg class="w-full h-full" overflow="visible" viewBox="0 0 500 130">
                                    @php
                                        $cnt = count($chartData);
                                    @endphp
                                    <!-- Readiness Line -->
                                    <polyline fill="none" stroke="#f97316" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" points="
                                        @foreach($chartData as $idx => $metric)
                                            {{ ($cnt > 1) ? ($idx / ($cnt - 1)) * 440 + 30 : 250 }},{{ 110 - ($metric['readiness'] / 100) * 90 }}
                                        @endforeach
                                    "/>
                                    <!-- Performance Line -->
                                    <polyline fill="none" stroke="#fbbf24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" points="
                                        @foreach($chartData as $idx => $metric)
                                            {{ ($cnt > 1) ? ($idx / ($cnt - 1)) * 440 + 30 : 250 }},{{ 110 - ($metric['performance'] / 100) * 90 }}
                                        @endforeach
                                    "/>
                                    <!-- Dots -->
                                    @foreach($chartData as $idx => $metric)
                                        @php
                                            $cx = ($cnt > 1) ? ($idx / ($cnt - 1)) * 440 + 30 : 250;
                                            $cyR = 110 - ($metric['readiness'] / 100) * 90;
                                            $cyP = 110 - ($metric['performance'] / 100) * 90;
                                        @endphp
                                        <circle cx="{{ $cx }}" cy="{{ $cyR }}" r="3.5" fill="#f97316" stroke="#090d16" stroke-width="1"/>
                                        <circle cx="{{ $cx }}" cy="{{ $cyP }}" r="3.5" fill="#fbbf24" stroke="#090d16" stroke-width="1"/>
                                    @endforeach
                                </svg>
                                <div class="flex justify-between text-[8px] text-slate-500 font-semibold px-6 mt-1">
                                    @foreach($chartData as $metric)
                                        <span>{{ $metric['date'] }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <p class="text-xs text-slate-500 text-center py-12">No performance metrics recorded yet. Log one in the 'Log Metrics' tab!</p>
                        @endif
                    </div>

                    <!-- History Table -->
                    <div class="glass-card border border-white/5 overflow-hidden">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest p-4 bg-slate-950/40 border-b border-white/5">Diagnostic Logs</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-xs text-slate-300 divide-y divide-white/5">
                                <thead class="bg-slate-950/20 text-slate-400 uppercase tracking-wider font-bold">
                                    <tr>
                                        <th class="px-5 py-3">Date</th>
                                        <th class="px-5 py-3 text-center">Readiness</th>
                                        <th class="px-5 py-3 text-center">Performance</th>
                                        <th class="px-5 py-3 text-center">Speed</th>
                                        <th class="px-5 py-3 text-center">Strength</th>
                                        <th class="px-5 py-3 text-center">Endurance</th>
                                        <th class="px-5 py-3 text-center">Mental</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    @forelse($athlete->performanceMetrics as $m)
                                        <tr class="hover:bg-white/[0.01]">
                                            <td class="px-5 py-3 font-semibold text-white">{{ $m->recorded_at->format('M d, Y') }}</td>
                                            <td class="px-5 py-3 text-center text-orange-400 font-bold">{{ $m->readiness_score }}%</td>
                                            <td class="px-5 py-3 text-center text-amber-400 font-bold">{{ $m->performance_score }}%</td>
                                            <td class="px-5 py-3 text-center">{{ $m->speed }}/10</td>
                                            <td class="px-5 py-3 text-center">{{ $m->strength }}/10</td>
                                            <td class="px-5 py-3 text-center">{{ $m->endurance }}/10</td>
                                            <td class="px-5 py-3 text-center text-blue-400">{{ $m->mental_score }}%</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-5 py-6 text-center text-slate-500">No diagnostic logs.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Log Metrics Form -->
                <div id="tab-content-log-metrics" class="tab-panel space-y-6 hidden animate-fade-in">
                    <div class="glass-card p-6 border border-white/5 bg-slate-900/40">
                        <h4 class="text-sm font-bold text-white mb-4">Record Daily Performance Diagnostic</h4>
                        
                        <form action="{{ route('athletes.metrics.store', $athlete->id) }}" method="POST" class="space-y-5">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Readiness Score (0 - 100)</label>
                                    <input type="number" name="readiness_score" required min="0" max="100" value="70"
                                           class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-sm text-slate-200 outline-none focus:border-orange-500/50 transition">
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Performance Score (0 - 100)</label>
                                    <input type="number" name="performance_score" required min="0" max="100" value="70"
                                           class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-sm text-slate-200 outline-none focus:border-orange-500/50 transition">
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Speed Factor (0.0 - 10.0)</label>
                                    <input type="number" name="speed" step="0.1" required min="0" max="10" value="5.0"
                                           class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-sm text-slate-200 outline-none focus:border-orange-500/50 transition">
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Strength Factor (0.0 - 10.0)</label>
                                    <input type="number" name="strength" step="0.1" required min="0" max="10" value="5.0"
                                           class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-sm text-slate-200 outline-none focus:border-orange-500/50 transition">
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Endurance Factor (0.0 - 10.0)</label>
                                    <input type="number" name="endurance" step="0.1" required min="0" max="10" value="5.0"
                                           class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-sm text-slate-200 outline-none focus:border-orange-500/50 transition">
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Mental Index (0 - 100)</label>
                                    <input type="number" name="mental_score" required min="0" max="100" value="70"
                                           class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-sm text-slate-200 outline-none focus:border-orange-500/50 transition">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Recorded Date</label>
                                    <input type="date" name="recorded_at" required value="{{ date('Y-m-d') }}"
                                           class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-sm text-slate-200 outline-none focus:border-orange-500/50 transition">
                                </div>
                            </div>
                            
                            <div class="flex justify-end pt-3">
                                <button type="submit" class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-orange-500 to-amber-500 hover:opacity-95 text-slate-950 font-bold text-sm tracking-wide transition shadow-lg cursor-pointer">
                                    Log Metrics
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tab 3: Coach Evaluations -->
                <div id="tab-content-evaluations" class="tab-panel space-y-6 hidden animate-fade-in">
                    
                    <!-- Form to add new evaluation -->
                    <div class="glass-card p-6 border border-white/5 bg-slate-900/40">
                        <h4 class="text-sm font-bold text-white mb-4">Write New Coach Evaluation</h4>
                        
                        <form action="{{ route('athletes.evaluations.store', $athlete->id) }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Strengths</label>
                                <textarea name="strengths" required rows="2" placeholder="e.g. Excellent explosive speed, high tactical awareness"
                                          class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-sm text-slate-200 outline-none focus:border-orange-500/50 transition"></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Weaknesses</label>
                                <textarea name="weaknesses" required rows="2" placeholder="e.g. Endurance drops in 4th quarter, needs core strength training"
                                          class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-sm text-slate-200 outline-none focus:border-orange-500/50 transition"></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Recommendations</label>
                                <textarea name="recommendations" required rows="2" placeholder="e.g. Incorporate 3x heavy squats weekly, hydration plan check"
                                          class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-sm text-slate-200 outline-none focus:border-orange-500/50 transition"></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Mental & Psychological Notes (Optional)</label>
                                <textarea name="mental_notes" rows="2" placeholder="e.g. High confidence levels, slightly anxious during pressure tests"
                                          class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-sm text-slate-200 outline-none focus:border-orange-500/50 transition"></textarea>
                            </div>

                            <div class="flex justify-end pt-2">
                                <button type="submit" class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-orange-500 to-amber-500 hover:opacity-95 text-slate-950 font-bold text-sm tracking-wide transition shadow-lg cursor-pointer">
                                    Submit Evaluation
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- List evaluations -->
                    <div class="space-y-4">
                        @forelse($evaluations as $eval)
                            <div class="glass-card p-5 border border-white/5 bg-slate-900/40 relative overflow-hidden">
                                <div class="flex justify-between items-center text-xs border-b border-white/5 pb-3 mb-3">
                                    <span class="font-bold text-orange-400">Evaluated by {{ $eval->coach_name }}</span>
                                    <span class="text-slate-500">{{ $eval->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="space-y-3 text-xs">
                                    <div>
                                        <span class="block text-[10px] text-slate-500 uppercase font-bold tracking-widest mb-0.5">Strengths</span>
                                        <p class="text-slate-200 leading-relaxed">{{ $eval->strengths }}</p>
                                    </div>
                                    <div>
                                        <span class="block text-[10px] text-slate-500 uppercase font-bold tracking-widest mb-0.5">Weaknesses</span>
                                        <p class="text-slate-200 leading-relaxed">{{ $eval->weaknesses }}</p>
                                    </div>
                                    <div>
                                        <span class="block text-[10px] text-slate-500 uppercase font-bold tracking-widest mb-0.5">Recommendations</span>
                                        <p class="text-slate-200 leading-relaxed font-medium">{{ $eval->recommendations }}</p>
                                    </div>
                                    @if($eval->mental_notes)
                                        <div class="p-2.5 rounded-lg bg-blue-950/20 border border-blue-900/20">
                                            <span class="block text-[9px] text-blue-400 uppercase font-bold tracking-widest mb-0.5">Mental State notes</span>
                                            <p class="text-slate-300 italic leading-relaxed">{{ $eval->mental_notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-500 text-center py-8">No evaluations submitted for this athlete yet.</p>
                        @endforelse
                    </div>

                </div>

                <!-- Tab 4: Attendance Log -->
                <div id="tab-content-attendance" class="tab-panel space-y-6 hidden animate-fade-in">
                    <div class="glass-card border border-white/5 overflow-hidden">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest p-4 bg-slate-950/40 border-b border-white/5">Attendance Logs</h4>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-xs text-slate-300 divide-y divide-white/5">
                                <thead class="bg-slate-950/20 text-slate-400 uppercase tracking-wider font-bold">
                                    <tr>
                                        <th class="px-5 py-3">Date</th>
                                        <th class="px-5 py-3 text-center">Status</th>
                                        <th class="px-5 py-3">Notes</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    @forelse($attendances as $att)
                                        <tr class="hover:bg-white/[0.01]">
                                            <td class="px-5 py-3 font-semibold text-white">{{ $att->recorded_date->format('M d, Y') }}</td>
                                            <td class="px-5 py-3 text-center">
                                                <span class="inline-block px-2 py-0.5 rounded font-bold uppercase text-[9px] tracking-wider
                                                    @if($att->status === 'present')
                                                        bg-emerald-950/40 text-emerald-400 border border-emerald-500/20
                                                    @elseif($att->status === 'late')
                                                        bg-amber-950/40 text-amber-400 border border-amber-500/20
                                                    @else
                                                        bg-red-950/40 text-red-400 border border-red-500/20
                                                    @endif">
                                                    {{ $att->status }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-3 text-slate-400 italic">{{ $att->notes ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-5 py-6 text-center text-slate-500">No attendance logs found. Use the QR Attendance system to check-in.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<!-- Tab switching Javascript -->
<script>
    function switchTab(tabId) {
        // Hide all panels
        document.querySelectorAll('.tab-panel').forEach(function (panel) {
            panel.classList.add('hidden');
        });
        
        // Remove active styles from all buttons
        document.querySelectorAll('.tab-btn').forEach(function (btn) {
            btn.classList.remove('border-orange-500', 'text-orange-400');
            btn.classList.add('border-transparent', 'text-slate-400');
        });
        
        // Show target panel
        document.getElementById('tab-content-' + tabId).classList.remove('hidden');
        
        // Set active button styles
        var activeBtn = document.getElementById('tab-btn-' + tabId);
        activeBtn.classList.remove('border-transparent', 'text-slate-400');
        activeBtn.classList.add('border-orange-500', 'text-orange-400');
    }
</script>
@endsection
