<?php

namespace App\Http\Resources;

use App\Models\Products;
use App\Models\statuses;
use App\Models\User;
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
            'productBrand' => $this->product->brand,
            'productModel' => $this->product->model,
            'userFirstName' => $this->user->firstName,
            'orderDate' => $this->orderDate,
            'deliveryDate' => $this->deliveryDate,
            'price' => $this->price,
            'quantityProduct' => $this->quantityProduct,
            'statusName' => statuses::find($this->status_id)->name,
        ];
    }
}
