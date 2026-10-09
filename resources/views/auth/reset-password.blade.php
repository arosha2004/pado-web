@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-100">
    <div class="w-full max-w-md rounded-xl bg-white p-8 shadow-sm border border-slate-200">
        <h1 class="text-2xl font-bold text-slate-900 mb-2">Reset Password</h1>
        <p class="text-sm text-slate-600 mb-6">Enter your new password below.</p>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ request()->email }}" class="w-full rounded border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500" required readonly>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">New Password</label>
                <input type="password" name="password" class="w-full rounded border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500" required>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full rounded border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500" required>
            </div>
            <button type="submit" class="w-full rounded bg-slate-900 px-4 py-2 text-white hover:bg-slate-800">Reset Password</button>
        </form>
    </div>
</div>
@endsection
