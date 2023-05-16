<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
            'number' => ['sometimes', 'required'],
            'cep' => ['sometimes', 'required'],
            'uf' => ['sometimes', 'required'],
            'district' => ['sometimes', 'required'],
            'publicPlace' => ['sometimes', 'required'],
            'complement' => ['sometimes', 'required'],
        ];
    }

    protected function prepareForValidation() {
        if ($this->NUMBER
        && $this->CEP
        && $this->UF
        && $this->DISTRICT
        && $this->PUBLIC_PLACE
        && $this->COMPLEMENT
        )
        $this->merge([
            'NUMBER' => $this->NUMBER,
            'CEP' => $this->CEP,
            'UF' => $this->UF,
            'DISTRICT' => $this->DISTRICT,
            'PUBLIC_PLACE' => $this->PUBLIC_PLACE,
            'COMPLEMENT' => $this->COMPLEMENT
        ]);
    }
}
