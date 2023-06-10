<?php

namespace App\Http\Resources\Purchase;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'purchaseId' => $this->PURCHASE_ID,
            'shoppingCartId' => $this->SHOPPING_CART_ID,
            'userId' => $this->USER_ID,
            'productId' => $this->PRODUCT_ID,
            'amount' => $this->AMOUNT
        ];
    }
}
