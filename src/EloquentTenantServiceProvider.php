<?php

namespace Windward\EloquentTenant;

use Illuminate\Support\ServiceProvider;

class EloquentTenantServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton(Tenant::class,function($app){
            $tenant = new Tenant();
            $tenant->setCurrent($tenant->getConnections()[0]);
            return $tenant;
        });
    }
}
