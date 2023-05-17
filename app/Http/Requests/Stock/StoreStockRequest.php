<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequest extends FormRequest
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
            'productId' => ['sometimes', 'required'],
            'amount' => ['sometimes', 'required'],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->productId && $this->amount) $this->merge([
            'PRODUCT_ID' => $this->productId,
            'AMOUNT' => $this->amount,
        ]);
    }

    public function messages(): array
    {
        return [
            'productId.required' => 'Produto inválido.',
            'amount.required' => 'Quantidade inválida.',
        ];
    }
}
