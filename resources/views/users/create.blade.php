@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 p-6 max-w-2xl mx-auto">
    <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name" class="w-full rounded border border-slate-300 px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" class="w-full rounded border border-slate-300 px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" class="w-full rounded border border-slate-300 px-3 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Role</label>
            <select name="role" class="w-full rounded border border-slate-300 px-3 py-2">
                <option value="employee">Employee</option>
                <option value="manager">Manager</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded">Save</button>
    </form>
</div>
@endsection
