@extends('layouts.app')

@section('title', 'Training Module')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 p-6">
    <h2 class="text-2xl font-semibold mb-2">{{ $trainingVersion->title }}</h2>
    <p class="text-slate-600 mb-4">{{ $trainingVersion->objective }}</p>

    <div class="space-y-3">
        @foreach($sections as $section)
            <div class="border rounded-lg p-4">
                <div class="font-semibold">{{ $section->title }}</div>
                <div class="text-sm text-slate-600 mt-2">{{ $section->content }}</div>
                <form method="POST" action="{{ route('training.complete', ['assignment' => $assignment->id, 'section' => $section->id]) }}" class="mt-3">
                    @csrf
                    <button type="submit" class="bg-emerald-600 text-white px-3 py-2 rounded text-sm hover:bg-emerald-500">Mark section complete</button>
                </form>
            </div>
        @endforeach
    </div>

    @if($trainingVersion->quiz)
        <div class="mt-6 border-t pt-4">
            <h3 class="text-lg font-semibold mb-2">Knowledge Assessment</h3>
            <p class="text-sm text-slate-600 mb-4">You must complete all sections before taking the quiz.</p>
            <a href="{{ route('quiz.show', $trainingVersion->quiz->id) }}" class="inline-block bg-slate-900 text-white px-4 py-2 rounded hover:bg-slate-800">Take Quiz</a>
        </div>
    @endif
</div>
@endsection
