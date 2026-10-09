@extends('layouts.app')

@section('title', $policy->title)

@section('content')
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="text-2xl font-semibold">{{ $policy->title }}</h2>
            <p class="text-slate-500">{{ $policy->category }}</p>
        </div>
        @if($version)
            <form action="{{ route('policies.acknowledge', $version) }}" method="POST">
                @csrf
                <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded">Acknowledge</button>
            </form>
        @endif
    </div>

    <article class="prose max-w-none">
        {!! nl2br(e($version->content ?? 'No content available.')) !!}
    </article>
</div>
@endsection
