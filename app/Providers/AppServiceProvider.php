<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Carbon::macro('toColombo', function () {
            return $this->copy()->setTimezone('Asia/Colombo')->format('d M Y, H:i') . ' (SL)';
        });

        Blade::if('role', function (...$roles) {
            return auth()->check() && in_array(auth()->user()->role, $roles, true);
        });
    }
}
