<?php

namespace App\Repositories\Contracts;

interface ProductRepositoryInterface
{
    public function getProductsByTenantId(string $id, array $categories);
    public function getProductByUuid(string $uuid);
}
