<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Profile extends Model
{
    protected $fillable = ['name', 'description'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class);
    }


    public function permissionsAvailable($filter = null)
    {
        $permissions = Permission::whereNotIn('permissions.id', function ($query) {
            $query->select('permission_id');
            $query->from('permission_profile');
            $query->whereRaw("permission_profile.profile_id={$this->id}");
        })
            ->where(function($queryfilter) use($filter) {
                if($filter) {
                    $converted = strtolower($filter['filter']);
                    $queryfilter->where('permissions.name', 'LIKE', "%{$converted}%");
                }
            })
            ->paginate();

        return $permissions;
    }
}
