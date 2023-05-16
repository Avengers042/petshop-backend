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
            'cnpj' => [
                'required',
                'regex:/^[0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2}$/',
                'unique:App\Models\Supplier,cnpj',
                'numeric'
            ],
            'email' => [
                'required',
                'email',
                'unique:App\Models\Supplier,email'
            ],
            'commercialPhone' => [
                'required',
                'numeric'
            ],
            'addressId' => ['required'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
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

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages() : array
    {
        $messages = array(
            'required' => ':Attribute inválido',
            'email.unique' => 'Email já existente',
            'email.email' => 'Email inválido',
            'corporateName.required' => 'Razão social inválida',
            'cnpj.unique' => 'CNPJ já existente',
            'cnpj.required' => 'CNPJ inválido.',
            'cnpj.numeric' => 'O CNPJ deve conter só números',
            'cnpj.regex' => 'CNPJ inválido'
        );

        return $messages;
    }
}