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
            ->join('category_product', 'category_product.product_id', 'products.id')
            ->join('categories', 'category_product.category_id', 'categories.id')
            ->where('products.tenant_id', $id)
            ->where(function($query) use ($categories) {
                if(count($categories) > 0)
                    $query->whereIn('categories.uuid', $categories);
            })
            ->select('products.*')
            ->paginate();
    }

    public function getProductByUuid(string $uuid) {
        return DB::table($this->table)
                ->where('uuid', $uuid)
                ->first();
    }

}
