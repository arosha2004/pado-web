@extends('layouts.app')

@section('title', 'Policies')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">Policy library</h2>
        @if(auth()->user()->role !== 'employee')
            <a href="{{ route('policies.create') }}" class="bg-slate-900 text-white px-4 py-2 rounded text-sm hover:bg-slate-800">Create Policy</a>
        @endif
    </div>

    <div class="space-y-4">
        @foreach($policies as $policy)
            <div class="border rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-lg font-semibold">{{ $policy->title }}</div>
                        <div class="text-sm text-slate-500">{{ $policy->category }}</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm">{{ $policy->status }}</span>
                        @if(auth()->user()->role !== 'employee' && $policy->status !== 'archived')
                            <form action="{{ route('policies.archive', $policy) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm bg-red-100 text-red-700 px-2 py-1 rounded hover:bg-red-200">Archive</button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="mt-3">
                    @foreach($policy->versions as $version)
                        <div class="flex items-center justify-between border-t py-3">
                            <div>
                                <div class="font-medium">Version {{ $version->version_label }}</div>
                                <div class="text-sm text-slate-500">Effective: {{ $version->effective_date?->format('d M Y') }}</div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('policies.show', $policy) }}" class="text-sky-600">View</a>
                                <form action="{{ route('policies.acknowledge', $version) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-emerald-600 text-white px-3 py-1.5 rounded">Acknowledge</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
