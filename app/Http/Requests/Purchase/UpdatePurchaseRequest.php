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
            'productId' => ['sometimes', 'required'],
            'userId' => ['sometimes', 'required'],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->productId
            && $this->userId)
            $this->merge([
                'PRODUCT_ID' => $this->productId,
                'USER_ID' => $this->userId,
            ]);
    }
}