<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        if($this->app->runningInConsole()) return;

        $permissions = Permission::all();

        foreach ($permissions as $permission) {
            Gate::define($permission->name, function (User $user) use ($permission) {
                return $user->hasPermissions($permission->name);
            });
        }

        Gate::before(function (User $user) {
            if ($user->isAdmin()) {
                return true;
            }
        });
    }
}
