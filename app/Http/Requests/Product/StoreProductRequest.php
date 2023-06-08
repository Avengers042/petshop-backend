<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'supplierId' => ['required'],
            'imageId' => ['required'],
            'categoryId' => ['required']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'NAME' => $this->name,
            'DESCRIPTION' => $this->description,
            'PRICE' => $this->price,
            'SUPPLIER_ID' => $this->supplierId,
            'IMAGE_ID' => $this->imageId,
            'CATEGORY_ID' => $this->categoryId
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
            'name.required' => 'Nome inválido.',
            'description.required' => 'Descrição inválida.',
            'price.required' => 'Preço inválido',
            'supplierId.required' => 'Fornecedor inválido.',
            'imageId.required' => 'Imagem inválida.',
            'categoryId.required' => 'Categoria inválida.'
        );

        return $messages;
    }
}
