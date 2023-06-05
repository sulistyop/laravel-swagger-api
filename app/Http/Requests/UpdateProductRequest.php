<?php

namespace App\Http\Requests;

use App\Http\APIRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_name' => [
                'string',
                'required',
                Rule::unique('products')
            ],
            'product_code' => [
                'string',
                'required'
            ],
            'price' => 'required|integer',
        ];
    }
}
