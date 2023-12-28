<?php

namespace App\Models\Traits;

use App\Models\Tenant;

trait UserACLTrait
{
    public function permissions() {
        $permissionsPlan = $this->permissionsPlan();
        $permissionsRole = $this->permissionsRole();

        $permissions = [];
        foreach($permissionsRole as $permissionRole) {
            if(in_array($permissionRole, $permissionsPlan)) {
                array_push($permissions, $permissionsPlan);
            }
        }

        return $permissions;
    }

    public function permissionsPlan()
    {
        // $tenant = $this->tenant;
        // $plan = $tenant->plan;

        $tenant = Tenant::with('plan.profiles.permissions')->where('id', $this->tenant_id)->first();
        $plan = $tenant->plan;

        $permissions = [];
        foreach ($plan->profiles as $profile) {
            foreach ($profile->permissions as $permission) {
                array_push($permissions, $permission->name);
            }
        }

        return $permissions;
    }

    public function permissionsRole()
    {
        $roles = $this->roles()->with('permissions')->get();
        $permissions = [];
        foreach ($roles->permissions as $permissionRole) {
            array_push($permissions, $permissionRole);
        }

        return $permissions;
    }

    public function hasPermissions(string $permissionName): bool
    {
        return in_array($permissionName, $this->permissions());
    }

    public function isAdmin(): bool
    {
        return in_array($this->email, config('acl.admins'));
    }

    public function isNotAdmin(): bool
    {
        return !in_array($this->email, config('acl.admins'));
    }
}
