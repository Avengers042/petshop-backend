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
            'firstName' => ['required'],
            'lastName' => ['sometimes', 'required'],
            'cpf' => ['required'],
            'email' => ['required'],
            'age' => ['sometimes', 'required'],
            'password' => ['required'],
            'addressId' => ['sometimes', 'required']
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
            'AGE' => $this->age,
            'PASSWORD' => $this->password,
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
            'firstName.required' => 'Nome inválido',
            'lastName.required' => 'Último nome inválido',
            'cpf.required' => 'CPF inválido',
            'email.required' => 'Email inválido',
            'age.required' => 'Idade inválida',
            'password.required' => 'Senha inválida',
            'addressId.required' => 'Endereço inválido'
        );

        return $messages;
    }
}
