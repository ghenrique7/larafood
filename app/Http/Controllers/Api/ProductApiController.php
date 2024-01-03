<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TenantRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;

class ProductApiController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(TenantRequest $request)
    {
        $products = $this->productService->getProductsByTenantUuid(
            $request->token_company,
            $request->get('categories', [])
        );

        return ProductResource::collection($products);
    }

    public function show(string $uuid) {
        if (!$product = $this->productService->getProductByUuid($uuid)) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return new ProductResource($product);
    }
}
