@extends('layouts.app')

@section('title', 'Incidents')

@section('content')
<div class="grid lg:grid-cols-[1.2fr_0.8fr] gap-6">
    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <h2 class="text-xl font-semibold mb-4">Incident log</h2>
        @forelse($incidents as $incident)
            <div class="border rounded-lg p-4 mb-3">
                <div class="flex justify-between">
                    <div class="font-semibold">{{ $incident->title }}</div>
                    <span class="text-xs uppercase px-2 py-1 rounded bg-amber-100 text-amber-700">{{ $incident->status }}</span>
                </div>
                <p class="mt-2 text-slate-600">{{ $incident->description }}</p>
            </div>
        @empty
            <div class="text-slate-500">No incidents reported yet.</div>
        @endforelse
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
        <h2 class="text-xl font-semibold mb-4">Report incident</h2>
        <form method="POST" action="{{ route('incidents.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Title</label>
                <input type="text" name="title" class="w-full rounded border border-slate-300 px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Severity</label>
                <select name="severity" class="w-full rounded border border-slate-300 px-3 py-2">
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full rounded border border-slate-300 px-3 py-2" required></textarea>
            </div>
            <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded">Submit</button>
        </form>
    </div>
</div>
@endsection
