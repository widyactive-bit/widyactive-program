@extends('layouts.app')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 glass-card p-8 md:p-10 border border-white/10 relative overflow-hidden">
        <!-- Decorative Glows -->
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-yellow-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="text-center">
            <h2 class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-orange-400 to-amber-300 bg-clip-text text-transparent">
                Coach Portal
            </h2>
            <p class="mt-2 text-sm text-slate-400">
                Log in to manage athlete performance and attendance
            </p>
        </div>

        @if ($errors->any())
            <div class="p-4 rounded-lg bg-red-950/40 border border-red-500/20 text-red-400 text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Email Address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="w-full px-4 py-3 rounded-xl bg-slate-900/60 border border-white/10 focus:border-orange-500/50 focus:ring-1 focus:ring-orange-500/30 text-slate-100 placeholder-slate-500 transition-all text-sm outline-none" 
                           placeholder="coach@widyactive.com" value="{{ old('email') }}">
                </div>
                
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                           class="w-full px-4 py-3 rounded-xl bg-slate-900/60 border border-white/10 focus:border-orange-500/50 focus:ring-1 focus:ring-orange-500/30 text-slate-100 placeholder-slate-500 transition-all text-sm outline-none" 
                           placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between text-xs">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" 
                           class="h-4 w-4 rounded border-white/10 bg-slate-900 text-orange-500 focus:ring-orange-500/30">
                    <label for="remember" class="ml-2 text-slate-400 select-none">Remember me</label>
                </div>
                
                <a href="#" class="text-orange-400 hover:text-orange-300 font-medium transition-colors">Forgot password?</a>
            </div>

            <div>
                <button type="submit" 
                        class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-orange-500 via-amber-500 to-yellow-500 hover:opacity-95 text-slate-950 font-bold text-sm tracking-wider uppercase shadow-lg shadow-orange-500/10 hover:shadow-orange-500/20 hover:scale-[1.01] transition-all cursor-pointer">
                    Sign In
                </button>
            </div>
        </form>

        <div class="mt-6 text-center text-xs">
            <span class="text-slate-400">New coach?</span>
            <a href="{{ route('register') }}" class="ml-1 text-orange-400 hover:text-orange-300 font-bold transition-colors">Create an account</a>
        </div>
    </div>
</div>
@endsection
