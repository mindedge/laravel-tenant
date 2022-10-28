<?php

/**
 * Tenancy on eloquent
 *
 */

namespace Windward\LaravelTenant;

use Exception;
use Illuminate\Support\Facades\Config;

class TenantMap
{
    private $TENANTS = [];

    private $CURRENT = null;
    private $CONFIG_PREFIX = "tenant.";

    public function __construct()
    {
        $this->TENANTS = Config::get('tenant') ?? [];

        foreach ($this->TENANTS as $index => $tenant) {
            $key = $this->CONFIG_PREFIX . $index;
            if (!empty($tenant['db'])) {
                Config::set("database.connections.{$key}", $tenant['db']);
            }

            if (!empty($tenant['filesystem'])) {
                Config::set("filesystems.disks.{$key}", $tenant['filesystem']);
            }
        }
    }

    /**
     * Sets the current tenant index
     *
     * @param int $index the current tenant index
     *
     * @return void
     */
    public function setCurrent(int $index): void
    {
        $this->CURRENT = $index;
    }

    protected function currentFilesystem()
    {
        if (!empty($this->TENANTS[$this->CONFIG_PREFIX . $this->CURRENT]['filesystem'])) {
            return $this->CONFIG_PREFIX . $this->CURRENT;
        } else {
            throw new Exception("No filesystem exists for tenant index {$this->CURRENT}");
        }
    }

    protected function currentDb()
    {
        if (!empty($this->TENANTS[$this->CONFIG_PREFIX . $this->CURRENT]['db'])) {
            return $this->CONFIG_PREFIX . $this->CURRENT;
        } else {
            throw new Exception("No filesystem exists for tenant index {$this->CURRENT}");
        }
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
