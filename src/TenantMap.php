<?php

/**
 * Tenancy on eloquent
 *
 */

namespace Windward\EloquentTenant;

use Illuminate\Support\Facades\Config;

class TenantMap
{
    private $CONNECTIONS = [];

    private $CURRENT = null;
    private $CONNECTION_PREFIX = "tenant.";

    public function __construct()
    {
        $tenants = Config::get('tenant') ?? [];

        foreach ($tenants as $index => $tenant) {
            if (!empty($tenant['db'])) {
                $key = $this->CONNECTION_PREFIX . $index;
                $this->CONNECTIONS[] = $key;

                Config::set("database.connections.{$key}", $tenant['db']);
            }
        }
    }

    public function setCurrent($key)
    {
        $this->CURRENT = $key;
    }

    public function getCurrent()
    {
        return $this->CURRENT;
    }

    /**
     * Get a list of all user database connection keys for eloquent on() statements
     *
     * @return Array list of connections
     */
    public function getConnections()
    {
        return $this->CONNECTIONS;
    }
}
