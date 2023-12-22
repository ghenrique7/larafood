<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $fillable = ['name', 'email', 'password', 'tenant_id'];

    public function scopeTenantUser(Builder $query)
    {
        return $query->where('tenant_id', auth()->user()->tenant_id);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

}
