<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CategoryRequest;
use App\Http\Requests\Api\TenantRequest;
use App\Http\Resources\CategoryResource;

class CategoryApiController extends Controller
{
    protected $categoryService;

    public function __construct(
        CategoryService $categoryService
    ) {
        $this->categoryService = $categoryService;
    }

    public function categoriesByTenant(TenantRequest $request)
    {
        $categories = $this->categoryService->getCategoriesByUuid($request->token_company);
        return CategoryResource::collection($categories);
    }

    public function show($identify)
    {
        if(!$category = $this->categoryService->getCategoryByUuid($identify)) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return new CategoryResource($category);
    }
}
