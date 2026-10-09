@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    @if(auth()->user()->role === 'admin')
        <div class="grid md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                <div class="text-sm text-slate-500">Active users</div>
                <div class="mt-3 text-3xl font-bold">{{ $stats['active_users'] ?? 0 }}</div>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                <div class="text-sm text-slate-500">Policy acknowledgement rate</div>
                <div class="mt-3 text-3xl font-bold">{{ $stats['policy_rate'] ?? 0 }}%</div>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                <div class="text-sm text-slate-500">Training completions</div>
                <div class="mt-3 text-3xl font-bold">{{ $stats['training_completions'] ?? 0 }}</div>
            </div>
        </div>
    @else
        <div class="grid md:grid-cols-2 gap-4">
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                <div class="text-sm text-slate-500">My policy acknowledgement rate</div>
                <div class="mt-3 text-3xl font-bold">{{ $compliance['rate'] ?? 0 }}%</div>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                <div class="text-sm text-slate-500">Assigned policies</div>
                <div class="mt-3 text-3xl font-bold">{{ $compliance['assignments'] ?? 0 }}</div>
            </div>
        </div>
    @endif

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
            <h2 class="text-lg font-semibold mb-3">Recent policy assignments</h2>
            @forelse($policies ?? [] as $item)
                <div class="flex justify-between border-b py-2 last:border-0">
                    <div>
                        <div class="font-medium">{{ $item->policyVersion->policy->title ?? 'Policy' }}</div>
                        <div class="text-sm text-slate-500">{{ $item->status }}</div>
                    </div>
                    <div class="text-sm text-slate-500">{{ $item->policyVersion->version_label }}</div>
                </div>
            @empty
                <div class="text-slate-500">No policy assignments.</div>
            @endforelse
        </div>

        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
            <h2 class="text-lg font-semibold mb-3">Training activity</h2>
            @forelse($trainings ?? [] as $training)
                <div class="flex justify-between border-b py-2 last:border-0">
                    <div>
                        <div class="font-medium">{{ $training->training_version_id }}</div>
                        <div class="text-sm text-slate-500">{{ $training->status }}</div>
                    </div>
                    <div class="text-sm text-slate-500">{{ $training->deadline_at?->format('d M Y') }}</div>
                </div>
            @empty
                <div class="text-slate-500">No training activity.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
