<?php

/**
 * Tenancy on eloquent
 *
 */

namespace MindEdge\LaravelTenant;

class Config
{
    public static function load()
    {

        $config = [];

        $config = array_merge_recursive($config, self::loadDb(), self::loadFilesystem());

        return $config;
    }

    private static function loadFilesystem()
    {
        $index = 0;
        $config = [];

        // Load in the database tenant config
        while (!empty(env("TENANT_{$index}_FILESYSTEM_DRIVER"))) {
            if (trim(env("TENANT_{$index}_FILESYSTEM_DRIVER")) === 's3') {
                $config["tenant.{$index}"] = [
                    "filesystem" => self::loadFilesystemS3($index)
                ];
            } else if (trim(env("TENANT_{$index}_FILESYSTEM_DRIVER")) === 'local') {
                $config["tenant.{$index}"] = [
                    "filesystem" => self::loadFilesystemLocal($index)
                ];
            }

            $index++;
        }

        return $config;
    }

    private static function loadFilesystemS3($index)
    {
        return [
            'driver' => 's3',
            'key' => env("TENANT_{$index}_AWS_ACCESS_KEY_ID", ''),
            'secret' => env("TENANT_{$index}_AWS_SECRET_ACCESS_KEY", ''),
            'token' => env("TENANT_{$index}_AWS_SESSION_TOKEN"),
            'region' => env("TENANT_{$index}_AWS_DEFAULT_REGION"),
            'bucket' => env("TENANT_{$index}_AWS_BUCKET"),
            'url' => env("TENANT_{$index}_CDN_URL"),
            'endpoint' => env("TENANT_{$index}_AWS_ENDPOINT"),
        ];
    }

    private static function loadFilesystemLocal($index)
    {
        return [
            'driver' => 'local',
            'root' => env("TENANT_{$index}_FILESYSTEM_ROOT", storage_path('app/public')),
            'url' => env("TENANT_{$index}_FILESYSTEM_URL", env('APP_URL') . '/storage'),
            'visibility' => env("TENANT_{$index}_FILESYSTEM_VISIBILITY", 'public'),
            'throw' => env("TENANT_{$index}_FILESYSTEM_THROW", false),
        ];
    }

    private static function loadDb()
    {
        $index = 0;
        $config = [];

        // Load in the database tenant config
        while (!empty(env("TENANT_{$index}_DB_HOST"))) {
            $config["tenant.{$index}"] = [
                "db" => [
                    'driver' => env("TENANT_{$index}_DB_DRIVER", "pgsql"),
                    'url' => env("TENANT_{$index}_DATABASE_URL"),
                    'host' => env("TENANT_{$index}_DB_HOST", '127.0.0.1'),
                    'port' => env("TENANT_{$index}_DB_PORT", '5432'),
                    'database' => env("TENANT_{$index}_DB_DATABASE", 'tenantdb'),
                    'username' => env("TENANT_{$index}_DB_USERNAME", 'tenantuser'),
                    'password' => env("TENANT_{$index}_DB_PASSWORD", ''),
                    'charset' => env("TENANT_{$index}_DB_CHARSET", 'utf8'),
                    'prefix' => env("TENANT_{$index}_DB_PREFIX", ''),
                    'prefix_indexes' => env("TENANT_{$index}_DB_PREFIX_INDEXES", true),
                    'schema' => env("TENANT_{$index}_DB_SCHEMA", 'public'),
                    'sslmode' => env("TENANT_{$index}_DB_SSLMODE", 'prefer'),
                ]
            ];

            $index++;
        }

        return $config;
    }
}
