<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;

class UserResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'userId' => $this->USER_ID,
            'firstName' => $this->FIRST_NAME,
            'lastName' => $this->LAST_NAME,
            'cpf' => $this->CPF,
            'email' => $this->EMAIL,
            'birthday' => $this->BIRTHDAY,
            'password' => $this->PASSWORD,
            'addressId' => $this->ADDRESS_ID
        ];
    }
}
