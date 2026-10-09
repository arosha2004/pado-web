<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveUserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->status !== 'active') {
            auth()->logout();
            return redirect()->route('login')->withErrors(['account' => 'This account is inactive.']);
        }

        return $next($request);
    }
}
