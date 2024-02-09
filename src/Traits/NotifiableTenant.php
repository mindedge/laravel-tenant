<?php

namespace MindEdge\LaravelTenant\Traits;

use Illuminate\Notifications\RoutesNotifications;

trait NotifiableTenant
{
    use HasDatabaseNotificationsTenant, RoutesNotifications;
}
