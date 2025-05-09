<?php
namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('viewFilament', function ($user) {
            return $user->role === 'admin';
        });

        Filament::serving(function () {
                                         // Pastikan untuk menggunakan guard 'filament' saat autentikasi admin
            Auth::shouldUse('filament'); // Tentukan guard yang akan digunakan
        });
    }
}