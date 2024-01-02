<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'tenant_id'];

     /**
     * Scope a query to only include tenant users.
     */
    public function scopeTenantUsers(Builder $query) {
        return $query->where('tenant_id', auth()->user()->tenant_id);
    }


    public function tenant() {
        return $this->belongsTo(Tenant::class);
    }

}
