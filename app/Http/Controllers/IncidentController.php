<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $incidents = Incident::query()->when($user->role === 'employee', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->latest()->get();

        return view('incidents.index', compact('incidents'));
    }

    public function resolve(Incident $incident)
    {
        $user = auth()->user();
        if ($user->role === 'employee') {
            abort(403);
        }

        $incident->update(['status' => 'resolved']);
        return back()->with('success', 'Incident resolved.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'severity' => 'required|string',
        ]);

        Incident::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'severity' => $request->severity,
            'status' => 'open',
        ]);

        return redirect()->route('incidents.index')->with('success', 'Incident submitted.');
    }
}
