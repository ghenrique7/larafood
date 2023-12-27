<?php

namespace App\Tenant\Scopes;

use App\Tenant\ManagerTenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{

    public function apply(Builder $builder, Model $model) {
        $managerTenant = app(ManagerTenant::class);

        $builder->where('tenant_id', $managerTenant->getTenantIdentify());
    }

}
