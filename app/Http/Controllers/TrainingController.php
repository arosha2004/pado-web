<?php

namespace App\Http\Controllers;

use App\Models\TrainingAssignment;
use App\Models\TrainingSection;
use App\Models\TrainingVersion;
use App\Services\TrainingService;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index()
    {
        $assignments = TrainingAssignment::with('user')->latest()->get();

        return view('training.index', compact('assignments'));
    }

    public function show(TrainingVersion $trainingVersion)
    {
        $sections = $trainingVersion->sections()->orderBy('order')->get();

        return view('training.show', compact('trainingVersion', 'sections'));
    }

    public function markSectionComplete(TrainingService $service, TrainingAssignment $assignment, TrainingSection $section)
    {
        $service->markSectionComplete($assignment->id, $section->id);

        return redirect()->back()->with('success', 'Section marked complete.');
    }
}
