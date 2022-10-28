<?php

namespace Windward\LaravelTenant;

use Illuminate\Support\Facades\Facade;

class LaravelTenantFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return TenantMap::class;
    }
}
