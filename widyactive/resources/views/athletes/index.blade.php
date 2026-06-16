@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">Athlete Directory</h1>
            <p class="text-sm text-slate-400 mt-1">Manage and track your active athletic squad</p>
        </div>
        <div>
            <a href="{{ route('athletes.create') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-orange-500 to-amber-500 hover:opacity-95 text-slate-950 font-bold text-sm tracking-wide transition flex items-center space-x-2 shadow-lg">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Register Athlete</span>
            </a>
        </div>
    </div>

    <!-- Filters Panel -->
    <div class="glass-card p-4 border border-white/5 bg-slate-900/40">
        <form action="{{ route('athletes.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search by name or email..."
                       class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-sm text-slate-200 placeholder-slate-500 outline-none focus:border-orange-500/50 transition">
            </div>
            
            <div class="w-full md:w-48">
                <select name="sport" class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-sm text-slate-300 outline-none focus:border-orange-500/50 transition">
                    <option value="">All Sports</option>
                    @foreach($sportsList as $s)
                        <option value="{{ $s }}" {{ $sport === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex space-x-2">
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-white/5 border border-white/10 hover:bg-white/10 text-sm font-semibold text-white transition">
                    Apply Filters
                </button>
                @if($search || $sport)
                    <a href="{{ route('athletes.index') }}" class="px-4 py-2.5 rounded-lg bg-red-950/40 border border-red-500/20 hover:bg-red-900/35 text-sm font-semibold text-red-400 transition flex items-center">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Directory -->
    <div class="glass-card border border-white/5 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/5 text-left text-sm text-slate-300">
                <thead class="bg-slate-950/60 text-xs font-bold uppercase tracking-wider text-slate-400">
                    <tr>
                        <th scope="col" class="px-6 py-4">Name</th>
                        <th scope="col" class="px-6 py-4">Sport</th>
                        <th scope="col" class="px-6 py-4 text-center">Avg Performance</th>
                        <th scope="col" class="px-6 py-4 text-center">Avg Readiness</th>
                        <th scope="col" class="px-6 py-4 text-center">Prediction</th>
                        <th scope="col" class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 bg-transparent">
                    @forelse($athletes as $athlete)
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="h-9 w-9 rounded-lg bg-orange-950/30 border border-orange-500/10 flex items-center justify-center font-bold text-orange-400">
                                        {{ substr($athlete->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('athletes.show', $athlete->id) }}" class="font-bold text-white hover:text-orange-400 transition-colors">
                                            {{ $athlete->name }}
                                        </a>
                                        <div class="text-xs text-slate-500">{{ $athlete->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-200">
                                {{ ucfirst($athlete->sport) }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <span class="font-black text-amber-400 text-base">{{ $athlete->average_performance }}</span><span class="text-[10px] text-slate-500">/100</span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <span class="font-black text-orange-400 text-base">{{ $athlete->average_readiness }}</span><span class="text-[10px] text-slate-500">/100</span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <span class="inline-block px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                    @if($athlete->prediction === 'Elite Candidate')
                                        bg-yellow-950/40 text-yellow-400 border border-yellow-500/20
                                    @elseif($athlete->prediction === 'Consistent Performer')
                                        bg-orange-950/40 text-orange-400 border border-orange-500/20
                                    @elseif($athlete->prediction === 'Needs Focus')
                                        bg-red-950/40 text-red-400 border border-red-500/20
                                    @else
                                        bg-slate-900 text-slate-400 border border-white/5
                                    @endif">
                                    {{ $athlete->prediction }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right space-x-2 text-xs">
                                <a href="{{ route('athletes.show', $athlete->id) }}" class="text-orange-400 hover:text-orange-300 font-bold transition">View Profile</a>
                                <a href="{{ route('athletes.edit', $athlete->id) }}" class="text-slate-400 hover:text-white font-bold transition">Edit</a>
                                <form action="{{ route('athletes.destroy', $athlete->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this athlete and all their diagnostic history?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 font-bold transition bg-transparent border-none cursor-pointer">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-slate-500">
                                No athletes registered matching filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($athletes->hasPages())
            <div class="px-6 py-4 bg-slate-950/40 border-t border-white/5 flex items-center justify-between">
                {{ $athletes->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
