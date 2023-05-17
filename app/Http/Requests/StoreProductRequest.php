<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => ['sometimes', 'required'],
            'description' => ['sometimes', 'required'],
            'supplierId' => ['sometimes', 'required']
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->name && $this->description && $this->supplierId)
            $this->merge([
                'NAME' => $this->name,
                'DESCRIPTION' => $this->description,
                'SUPPLIER_ID' => $this->supplierId,
            ]);

    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nome inválido.',
            'description.required' => 'Descrição inválida.',
            'supplierId.required' => 'Fornecedor inválido.',
        ];
    }
}