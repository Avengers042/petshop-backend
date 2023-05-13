<?php

namespace App\Http\Resources\Supplier;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'supplierId' => $this->SUPPLIER_ID,
            'corporateName' => $this->CORPORATE_NAME,
            'tradeName' => $this->TRADE_NAME,
            'cnpj' => $this->CNPJ,
            'email' => $this->EMAIL,
            'commercialPhone' => $this->COMMERCIAL_PHONE,
            'addressId' => $this->ADDRESS_ID
        ];
    }
}
