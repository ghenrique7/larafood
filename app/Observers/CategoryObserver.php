<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryObserver
{
    public function creating(Category $category): void
    {
        $category->uuid = Str::uuid();
        $category->url = Str::kebab($category->name);
    }

    public function updating(Category $category): void
    {
        $category->url = Str::kebab($category->name);
    }
}
