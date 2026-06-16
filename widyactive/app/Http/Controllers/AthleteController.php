<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\CoachEvaluation;
use App\Models\PerformanceMetric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AthleteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sport = $request->input('sport');

        $query = Athlete::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        if ($sport) {
            $query->where('sport', $sport);
        }

        $athletes = $query->with('performanceMetrics')->paginate(10)->withQueryString();
        
        // Get unique sports list for filter dropdown
        $sportsList = Athlete::whereNotNull('sport')->distinct()->pluck('sport');

        return view('athletes.index', compact('athletes', 'sportsList', 'search', 'sport'));
    }

    public function create()
    {
        return view('athletes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:athletes,email',
            'date_of_birth' => 'required|date',
            'sport' => 'required|string|max:100',
        ]);

        Athlete::create($request->all());

        return redirect()->route('athletes.index')->with('success', 'Athlete registered successfully!');
    }

    public function show(Athlete $athlete)
    {
        // Get performance history
        $metrics = $athlete->performanceMetrics()->take(15)->get()->reverse();
        
        // Prepare data for SVG chart
        $chartData = $metrics->map(function ($m) {
            return [
                'date' => $m->recorded_at->format('d M'),
                'performance' => $m->performance_score,
                'readiness' => $m->readiness_score,
                'speed' => $m->speed,
                'strength' => $m->strength,
                'endurance' => $m->endurance,
                'mental' => $m->mental_score,
            ];
        });

        // Get attendance records
        $attendances = $athlete->attendances()->take(20)->get();

        // Get evaluations
        $evaluations = $athlete->coachEvaluations;

        return view('athletes.show', compact('athlete', 'chartData', 'attendances', 'evaluations'));
    }

    public function edit(Athlete $athlete)
    {
        return view('athletes.edit', compact('athlete'));
    }

    public function update(Request $request, Athlete $athlete)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:athletes,email,' . $athlete->id,
            'date_of_birth' => 'required|date',
            'sport' => 'required|string|max:100',
        ]);

        $athlete->update($request->all());

        return redirect()->route('athletes.show', $athlete)->with('success', 'Athlete details updated successfully!');
    }

    public function destroy(Athlete $athlete)
    {
        $athlete->delete();
        return redirect()->route('athletes.index')->with('success', 'Athlete deleted successfully.');
    }

    public function storeMetrics(Request $request, Athlete $athlete)
    {
        $request->validate([
            'readiness_score' => 'required|integer|between:0,100',
            'performance_score' => 'required|integer|between:0,100',
            'speed' => 'required|numeric|between:0,10',
            'strength' => 'required|numeric|between:0,10',
            'endurance' => 'required|numeric|between:0,10',
            'mental_score' => 'required|integer|between:0,100',
            'recorded_at' => 'required|date',
        ]);

        $athlete->performanceMetrics()->create($request->all());

        return back()->with('success', 'Performance metrics logged successfully!');
    }

    public function storeEvaluation(Request $request, Athlete $athlete)
    {
        $request->validate([
            'strengths' => 'required|string',
            'weaknesses' => 'required|string',
            'recommendations' => 'required|string',
            'mental_notes' => 'nullable|string',
        ]);

        $athlete->coachEvaluations()->create([
            'coach_name' => Auth::user()->name ?? 'Coach',
            'strengths' => $request->strengths,
            'weaknesses' => $request->weaknesses,
            'recommendations' => $request->recommendations,
            'mental_notes' => $request->mental_notes,
        ]);

        return back()->with('success', 'Coach evaluation logged successfully!');
    }
}
