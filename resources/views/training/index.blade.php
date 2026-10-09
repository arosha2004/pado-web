@extends('layouts.app')

@section('title', 'My Training')

@section('content')
<div class="grid gap-4">
    @forelse($assignments as $assignment)
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-semibold">Training #{{ $assignment->training_version_id }}</div>
                    <div class="text-sm text-slate-500">Status: {{ $assignment->status }}</div>
                </div>
                <a href="{{ route('training.show', $assignment->training_version_id) }}" class="bg-sky-600 text-white px-4 py-2 rounded">Open</a>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm text-slate-500">No training assigned.</div>
    @endforelse
</div>
@endsection
