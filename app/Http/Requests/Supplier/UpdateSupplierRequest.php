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
            'corporateName' => [
                'sometimes',
                'required'
            ],
            'tradeName' => [
                'sometimes',
                'required'
            ],
            'cnpj' => [
                'sometimes',
                'required',
                'size:14',
                'unique:App\Models\Supplier,cnpj',
                'numeric'
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                'unique:App\Models\Supplier,email'
            ],
            'commercialPhone' => [
                'sometimes',
                'required',
                'numeric'
            ],
            'addressId' => [
                'sometimes',
                'required'
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
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

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages() : array
    {
        $messages = array(
            'corporateName.required' => 'Razão social inválida',
            'tradeName.required' => 'Nome fantasia inválido',
            'cnpj.unique' => 'CNPJ já existente',
            'cnpj.required' => 'CNPJ inválido.',
            'cnpj.numeric' => 'O CNPJ deve conter só números',
            'cnpj.size' => 'CNPJ deve ter somente 14 números',
            'email.unique' => 'Email já existente',
            'email.email' => 'Email inválido',
            'commercialPhone.required' => 'Telefone comercial inválido',
            'commercialPhone.numeric' => 'Telefone deve conter só números',
            'addressId.required' => 'Endereço inválido'
        );

        return $messages;
    }
}