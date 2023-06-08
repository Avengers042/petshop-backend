<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'firstName' => ['required','string'],
            'lastName' => ['required', 'string'],
            'cpf' => [
                'required',
                'digits:11',
                'unique:App\Models\User,cpf',
                'numeric'
            ],
            'email' => ['required', 'email'],
            'birthday' => ['required'],
            'password' => ['required'],
            'addressId' => ['required'],
            'shoppingCartId' => ['required']
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'FIRST_NAME' => $this->firstName,
            'LAST_NAME' => $this->lastName,
            'CPF' => $this->cpf,
            'EMAIL' => $this->email,
            'BIRTHDAY' => $this->birthday,
            'PASSWORD' => $this->password,
            'ADDRESS_ID' => $this->addressId,
            'SHOPPING_CART_ID' => $this->shoppingCartId
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
            'firstName.required' => 'Nome inválido',
            'lastName.required' => 'Último nome inválido',
            'cpf.unique' => 'CPF já existente',
            'cpf.required' => 'CPF inválido.',
            'cpf.numeric' => 'O CPF deve conter só números',
            'cpf.digits' => 'CPF deve ter somente 11 números',
            'email.unique' => 'Email já existente',
            'email.email' => 'Email inválido',
            'birthday.required' => 'Data de nascimento inválida',
            'password.required' => 'Senha inválida',
            'addressId.required' => 'Endereço inválido',
            'shoppingCartId.required' => 'Carrinho de compras inválido'
        );

        return $messages;
    }
}
