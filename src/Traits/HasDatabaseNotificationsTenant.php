<?php

namespace MindEdge\LaravelTenant\Traits;

use Illuminate\Notifications\HasDatabaseNotifications;
use MindEdge\LaravelTenant\Models\TenantDatabaseNotification;

trait HasDatabaseNotificationsTenant
{
    use HasDatabaseNotifications;

    /**
     * Get the entity's notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(TenantDatabaseNotification::class, 'notifiable')->latest();
    }
}
