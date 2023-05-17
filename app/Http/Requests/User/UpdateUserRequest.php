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
            'firstName' => [$sometimes, 'required'],
            'lastName' => [$sometimes, 'required'],
            'cpf' => [$sometimes, 'required'],
            'email' => [$sometimes, 'required'],
            'age' => [$sometimes, 'required'],
            'password' => [$sometimes, 'required'],
            'addressId' => [$sometimes, 'required']
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

        if ($this->age)
            $this->merge(['AGE' => $this->age]);

        if ($this->password)
            $this->merge(['PASSWORD' => $this->password]);

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
