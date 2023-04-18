<?php

namespace App\Http\Resources\V1;

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
            'id' => $this->id,
            'customer' => new CustomerResource($this->customer),
            'artboard' => new ArtboardResource($this->artboard),
            'order_date' => $this->order_date,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
