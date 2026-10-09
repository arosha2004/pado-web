@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Notifications</h2>
        <form method="POST" action="{{ route('notifications.mark-all-read') }}">
            @csrf
            <button type="submit" class="text-sm text-sky-600">Mark all read</button>
        </form>
    </div>

    @forelse($notifications as $notification)
        <div class="border-b py-3 flex items-center justify-between">
            <div>
                <div class="font-medium">{{ $notification->title }}</div>
                <div class="text-sm text-slate-500">{{ $notification->message }}</div>
            </div>
            @if(is_null($notification->read_at))
                <form method="POST" action="{{ route('notifications.read', $notification) }}">
                    @csrf
                    <button type="submit" class="text-xs text-sky-600">Mark read</button>
                </form>
            @endif
        </div>
    @empty
        <div class="text-slate-500">No notifications.</div>
    @endforelse
</div>
@endsection
