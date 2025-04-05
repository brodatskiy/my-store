<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Product\ProductOrderResource;
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
            "id" => $this->id,
            "total" => $this->total,
            "status" => $this->status,
            'products' => ProductOrderResource::collection(($this->products))->resolve(),
        ];
    }
}
