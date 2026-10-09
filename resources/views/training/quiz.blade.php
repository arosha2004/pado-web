@extends('layouts.app')

@section('title', $quizVersion->title)

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl border border-slate-200 shadow-sm p-6">
    <h2 class="text-2xl font-semibold mb-2">{{ $quizVersion->title }}</h2>
    <p class="text-sm text-slate-500 mb-6">Pass threshold: {{ $quizVersion->pass_threshold }}% | Max attempts: {{ $quizVersion->max_attempts }}</p>

    @if($errors->any())
        <div class="mb-4 text-red-600 bg-red-50 p-3 rounded text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('quiz.submit', $quizVersion) }}" method="POST" class="space-y-6">
        @csrf
        @foreach($quizVersion->questions as $index => $question)
            <div class="mb-4">
                <p class="font-medium mb-2">{{ $index + 1 }}. {{ $question->question_text }}</p>
                <div class="space-y-2">
                    @foreach($question->options as $option)
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" class="text-sky-600" required>
                            <span>{{ $option->option_text }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded hover:bg-slate-800">Submit Quiz</button>
    </form>
</div>
@endsection
