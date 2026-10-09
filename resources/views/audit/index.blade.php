@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
    <h2 class="text-xl font-semibold mb-4">Audit event log</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm">
            <thead>
                <tr class="border-b text-slate-500">
                    <th class="py-3 pr-4">Time</th>
                    <th class="py-3 pr-4">Action</th>
                    <th class="py-3 pr-4">Outcome</th>
                    <th class="py-3 pr-4">Actor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                    <tr class="border-b">
                        <td class="py-3 pr-4">{{ $event->created_at?->format('d M Y H:i') }}</td>
                        <td class="py-3 pr-4">{{ $event->action }}</td>
                        <td class="py-3 pr-4">{{ $event->outcome }}</td>
                        <td class="py-3 pr-4">{{ $event->actor_user_id }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
