<?php

namespace Windward\LaravelTenant\Traits;

use Windward\LaravelTenant\LaravelTenantFacade;

trait EloquentTenant
{
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->connection = LaravelTenantFacade::currentDb();
    }
}
