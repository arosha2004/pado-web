@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-100">
    <div class="w-full max-w-md rounded-xl bg-white p-8 shadow-sm border border-slate-200">
        <h1 class="text-2xl font-bold text-slate-900 mb-2">JSB SecureHub</h1>
        <p class="text-sm text-slate-600 mb-6">Secure access for staff awareness and compliance.</p>

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500" required>
            </div>
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-sm font-medium text-slate-700">Password</label>
                    <a href="{{ route('password.request') }}" class="text-sm text-sky-600 hover:underline">Forgot password?</a>
                </div>
                <input type="password" name="password" class="w-full rounded border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500" required>
            </div>
            <button type="submit" class="w-full rounded bg-slate-900 px-4 py-2 text-white hover:bg-slate-800">Login</button>
        </form>
    </div>
</div>
@endsection
