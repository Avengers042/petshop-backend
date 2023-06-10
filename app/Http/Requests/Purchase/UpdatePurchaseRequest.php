<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseRequest extends FormRequest
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
            'shoppingCartId' => [$sometimes, 'required'],
            'productId' => [$sometimes, 'required'],
            'userId' => [$sometimes, 'required'],
            'amount' => [$sometimes, 'required']
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        if ($this->productId)
            $this->merge(['PRODUCT_ID' => $this->productId]);

        if ($this->userId)
            $this->merge(['USER_ID' => $this->userId]);

        if ($this->shoppingCartId)
            $this->merge(['SHOPPING_CART_ID' => $this->shoppingCartId]);

        if ($this->amount)
            $this->merge(['AMOUNT' => $this->amount]);
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