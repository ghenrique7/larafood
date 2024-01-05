<?php

namespace App\Models;

use App\Models\Traits\UserACLTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use UserACLTrait;
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'tenant_id'];

    public function scopeTenantUser(Builder $query)
    {
        return $query->where('tenant_id', auth()->user()->tenant_id);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function rolesAvailable($filter = null)
    {
        $roles = Role::whereNotIn('roles.id', function ($query) {
            $query->select('role_id');
            $query->from('role_user');
            $query->whereRaw("role_user.user_id={$this->id}");
        })
            ->where(function ($queryFilter) use ($filter) {
                if ($filter) {
                    $converted = strtolower($filter['filter']);
                    $queryFilter->where('roles.name', 'LIKE', "%{$converted}%");
                }
            })
            ->paginate();

        return $roles;
    }
}
