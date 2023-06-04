<?php

namespace App\Http\Requests;

use App\Http\APIRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends APIRequest
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
            'product_name' => ['required', Rule::unique('products')],
            'product_code' => ['required', Rule::unique('products')],
            'price' => 'required|integer',
        ];
    }
}
