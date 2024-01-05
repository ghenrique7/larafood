<?php

namespace App\Repositories;

use App\Models\Evaluation;
use App\Models\Tenant;
use App\Repositories\Contracts\EvaluationRepositoryInterface;

class EvaluationRepository implements EvaluationRepositoryInterface
{
    protected $repository;

    public function __construct(Evaluation $evaluation)
    {
        $this->repository = $evaluation;
    }

    public function newEvaluationOrder(int $idOrder, int $idClient, array $evaluation)
    {
        $data = [
            'client_id' => $idClient,
            'order_id' => $idOrder,
            'stars' => $evaluation['stars'],
            'comment' => isset($evaluation['comment']) ? $evaluation['comment'] : ''
        ];

        return $this->repository->create($data);
    }

    public function getEvaluationsByOrder(int $idOrder)
    {
        return $this->repository->where('order_id', $idOrder)->get();
    }

    public function getEvaluationsByClient(int $idClient)
    {
        return $this->repository->where('client_id', $idClient)->get();
    }

    public function getEvaluationsById(int $id)
    {
        return $this->repository->find($id);
    }

    public function getEvaluationsByClientIdByOrderId(int $idOrder, int $idClient)
    {
        return $this->repository
            ->where('client_id', $idClient)
            ->where('order_id', $idOrder)
            ->get();
    }
}
