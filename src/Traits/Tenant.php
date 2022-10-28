<?php

namespace Windward\LaravelTenant\Traits;

use Windward\EloquentTenant\EloquentTenantFacade;

trait Tenant
{
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->connection = LaravelTenantFacade::getCurrent();
    }
}
