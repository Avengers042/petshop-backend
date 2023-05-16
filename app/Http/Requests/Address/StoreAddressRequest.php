<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules() : array
    {
        return [
            'number' => ['required'],
            'cep' => ['required'],
            'uf' => ['required'],
            'district' => ['required'],
            'publicPlace' => ['required'],
            'complement' => ['required'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'NUMBER' => $this->number,
            'CEP' => $this->cep,
            'UF' => $this->uf,
            'DISTRICT' => $this->district,
            'PUBLIC_PLACE' => $this->publicPlace,
            'COMPLEMENT' => $this->complement
        ]);
    }
}