<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        $user = $this->user();
        return $user != null && $user->tokenCan('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules() : array
    {
        return [
            'shoppingCartId' => ['required'],
            'productId' => ['required'],
            'userId' => ['required'],
            'amount' => ['required'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'SHOPPING_CART_ID' => $this->shoppingCartId,
            'PRODUCT_ID' => $this->productId,
            'USER_ID' => $this->userId,
            'AMOUNT' => $this->amount
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
            'shoppingCartId.required' => 'Carrinho de compras inválido',
            'productId.required' => 'Produto inválido',
            'userId.required' => 'Usuário inválido',
            'amount.required' => 'Usuário inválido'
        );

        return $messages;
    }
}
