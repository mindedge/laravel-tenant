<?php
/**
 * Tenancy on eloquent
 *
 */
namespace Windward\EloquentTenant;

use Illuminate\Support\Facades\Config;

Class TenantMap {
    private $DRIVER = 'pgsql';

    //Resolve .env strings into arrays
    private $USER_HOSTS = [];
    private $USER_PORTS = [];
    private $USER_DATABASES = [];
    private $USER_USERNAMES = [];
    private $USER_PASSWORDS = [];

    private $CURRENT = null;
    private $CONNECTION_PREFIX = "users.";

    public function __construct( )
    {
        $this->DRIVER = \Config::get('database.default');

        // Resolve .env strings into arrays
        $this->USER_HOSTS = array_map('trim', explode(',', \Config::get('app.userdb.host')));
        $this->USER_PORTS = array_map('trim', explode(',', \Config::get('app.userdb.port')));
        $this->USER_DATABASES = array_map('trim', explode(',',\Config::get('app.userdb.database')));
        $this->USER_USERNAMES = array_map('trim', explode(',', \Config::get('app.userdb.username')));
        $this->USER_PASSWORDS = array_map('trim', explode(',', \Config::get('app.userdb.password')));

        $connections = $this->configDatabase();

        // Add new user database connections at runtime
        foreach($connections as $key => $connection) {

            Config::set("database.connections.{$key}", $connection);
            //DB::purge($key);
        }
    }

    public function setCurrent($key) {
        $this->CURRENT = $key;
    }

    public function getCurrent() {
        return $this->CURRENT;
    }

    /**
     * Get a list of all user database connection keys for eloquent on() statements
     *
     * @return Array list of connections
     */
    public function getConnections() {
        $connections = array_map(function($host) {
            return "{$this->CONNECTION_PREFIX}" . sha1($host);
        }, $this->USER_HOSTS);

        return $connections;
    }

    /**
     * Configure a list of all user database connection arrays for database config file
     *
     * @return Array list of connections
     */
    public function configDatabase() {

        $USER_CONNECTIONS = [];

        foreach($this->USER_HOSTS as $key => $HOST) {
            $USER_CONNECTIONS[$this->CONNECTION_PREFIX . sha1($HOST)] = [
                'driver' => $this->DRIVER,
                'host' => $HOST,
                'port' => $this->USER_PORTS[$key],
                'database' => $this->USER_DATABASES[$key],
                'username' => $this->USER_USERNAMES[$key],
                'password' => $this->USER_PASSWORDS[$key],
                'charset' => 'utf8',
                'prefix' => '',
                'prefix_indexes' => true,
                'schema' => 'public',
                'sslmode' => 'prefer',
            ];
        }

        return $USER_CONNECTIONS;
    }
}