@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 p-6 max-w-2xl mx-auto">
    <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="w-full rounded border border-slate-300 px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="w-full rounded border border-slate-300 px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Role</label>
            <select name="role" class="w-full rounded border border-slate-300 px-3 py-2">
                <option value="employee" @selected($user->role === 'employee')>Employee</option>
                <option value="manager" @selected($user->role === 'manager')>Manager</option>
                <option value="admin" @selected($user->role === 'admin')>Admin</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Status</label>
            <select name="status" class="w-full rounded border border-slate-300 px-3 py-2">
                <option value="active" @selected($user->status === 'active')>Active</option>
                <option value="inactive" @selected($user->status === 'inactive')>Inactive</option>
            </select>
        </div>
        <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
