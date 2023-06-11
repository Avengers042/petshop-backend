<?php

namespace App\Http\Requests\ShoppingCart;

use Illuminate\Foundation\Http\FormRequest;

class FinishShoppingCartRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules() : array
    {
        return [
            '*.purchaseId' => ['required'],
            '*.shoppingCartId' => ['required'],
            '*.userId' => ['required'],
            '*.productId' => ['required'],
            '*.amount' => ['required', 'min:1']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages() : array
    {
        return [
            '*.purchaseId.required' => 'Compra inválida.',
            '*.shoppingCartId.required' => 'Carrinho de compras inválido.',
            '*.userId.required' => 'Usuário inválido.',
            '*.productId.required' => 'Produto inválido.',
            '*.amount.required' => 'Quantidade inválida.',
            '*.amount.min' => 'Quantidade precisa ser maior que um',
        ];
    }
}