<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JSB SecureHub')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800">
    @auth
    <div class="min-h-screen flex">
        <aside class="w-72 bg-slate-900 text-white p-6 hidden lg:block">
            <div class="mb-8">
                <div class="text-2xl font-bold">JSB SecureHub</div>
                <div class="text-xs uppercase tracking-[0.2em] text-slate-400 mt-2">Group 41</div>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="block rounded px-3 py-2 hover:bg-slate-800">Dashboard</a>
                <a href="{{ route('policies.index') }}" class="block rounded px-3 py-2 hover:bg-slate-800">Policies</a>
                <a href="{{ route('training.index') }}" class="block rounded px-3 py-2 hover:bg-slate-800">My Training</a>
                <a href="{{ route('incidents.index') }}" class="block rounded px-3 py-2 hover:bg-slate-800">Incidents</a>
                <a href="{{ route('notifications.index') }}" class="block rounded px-3 py-2 hover:bg-slate-800">Notifications</a>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('users.index') }}" class="block rounded px-3 py-2 hover:bg-slate-800">Users</a>
                    <a href="{{ route('audit.index') }}" class="block rounded px-3 py-2 hover:bg-slate-800">Audit Logs</a>
                @endif
            </nav>
        </aside>

        <main class="flex-1">
            <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold">@yield('title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('notifications.index') }}" class="relative inline-flex items-center text-slate-700">
                        <span class="text-lg">🔔</span>
                        @php $unreadCount = auth()->user()->notifications()->whereNull('read_at')->count(); @endphp
                        @if($unreadCount)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full px-1.5 text-xs">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    <div class="text-right">
                        <div class="font-medium">{{ auth()->user()->name }}</div>
                        <div class="text-xs uppercase text-slate-500">{{ auth()->user()->role }}</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded">Logout</button>
                    </form>
                </div>
            </header>

            <div class="p-6">
                @if(session('success'))
                    <div class="mb-4 rounded border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
    @else
        @yield('content')
    @endauth
</body>
</html>
