<?php

namespace App\Http\Resources\ShoppingCart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShoppingCartResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'shoppingCartId' => $this->SHOPPING_CART_ID,
        ];
    }
}