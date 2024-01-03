<?php

namespace App\Services;

use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\TableRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;

class OrderService
{
    protected $orderRepository, $tenantRepository, $tableRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        TenantRepositoryInterface $tenantRepository,
        TableRepositoryInterface $tableRepository,
    ) {
        $this->orderRepository = $orderRepository;
        $this->tenantRepository = $tenantRepository;
        $this->tableRepository = $tableRepository;
    }

    public function createNewOrder(array $order)
    {
        $identify = $this->getIdentifyOrder();
        $total = $this->getTotalOrder([]);
        $status = 'open';
        $tenantId = $this->getTenantIdByOrder($order['token_company']);
        $comment = isset($order['comment']) ? $order['comment'] : '';
        $clientId = $this->getClientIdByOrder();
        $tableId = $this->getTableIdByOrder($order['table'] ?? '');

        return $this->orderRepository->createNewOrder(
            $identify,
            $total,
            $status,
            $tenantId,
            $comment,
            $clientId,
            $tableId
        );
    }

    private function getIdentifyOrder(int $qtyCharacters = 8)
    {
        $smallLetters = str_shuffle('abcdefghijklmnopqrstuvwxyz');

        $numbers = (((date('Ymd') / 12) * 24) + mt_rand(800, 9999));
        $numbers .= 123456789;

        $characters = $smallLetters . $numbers;

        $identify = substr(str_shuffle($characters), 0, $qtyCharacters);

        if($this->orderRepository->getOrderByIdentify($identify)) {
            $this->getIdentifyOrder($qtyCharacters + 1);
        }

        return $identify;
    }

    private function getTotalOrder(array $products): float
    {
        return (float) 90;
    }

    private function getTenantIdByOrder(string $uuid)
    {
        $tenant = $this->tenantRepository->getTenantByUuid($uuid);

        return $tenant->id;
    }

    private function getTableIdByOrder(string $uuid)
    {
        if ($uuid) {
            $table = $this->tableRepository->getTableByUuid($uuid);
            return $table->id;
        }

        return null;
    }

    private function getClientIdByOrder()
    {
        return auth()->check() ? auth()->user()->id : null;
    }
}
