<?php

namespace App\Repositories\Contracts;

interface TenantRepositoryInterface
{
    public function getAll(int $per_page);
    public function getTenantByUuid(string $uuid);
}
