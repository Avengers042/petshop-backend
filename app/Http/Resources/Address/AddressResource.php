<?php

namespace App\Http\Resources\Address;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'addressId' => $this->ADDRESS_ID,
            'number' => $this->NUMBER,
            'cep' => $this->CEP,
            'uf' => $this->UF,
            'district' => $this->DISTRICT,
            'publicPlace' => $this->PUBLIC_PLACE,
            'complement' => $this->COMPLEMENT
        ];
    }
}
