<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'price', 'description'];

    public function details() {
        return $this->hasMany(DetailPlan::class);
    }

    public function profiles() {
        return $this->belongsToMany(Profile::class);
    }

    public function tenants() {
        return $this->hasMany(Tenant::class);
    }

    public function profilesAvailable($filter = null) {
        $profiles = Profile::whereNotIn('profiles.id', function ($query) {
            $query->select('plan_profile.profile_id');
            $query->from('plan_profile');
            $query->whereRaw("plan_profile.plan_id={$this->id}");
        })
        ->where(function($queryFilter) use($filter) {
            if($filter) {
                $converted = strtolower($filter['filter']);
                $queryFilter->where('name', 'LIKE', "%{$converted}%");
            }
        })
        ->paginate();

        return $profiles;
    }

    public function search($filter = null)
    {
        $results = $this->where('name', 'ILIKE', "%{$filter}%")
            ->orWhere('description', 'ILIKE', "%{$filter}%")
            ->paginate();

        return $results;
    }
}
