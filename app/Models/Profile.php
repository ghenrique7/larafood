<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['name', 'description'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function plans() {
        return $this->belongsToMany(Plan::class);
    }


    /** Ver em video */
    public function permissionsAvailable($filter = null) {

    }
}
