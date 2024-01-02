<?php

namespace App\Listeners;

use App\Models\Role;
use App\Tenant\Events\TenantCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddRoleTenant
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TenantCreated $event): void
    {
        $user = $event->user();

        if(!$role = Role::first()) {
            return;
        }

        $user->roles()->attach($role);
    }
}
