<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array {
        return [
            'firstName' => ['sometimes', 'required'],
            'lastName' => ['sometimes', 'required'],
            'cpf' => ['sometimes', 'required'],
            'email' => ['sometimes', 'required'],
            'age' => ['sometimes', 'required'],
            'password' => ['sometimes', 'required'],
            'addressId' => ['sometimes', 'required']
        ];
    }

    protected function prepareForValidation() {
        if ($this->firstName
        && $this->lastName
        && $this->cpf
        && $this->email
        && $this->age
        && $this->password
        && $this->addressId
        )
        $this->merge([
            'FIRST_NAME' => $this->firstName,
            'LAST_NAME' => $this->lastName,
            'CPF' => $this->cpf,
            'EMAIL' => $this->email,
            'AGE' => $this->age,
            'PASSWORD' => $this->password,
            'ADDRESS_ID' => $this->addressId,
        ]);
    }
}
