<?php

namespace App\Repositories;

use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    protected $repository;

    public function __construct(Client $repository)
    {
        //$this->table = 'clients';
        $this->repository = $repository;
    }

    public function createNewClient(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        return $this->repository->create($data);
    }

    public function getClient(int $id)
    {
    }
}
