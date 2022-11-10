<?php

/**
 * Tenancy on eloquent
 *
 */

namespace MindEdge\LaravelTenant;

use Exception;
use Illuminate\Support\Facades\Config;

class TenantMap
{
    private $TENANTS = [];

    private $CURRENT = 0;
    private $CONFIG_PREFIX = "tenant.";

    public function __construct()
    {
        $this->TENANTS = Config::get('tenant') ?? [];

        foreach ($this->TENANTS as $key => $tenant) {
            if (!empty($tenant['db'])) {
                Config::set("database.connections.{$key}", $tenant['db']);
            }

            if (!empty($tenant['filesystem'])) {
                Config::set("filesystems.disks.{$key}", $tenant['filesystem']);
            }
        }
    }

    /**
     * Gets the current tenant index
     *
     * @return int
     */
    public function getCurrent(): int|null
    {
        return $this->CURRENT;
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

    /**
     * Get the current filesystem disk
     *
     * @return string The filesystem disk to use with Storage::disk()
     */
    public function currentFilesystem(): string
    {
        if (!empty($this->TENANTS[$this->CONFIG_PREFIX . $this->CURRENT]['filesystem'])) {
            return $this->CONFIG_PREFIX . $this->CURRENT;
        } else {
            throw new Exception("No filesystem exists for tenant index {$this->CURRENT}");
        }
    }

    /**
     * Get the current database
     *
     * @return string The filesystem disk to use with Storage::disk()
     */
    public function currentDb(): string
    {
        if (!empty($this->TENANTS[$this->CONFIG_PREFIX . $this->CURRENT]['db'])) {
            return $this->CONFIG_PREFIX . $this->CURRENT;
        } else {
            throw new Exception("No database exists for tenant index {$this->CURRENT}");
        }
    }

    /**
     * Get the raw tenants array
     *
     * @return Array list of connections
     */
    public function getTenants()
    {
        return $this->TENANTS;
    }

    /**
     * Get a list of all user database connection keys for eloquent on() statements
     *
     * @return Array list of connections
     */
    public function getDbs()
    {
        $dbs = [];
        foreach ($this->TENANTS as $index => $tenant) {
            if (!empty($tenant['db'])) {
                $dbs[] = $index;
            }
        }

        return $dbs;
    }

    /**
     * Get a list of all filesystem keys for Storage disk() statements
     *
     * @return Array list of filesystems
     */
    public function getFilesystems()
    {
        $dbs = [];
        foreach ($this->TENANTS as $index => $tenant) {
            if (!empty($tenant['filesystem'])) {
                $dbs[] = $index;
            }
        }

        return $dbs;
    }
}
