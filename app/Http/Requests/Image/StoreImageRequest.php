<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'imageName' => ['required', 'string'],
            'imageAlt' => ['required', 'string']
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'IMAGE_NAME' => $this->imageName,
            'IMAGE_ALT' => $this->imageAlt
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
            'imageName.required' => 'Nome da imagem vazio',
            'imageName.string' => 'Nome da imagem precisa ser somente texto',
            'imageAlt.required' => 'Descrição da imagem vazia',
            'imageAlt.string' => 'Descrição da imagem precisa ser somente texto'
        );

        return $messages;
    }
}
