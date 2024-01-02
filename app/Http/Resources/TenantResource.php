<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'uuid' => $this->uuid,
            'flag' => $this->url,
            'contact' => $this->email,
            'date_created' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'image' => $this->logo ? url("storage/{$this->logo}") : null
        ];
    }
}
