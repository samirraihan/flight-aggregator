<?php

namespace App\Providers;

use App\Services\Providers\ProviderAService;
use App\Services\Providers\ProviderBService;
use App\Services\Providers\ProviderCService;
use App\Services\Providers\ProviderManager;
use Illuminate\Support\ServiceProvider;

class FlightProviderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag([
            ProviderAService::class,
            ProviderBService::class,
            ProviderCService::class,
        ], 'flight.providers');

        $this->app->singleton(
            ProviderManager::class,
            fn () => new ProviderManager(
                $this->app->tagged('flight.providers')
            )
        );
    }
}