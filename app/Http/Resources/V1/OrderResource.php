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
            'user' => new UserResource($this->user),
            'artboards' => $this->artboards,
            'order_date' => $this->order_date,
            'status' => $this->status,
            'total' => $this->total,
            'created_at' => $this->created_at,
        ];
    }
}
