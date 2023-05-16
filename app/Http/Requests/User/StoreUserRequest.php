<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest {
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
        $this->merge([
            'FIRST_NAME' => $this->FIRST_NAME,
            'LAST_NAME' => $this->LAST_NAME,
            'CPF' => $this->CPF,
            'EMAIL' => $this->EMAIL,
            'AGE' => $this->AGE,
            'PASSWORD' => $this->PASSWORD,
            'ADDRESS_ID' => $this->ADDRESS_ID,
        ]);
    }
}
