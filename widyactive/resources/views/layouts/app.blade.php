<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Widyactive Athlete System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Outfit Font for premium headings and Inter for body -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #090d16;
            background-image: 
                radial-gradient(at 10% 20%, rgba(249, 115, 22, 0.04) 0px, transparent 50%),
                radial-gradient(at 90% 10%, rgba(251, 191, 36, 0.03) 0px, transparent 50%),
                radial-gradient(at 50% 80%, rgba(15, 23, 42, 0.95) 0px, transparent 50%);
            background-attachment: fixed;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="text-slate-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="glass fixed top-0 left-0 right-0 z-50 px-6 py-4 flex items-center justify-between border-b border-white/5 bg-slate-950/60 backdrop-blur-md">
        <div class="flex items-center space-x-3">
            <div class="h-10 w-10 rounded-xl bg-gradient-to-tr from-accent to-gold flex items-center justify-center font-bold text-slate-950 text-xl tracking-wider shadow-lg neon-glow-orange">
                W
            </div>
            <div>
                <span class="text-xl font-bold tracking-tight bg-gradient-to-r from-orange-400 via-amber-300 to-yellow-500 bg-clip-text text-transparent">WIDYACTIVE</span>
                <span class="text-xs block text-slate-400 tracking-widest uppercase font-semibold">Athlete System</span>
            </div>
        </div>

        @auth
        <nav class="hidden md:flex items-center space-x-8 text-sm font-medium">
            <a href="{{ route('dashboard') }}" class="transition-colors hover:text-accent-400 {{ request()->routeIs('dashboard') ? 'text-orange-400 font-semibold' : 'text-slate-300' }}">Dashboard</a>
            <a href="{{ route('athletes.index') }}" class="transition-colors hover:text-accent-400 {{ request()->routeIs('athletes.*') ? 'text-orange-400 font-semibold' : 'text-slate-300' }}">Athletes</a>
            <a href="{{ route('attendance.index') }}" class="transition-colors hover:text-accent-400 {{ request()->routeIs('attendance.*') ? 'text-orange-400 font-semibold' : 'text-slate-300' }}">QR Attendance</a>
            <a href="{{ route('reports.index') }}" class="transition-colors hover:text-accent-400 {{ request()->routeIs('reports.index') ? 'text-orange-400 font-semibold' : 'text-slate-300' }}">Reports</a>
        </nav>

        <div class="flex items-center space-x-4">
            <div class="flex flex-col text-right">
                <span class="text-sm font-semibold text-slate-200">{{ Auth::user()->name }}</span>
                <span class="text-xs text-slate-400">Coach</span>
            </div>
            <a href="{{ route('logout') }}" class="px-4 py-2 text-xs font-semibold tracking-wider text-slate-300 hover:text-white uppercase transition bg-white/5 border border-white/10 hover:bg-white/10 rounded-lg">
                Logout
            </a>
        </div>
        @else
        <div>
            <a href="{{ route('login') }}" class="text-sm text-slate-300 hover:text-white mr-4">Login</a>
            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold bg-gradient-to-r from-accent to-gold text-slate-950 rounded-lg shadow hover:opacity-90 transition">Register</a>
        </div>
        @endauth
    </header>

    <!-- Content Container -->
    <main class="flex-1 pt-24 pb-12 px-4 md:px-8 max-w-7xl mx-auto w-full">
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl border border-emerald-500/20 bg-emerald-950/40 text-emerald-400 flex items-center space-x-3 shadow-lg animate-fade-in">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-white/5 bg-slate-950/40 backdrop-blur-sm py-6 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} WIDYACTIVE. Crafted for Elite Sports Excellence.</p>
    </footer>

</body>
</html>
