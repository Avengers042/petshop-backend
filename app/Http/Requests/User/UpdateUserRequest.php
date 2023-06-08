<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'firstName' => [$sometimes, 'required'],
            'lastName' => [$sometimes, 'required'],
            'cpf' => [
                'required',
                'digits:11',
                'unique:App\Models\User,cpf',
                'numeric'
            ],
            'email' => ['required', 'email'],
            'birthday' => [$sometimes, 'required'],
            'password' => [$sometimes, 'required'],
            'addressId' => [$sometimes, 'required'],
            'shoppingCartId' => [$sometimes, 'required']
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        if ($this->firstName)
            $this->merge(['FIRST_NAME' => $this->firstName]);

        if ($this->lastName)
            $this->merge(['LAST_NAME' => $this->lastName]);

        if ($this->cpf)
            $this->merge(['CPF' => $this->cpf]);

        if ($this->email)
            $this->merge(['EMAIL' => $this->email]);

        if ($this->birthday)
            $this->merge(['BIRTHDAY' => $this->birthday]);

        if ($this->password)
            $this->merge(['PASSWORD' => $this->password]);

        if ($this->addressId)
            $this->merge(['ADDRESS_ID' => $this->addressId]);

        if ($this->shoppingCartId)
            $this->merge(['SHOPPING_CART_ID' => $this->shoppingCartId]);
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
