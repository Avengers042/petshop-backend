<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
            'corporateName' => ['required'],
            'tradeName' => ['required'],
            'cnpj' => ['required'],
            'email' => ['required', 'email'],
            'commercialPhone' => ['required'],
            'addressId' => ['required'],
        ];
    }

    protected function prepareForValidation()
    {
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