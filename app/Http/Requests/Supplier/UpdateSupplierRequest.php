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
        $method = $this->getMethod();
        $sometimes = $method == 'PATCH' ? 'sometimes' : null;

        return [
            'corporateName' => [
                $sometimes,
                'required'
            ],
            'tradeName' => [
                $sometimes,
                'required'
            ],
            'cnpj' => [
                $sometimes,
                'required',
                'digits:14',
                'unique:App\Models\Supplier,cnpj',
                'numeric'
            ],
            'email' => [
                $sometimes,
                'required',
                'email',
                'unique:App\Models\Supplier,email'
            ],
            'commercialPhone' => [
                $sometimes,
                'required',
                'numeric'
            ],
            'addressId' => [
                $sometimes,
                'required'
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        if ($this->corporateName)
            $this->merge(['CORPORATE_NAME' => $this->corporateName]);

        if ($this->tradeName)
            $this->merge(['TRADE_NAME' => $this->tradeName]);

        if ($this->cnpj)
            $this->merge(['CNPJ' => $this->cnpj]);

        if ($this->email)
            $this->merge(['EMAIL' => $this->email]);

        if ($this->commercialPhone)
            $this->merge(['COMMERCIAL_PHONE' => $this->commercialPhone]);

        if ($this->addressId)
            $this->merge(['ADDRESS_ID' => $this->addressId]);
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
            'cnpj.digits' => 'CNPJ deve ter somente 14 números',
            'email.unique' => 'Email já existente',
            'email.email' => 'Email inválido',
            'commercialPhone.required' => 'Telefone comercial inválido',
            'commercialPhone.numeric' => 'Telefone deve conter só números',
            'addressId.required' => 'Endereço inválido'
        );

        return $messages;
    }
}