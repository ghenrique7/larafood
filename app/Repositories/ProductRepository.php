<?php

namespace App\Repositories;

use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
    protected $table;

    public function __construct()
    {
        $this->table = 'products';
    }

    public function getProductsByTenantId(string $id, array $categories)
    {
        return DB::table($this->table)
            ->where('products.tenant_id', $id)
            ->select('products.*')
            ->paginate();
    }

    public function getProductByUuid(string $uuid)
    {
        return DB::table($this->table)
            ->where('uuid', $uuid)
            ->first();
    }
}
