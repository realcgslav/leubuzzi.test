<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\KzPerson;
use App\Observers\KzPersonObserver;

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
    public function boot(): void
    {
        KzPerson::observe(KzPersonObserver::class);
    }
}
