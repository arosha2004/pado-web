@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">User administration</h2>
        <a href="{{ route('users.create') }}" class="bg-slate-900 text-white px-4 py-2 rounded">Create User</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-left">
            <thead>
                <tr class="border-b text-sm text-slate-500">
                    <th class="py-3 pr-4">Name</th>
                    <th class="py-3 pr-4">Email</th>
                    <th class="py-3 pr-4">Role</th>
                    <th class="py-3 pr-4">Status</th>
                    <th class="py-3 pr-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="border-b">
                        <td class="py-3 pr-4">{{ $user->name }}</td>
                        <td class="py-3 pr-4">{{ $user->email }}</td>
                        <td class="py-3 pr-4">{{ $user->role }}</td>
                        <td class="py-3 pr-4">{{ $user->status }}</td>
                        <td class="py-3 pr-4 flex items-center space-x-2">
                            <a href="{{ route('users.edit', $user) }}" class="text-sky-600 hover:underline">Edit</a>
                            @if($user->id !== auth()->id())
                                @if($user->status === 'active')
                                    <form method="POST" action="{{ route('users.deactivate', $user) }}" onsubmit="return confirmDeactivate(this);">
                                        @csrf
                                        <input type="hidden" name="reason" class="deactivation-reason">
                                        <button type="submit" class="text-red-600 hover:underline text-sm">Deactivate</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('users.reactivate', $user) }}">
                                        @csrf
                                        <button type="submit" class="text-emerald-600 hover:underline text-sm">Reactivate</button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    function confirmDeactivate(form) {
        const reason = prompt('Please enter a reason for deactivation:');
        if (reason) {
            form.querySelector('.deactivation-reason').value = reason;
            return true;
        }
        return false;
    }
</script>
@endsection
