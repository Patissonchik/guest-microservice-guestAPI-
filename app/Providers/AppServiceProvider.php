<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\GuestRepositoryInterface;
use App\Repositories\GuestRepository;
use App\Services\PhoneNumberService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(GuestRepositoryInterface::class, GuestRepository::class);
        $this->app->singleton(PhoneNumberService::class, function ($app) {
            return new PhoneNumberService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
