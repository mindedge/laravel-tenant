# Laravel Tenant

A tenancy package for Laravel Eloquent and Filesystem.

## Installation

You can install the package via composer:

```bash
composer require mindedge/laravel-tenant
```

Your .env keys need to be prefixed with TENANT\_**X** where X is the tenant index.

Eg:

```bash
# Tenant Databases
TENANT_0_DB_DRIVER=pgsql
TENANT_0_DB_HOST=tenant-us.example.com
TENANT_0_DB_PORT=5432
TENANT_0_DB_DATABASE=tenantdb
TENANT_0_DB_USERNAME=user
TENANT_0_DB_PASSWORD=secret

TENANT_1_DB_DRIVER=pgsql
TENANT_1_DB_HOST=tenant-eu.example.com
TENANT_1_DB_PORT=5432
TENANT_1_DB_DATABASE=tenantdb
TENANT_1_DB_USERNAME=user
TENANT_1_DB_PASSWORD=secret

# Tenant S3 Filesystems
TENANT_0_FILESYSTEM_DRIVER=s3
TENANT_0_AWS_DEFAULT_REGION=us-east-1
TENANT_0_AWS_ACCESS_KEY_ID=
TENANT_0_AWS_SECRET_ACCESS_KEY=
TENANT_0_AWS_SESSION_TOKEN=
TENANT_0_AWS_BUCKET=
TENANT_0_AWS_URL=
TENANT_0_AWS_ENDPOINT=

# Tenant Local Filesystems
TENANT_1_FILESYSTEM_DRIVER=local
TENANT_1_FILESYSTEM_ROOT=# Default storage_path('app/public')
TENANT_1_FILESYSTEM_URL=# Default env('APP_URL') . '/storage')
TENANT_1_FILESYSTEM_VISIBILITY=# Default 'public'
TENANT_1_FILESYSTEM_THROW=# Default false

```

## Usage

Setting your tenant can be accomplished by using the `LaravelTenantFacade` and can be placed either in a
route middleware OR your `AppServiceProvider` boot() method.

Eg:

```php
use MindEdge\LaravelTenant\LaravelTenantFacade;

...

LaravelTenantFacade::setCurrent(0);
```

## Eloquent Usage

Laravel Tenant requires your Eloquent models to use UUIDs to prevent key conflicts when using relationships between tenant tables and non-tenanted tables.

Once your .env is configured you can use the `MindEdge\LaravelTenant\Traits\EloquentTenant` trait.

Eg:

```php
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use MindEdge\LaravelTenant\Traits\EloquentTenant as Tenant;

class UserGrade extends BaseModel
{
    use Uuid, Tenant;
}
```

## Filesystem Usage

You can set the `Storage` facade to the tenant filesystem by using the `LaravelTenantFacade`

Eg:

```php
use Illuminate\Support\Facades\Storage;
use MindEdge\LaravelTenant\LaravelTenantFacade;

...

Storage::disk(LaravelTenantFacade::currentFilesystem())->put('filename', $file_content);
```

### Security

If you discover any security related issues, please email jrogaishio@mindedge.com or by using the issue tracker.

## Credits

- [MindEdge](https://github.com/mindedge)
- [Jacob Rogaishio](https://github.com/jrogaishio)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
