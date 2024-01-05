<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use TenantTrait;
    use HasFactory;

    protected $fillable = ['title', 'flag', 'image', 'price', 'description'];

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function categoriesAvailable($filter = null)
    {
        $categories = Category::whereNotIn('categories.id', function ($query) {
            $query->select('category_product.category_id');
            $query->from('category_product');
            $query->whereRaw("category_product.product_id={$this->id}");
        })
            ->where(function($queryFilter) use($filter) {
                if($filter) {
                    $converted = strtolower($filter['filter']);
                    $queryFilter->where('categories.name', 'LIKE', "%{$converted}%");
                }
            })
            ->paginate();

        return $categories;
    }
}
