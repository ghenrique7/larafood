<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\DB;

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
            'client_id' => $clientId,
            'table_id' => $tableId
        ];


        $order = $this->repository->create($data);

        return $order;
    }

    public function getOrderByIdentify(string $identify)
    {
        return $this->repository->where('identify', $identify)->first();
    }

    public function registerProductsOrder(int $orderId, array $products)
    {
        $order = $this->repository->find($orderId);

        $orderProducts = [];

        foreach ($products as $product) {
            $orderProducts[$product['id']] = [
                'qty' => $product['qty'],
                'price' => $product['price']
            ];
        }

        $order->products()->attach($orderProducts);

        // foreach($products as $product) {
        //     array_push($orderProducts, [
        //         'order_id' => $orderId,
        //         'product_id' => $product['id'],
        //         'qty' => $product['qty'],
        //         'price' => $product['price']
        //     ]);

        //     DB::table('order_product')->insert($orderProducts);
        // }


    }
}
