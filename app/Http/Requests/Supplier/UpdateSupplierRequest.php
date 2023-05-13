<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
            'corporateName' => ['sometimes', 'required'],
            'tradeName' => ['sometimes', 'required'],
            'cnpj' => ['sometimes', 'required'],
            'email' => ['sometimes', 'required', 'email'],
            'commercialPhone' => ['sometimes', 'required'],
            'addressId' => ['sometimes', 'required']
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->corporateName
            && $this->tradeName
            && $this->cnpj
            && $this->email
            && $this->commercialPhone
            && $this->addressId)
            $this->merge([
                'CORPORATE_NAME' => $this->corporateName,
                'TRADE_NAME' => $this->tradeName,
                'CNPJ' => $this->cnpj,
                'EMAIL' => $this->email,
                'COMMERCIAL_PHONE' => $this->commercialPhone,
                'ADDRESS_ID' => $this->addressId
            ]);
    }
}