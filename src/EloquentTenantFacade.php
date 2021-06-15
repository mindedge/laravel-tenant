<?php

namespace Windward\EloquentTenant;

use Illuminate\Support\Facades\Facade;

class EloquentTenantFacade extends Facade
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
