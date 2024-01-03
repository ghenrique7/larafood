<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    protected $repository;

    public function __construct(Order $repository)
    {
        $this->repository = $repository;
    }

    public function createNewOrder(
        string $identify,
        float $total,
        string $status,
        int $tenantId,
        string $comment = '',
        $clientId = null,
        $tableId = null
    ) {

        $data = [
            'identify' => $identify,
            'total' => $total,
            'status' => $status,
            'tenant_id' => $tenantId,
            'comment' => $comment,
            'client_id' =>$clientId,
            'table_id' => $tableId
        ];

       
        $order = $this->repository->create($data);

        return $order;
    }

    public function getOrderByIdentify(string $identify)
    {
        return $this->repository->where('identify', $identify)->first();
    }
}
