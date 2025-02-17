<?php

namespace MindEdge\LaravelTenant;

use Illuminate\Support\ServiceProvider;

class LaravelTenantServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/tenant.php' => config_path('tenant.php'),
        ]);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/tenant.php',
            'tenant'
        );

        $this->app->singleton(TenantMap::class, function ($app) {
            $tenant = new TenantMap();

            return $tenant;
        });
    }
}
