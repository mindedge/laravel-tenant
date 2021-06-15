<?php

namespace Windward\EloquentTenant;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MindEdge\EloquentTenant\Skeleton\SkeletonClass
 */
class EloquentTenantFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Tenant::class;
    }
}
