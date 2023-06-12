<?php

namespace App\Providers;

use App\Filament\Resources\Shield\RoleResource;
use App\Filament\Resources\UserResource;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\ServiceProvider;
use FilamentQuickCreate\Facades\QuickCreate;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            // Using Vite
            Filament::registerViteTheme('resources/css/filament.css');

            Filament::registerNavigationGroups([
                'Manage',
                'Settings',
                'Filament Shield'
            ]);

            QuickCreate::excludes([
                RoleResource::class,
                UserResource::class,
            ]);
        });
    }
}
