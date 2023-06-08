<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        $user = $this->user();
        return $user != null && $user->tokenCan('update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules() : array
    {
        $method = $this->getMethod();
        $sometimes = $method == 'PATCH' ? 'sometimes' : null;

        return [
            'number' => [$sometimes, 'required'],
            'cep' => [$sometimes, 'required'],
            'uf' => [$sometimes, 'required'],
            'district' => [$sometimes, 'required'],
            'publicPlace' => [$sometimes, 'required'],
            'complement' => [$sometimes, 'required'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        if ($this->number)
            $this->merge(['NUMBER' => $this->number]);

        if ($this->cep)
            $this->merge(['CEP' => $this->cep]);

        if ($this->uf)
            $this->merge(['UF' => $this->uf]);

        if ($this->district)
            $this->merge(['DISTRICT' => $this->district]);

        if ($this->publicPlace)
            $this->merge(['PUBLIC_PLACE' => $this->publicPlace]);

        if ($this->complement)
            $this->merge(['COMPLEMENT' => $this->complement]);
    }
}