<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TenantRequest;
use App\Http\Resources\TableResource;
use App\Services\TableService;

class TableApiController extends Controller
{

    protected $tableService;

    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }

    public function index(TenantRequest $request)
    {
        $tables = $this->tableService->getTablesByTenantUuid($request->token_company);

        return TableResource::collection($tables);
    }

    public function show($identify) {

        if (!$table = $this->tableService->getTableByUuid($identify)) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return new TableResource($table);
    }
}
