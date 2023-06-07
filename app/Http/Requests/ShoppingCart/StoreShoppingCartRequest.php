<?php

namespace App\Http\Requests\ShoppingCart;

use Illuminate\Foundation\Http\FormRequest;

class StoreShoppingCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'productId' => ['required'],
            'amount' => ['required', 'integer', 'min:1'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'product_id' => $this->productId,
            'amount' => $this->amount,
        ]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'productId.required' => 'O ID do produto é obrigatório.',
            'amount.required' => 'A quantidade é obrigatória.',
            'amount.integer' => 'A quantidade deve ser um número inteiro.',
            'amount.min' => 'A quantidade deve ser pelo menos 1.',
        ];
    }
}
