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
        $user = auth()->user();
        if ($user->role === 'employee') {
            $assignments = TrainingAssignment::where('user_id', $user->id)->with('user')->latest()->get();
        } else {
            $assignments = TrainingAssignment::with('user')->latest()->get();
        }

        return view('training.index', compact('assignments'));
    }

    public function show(TrainingVersion $trainingVersion)
    {
        $sections = $trainingVersion->sections()->orderBy('order')->get();
        $assignment = TrainingAssignment::where('user_id', auth()->id())->where('training_version_id', $trainingVersion->id)->firstOrFail();

        return view('training.show', compact('trainingVersion', 'sections', 'assignment'));
    }

    public function markSectionComplete(TrainingService $service, TrainingAssignment $assignment, TrainingSection $section)
    {
        $service->markSectionComplete($assignment->id, $section->id);

        return redirect()->back()->with('success', 'Section marked complete.');
    }
}
