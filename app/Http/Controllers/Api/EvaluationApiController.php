<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreEvaluationOrder;
use App\Http\Resources\EvaluationResource;
use App\Services\EvaluationService;

class EvaluationApiController extends Controller
{
    protected $evaluationService;

    public function __construct(
        EvaluationService $evaluationService
    ) {
        $this->evaluationService = $evaluationService;
    }

    public function store(StoreEvaluationOrder $request)
    {
        $data = $request->only(['stars', 'comment']);
        $evaluation = $this->evaluationService->createNewEvaluation($request->identify, $data);

        return new EvaluationResource($evaluation);
    }
}
