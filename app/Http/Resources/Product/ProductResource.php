<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array
    {
        return [
            'productId' => $this->PRODUCT_ID,
            'name' => $this->NAME,
            'description' => $this->DESCRIPTION,
            'price' => $this->PRICE,
            'supplierId' => $this->SUPPLIER_ID,
            'imageId' => $this->IMAGE_ID,
            'categoryId' => $this->CATEGORY_ID
        ];
    }
}
