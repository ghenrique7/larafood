<?php


use App\Http\Controllers\Api\{
    CategoryApiController,
    EvaluationApiController,
    OrderApiController,
    ProductApiController,
    TableApiController,
    TenantApiController
};
use App\Http\Controllers\Api\Auth\{
    AuthClientController,
    RegisterController
};
use Illuminate\Support\Facades\Route;

Route::post('/sanctum/token', [AuthClientController::class, 'auth']);

Route::group(
    [
        'middleware' => ['auth:sanctum']
    ],
    function () {
        Route::get('/auth/me', [AuthClientController::class, 'me']);
        Route::post('/auth/logout', [AuthClientController::class, 'logout']);

        Route::post('/auth/v1/orders/{identify}/evaluations', [EvaluationApiController::class, 'store']);

        Route::get('/auth/v1/my-orders', [OrderApiController::class, 'myOrders']);
        Route::post('/auth/v1/orders', [OrderApiController::class, 'store']);
    }
);

Route::group([
    'prefix' => 'v1'
], function () {
    Route::get('/tenant/{uuid}', [TenantApiController::class, 'show']);
    Route::get('/tenants', [TenantApiController::class, 'index']);

    Route::get('/table/{identify}', [TableApiController::class, 'show']);
    Route::get('/tables', [TableApiController::class, 'index']);

    Route::get('/category/{identify}', [CategoryApiController::class, 'show']);
    Route::get('/categories', [CategoryApiController::class, 'index']);

    Route::get('/product/{identify}', [ProductApiController::class, 'show']);
    Route::get('/products', [ProductApiController::class, 'index']);

    Route::post('/client', [RegisterController::class, 'store']);

    Route::post('/orders', [OrderApiController::class, 'store']);
    Route::get('/orders/{identify}', [OrderApiController::class, 'show']);
});
