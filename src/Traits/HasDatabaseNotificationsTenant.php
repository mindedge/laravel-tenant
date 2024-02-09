<?php

namespace MindEdge\LaravelTenant\Traits;

use MindEdge\LaravelTenant\Models\TenantDatabaseNotification;

trait HasDatabaseNotificationsTenant
{
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
