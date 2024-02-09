<?php

namespace MindEdge\LaravelTenant\Traits;

use MindEdge\LaravelTenant\LaravelTenantFacade;

trait EloquentTenant
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->connection = LaravelTenantFacade::currentDb();
    }

    protected function newRelatedInstance($class)
    {
        // Not a tenant instance, reset the connection to default
        if (!in_array('MindEdge\LaravelTenant\Traits\EloquentTenant', class_uses($class))) {
            return tap(new $class, function ($instance) {
                if (!$instance->getConnectionName() && !empty($this->connection)) {
                    $instance->setConnection(\Config::get('database.default'));
                }
            });
        } else {
            // Relations between two models on the same tenant
            return parent::newRelatedInstance($class);
        }
    }
}
