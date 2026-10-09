@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-100">
    <div class="w-full max-w-md rounded-xl bg-white p-8 shadow-sm border border-slate-200">
        <h1 class="text-2xl font-bold text-slate-900 mb-2">Forgot Password</h1>
        <p class="text-sm text-slate-600 mb-6">Enter your email address and we will send you a password reset link.</p>

        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-sky-500" required>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full rounded bg-slate-900 px-4 py-2 text-white hover:bg-slate-800">Email Password Reset Link</button>
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-sm text-sky-600 hover:underline">Back to Login</a>
            </div>
        </form>
    </div>
</div>
@endsection
