<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrder;
use App\Http\Requests\Api\TenantRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;

class OrderApiController extends Controller
{
    protected $orderService;

    public function __construct(
        OrderService $orderService
    ) {
        $this->orderService = $orderService;
    }

    public function store(StoreOrder $request) {
        $order = $this->orderService->createNewOrder($request->all());

        return new OrderResource($order);
    }

    public function show(TenantRequest $request, $identify) {


        return new ProductResource($product);
    }
}
