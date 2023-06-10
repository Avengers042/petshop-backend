<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdateProductRequest extends FormRequest
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
    public function rules(): array
    {
        $method = $this->getMethod();
        $sometimes = $method == 'PATCH' ? 'sometimes' : null;

        return [
            'name' => [$sometimes, 'required'],
            'description' => [$sometimes, 'required'],
            'price' => [$sometimes, 'required'],
            'supplierId' => [$sometimes, 'required'],
            'imageId' => [$sometimes, 'required'],
            'categoryId' => [$sometimes, 'required']
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->name)
            $this->merge(['NAME' => $this->name]);

        if ($this->description)
            $this->merge(['DESCRIPTION' => $this->description]);

        if (isset($this->price))
            $this->merge(['PRICE' => $this->price]);

        if ($this->supplierId)
            $this->merge(['SUPPLIER_ID' => $this->supplierId]);

        if ($this->imageId)
            $this->merge(['IMAGE_ID' => $this->imageId]);

        if ($this->categoryId)
            $this->merge(['CATEGORY_ID' => $this->categoryId]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $messages = array(
            'name.required' => 'Nome inválido.',
            'description.required' => 'Descrição inválida.',
            'price.required' => 'Preço inválido.',
            'supplierId.required' => 'Fornecedor inválido.',
            'imageId.required' => 'Imagem inválida.',
            'categoryId.required' => 'Categoria inválida.'
        );

        return $messages;
    }
}
