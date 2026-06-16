<?php

use App\Http\Controllers\AthleteController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Models\Athlete;
use App\Models\PerformanceMetric;

// Public Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Guarded Coach Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Athlete CRUD and Profiles
    Route::resource('athletes', AthleteController::class);
    Route::post('/athletes/{athlete}/metrics', [AthleteController::class, 'storeMetrics'])->name('athletes.metrics.store');
    Route::post('/athletes/{athlete}/evaluations', [AthleteController::class, 'storeEvaluation'])->name('athletes.evaluations.store');
    
    // Attendance Tracking & QR Simulator
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    
    // Analytics & Reports
    Route::get('/reports', function () {
        $athletes = Athlete::with('performanceMetrics', 'attendances')->get();
        
        $totalAthletes = $athletes->count();
        $avgPerformance = round(PerformanceMetric::avg('performance_score') ?? 0, 1);
        $avgReadiness = round(PerformanceMetric::avg('readiness_score') ?? 0, 1);
        
        return view('reports.index', compact('athletes', 'totalAthletes', 'avgPerformance', 'avgReadiness'));
    })->name('reports.index');
    
    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
