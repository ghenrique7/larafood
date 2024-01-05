<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'identify' => $this->identify,
            'total' => $this->total,
            'status' => $this->status,
            'client' => $this->client_id ? new ClientResource($this->client) : '',
            'table' => $this->table_id ? new TableResource($this->table) : '',
            'products' => ProductResource::collection($this->products),
        ];
    }
}
