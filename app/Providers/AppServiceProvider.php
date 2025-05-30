<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\View\Composer\MitraComposer;
use App\Http\View\Composer\AdminComposer;
use App\Http\View\Composer\DosenComposer;
use App\Http\View\Composer\KordinatorComposer;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        View::composer('partials.mitra.navbar', MitraComposer::class);
        View::composer('partials.budede.navbar', AdminComposer::class);
        View::composer('partials.admin.navbar', KordinatorComposer::class);
        // View::composer('layouts.dosen', DosenComposer::class);
    }
}