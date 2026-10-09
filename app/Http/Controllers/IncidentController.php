<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function index()
    {
        $incidents = Incident::query()->when(auth()->user()->role !== 'admin', function ($query) {
            $query->where('user_id', auth()->id());
        })->latest()->get();

        return view('incidents.index', compact('incidents'));
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
