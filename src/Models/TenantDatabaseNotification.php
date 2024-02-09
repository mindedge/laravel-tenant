<?php

namespace MindEdge\LaravelTenant\Models;

use Illuminate\Notifications\DatabaseNotification;
use MindEdge\LaravelTenant\Traits\EloquentTenant;

class TenantDatabaseNotification extends DatabaseNotification
{
    use EloquentTenant;
}
