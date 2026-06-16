@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Breadcrumb / Header -->
    <div>
        <a href="{{ route('athletes.index') }}" class="text-xs font-semibold text-slate-400 hover:text-white transition flex items-center space-x-1.5 mb-2">
            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
            </svg>
            <span>Back to Directory</span>
        </a>
        <h1 class="text-3xl font-extrabold tracking-tight text-white">Register Athlete</h1>
        <p class="text-sm text-slate-400 mt-1">Enroll a new athlete in the diagnostics and intelligence database</p>
    </div>

    <!-- Register Form -->
    <div class="glass-card p-6 md:p-8 border border-white/5 bg-slate-900/40 relative overflow-hidden">
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-orange-500/5 rounded-full blur-3xl pointer-events-none"></div>

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-lg bg-red-950/40 border border-red-500/20 text-red-400 text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('athletes.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Athlete Name</label>
                    <input type="text" id="name" name="name" required value="{{ old('name') }}" placeholder="e.g. John Doe"
                           class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-sm text-slate-200 outline-none focus:border-orange-500/50 transition">
                </div>

                <!-- Email -->
                <div class="md:col-span-2">
                    <label for="email" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Email Address</label>
                    <input type="email" id="email" name="email" required value="{{ old('email') }}" placeholder="e.g. john@widyactive.com"
                           class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-sm text-slate-200 outline-none focus:border-orange-500/50 transition">
                </div>

                <!-- DOB -->
                <div>
                    <label for="date_of_birth" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" required value="{{ old('date_of_birth') }}"
                           class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-sm text-slate-200 outline-none focus:border-orange-500/50 transition">
                </div>

                <!-- Sport -->
                <div>
                    <label for="sport" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Sport Discipline</label>
                    <input type="text" id="sport" name="sport" required value="{{ old('sport') }}" placeholder="e.g. Basketball, Running"
                           class="w-full px-4 py-2.5 rounded-lg bg-slate-950 border border-white/10 text-sm text-slate-200 outline-none focus:border-orange-500/50 transition">
                </div>
            </div>

            <!-- Submit buttons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-white/5">
                <a href="{{ route('athletes.index') }}" class="px-5 py-2.5 rounded-lg border border-white/10 bg-transparent text-sm font-semibold text-slate-300 hover:text-white transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-gradient-to-r from-orange-500 to-amber-500 hover:opacity-95 text-slate-950 font-bold text-sm tracking-wide transition shadow-lg cursor-pointer">
                    Create Athlete
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
