<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $athletes = Athlete::orderBy('name')->get();
        
        // Get today's attendance logs
        $today = now()->format('Y-m-d');
        $todayAttendances = Attendance::with('athlete')
            ->where('recorded_date', $today)
            ->get()
            ->keyBy('athlete_id');

        return view('attendance.index', compact('athletes', 'today', 'todayAttendances'));
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'athlete_id' => 'required|exists:athletes,id',
            'status' => 'required|in:present,absent,late',
            'recorded_date' => 'required|date',
            'notes' => 'nullable|string|max:255',
        ]);

        // Find or create attendance record for this athlete on this date
        $attendance = Attendance::updateOrCreate(
            [
                'athlete_id' => $request->athlete_id,
                'recorded_date' => $request->recorded_date,
            ],
            [
                'status' => $request->status,
                'notes' => $request->notes,
            ]
        );

        // Return JSON if ajax/fetch request, or redirect back
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Attendance recorded successfully!',
                'attendance' => $attendance->load('athlete'),
            ]);
        }

        return back()->with('success', 'Attendance recorded successfully!');
    }
}
