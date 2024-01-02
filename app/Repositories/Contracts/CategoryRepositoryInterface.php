<?php

namespace App\Repositories\Contracts;

interface CategoryRepositoryInterface
{
    public function getCategoriesByUuid(string $uuid);
    public function getCategoriesById(string $id);
    public function getCategoryByUuid(string $url);
}
