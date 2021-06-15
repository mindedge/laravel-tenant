<?php
namespace Windward\EloquentTenant\Traits;

use Illuminate\Support\Str;
use Windward\EloquentTenant\Tenant as EloquentTenantFacade;

trait Tenant
{
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->connection = EloquentTenantFacade::getCurrent();
    }
}