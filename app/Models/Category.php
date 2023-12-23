<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Tenant\Observers\TenantObserver;

class Category extends Model
{
    protected $fillable = ['name', 'url', 'description'];

    protected static function booted(): void
    {
        parent::boot();

        static::observe(TenantObserver::class);
    }
}
