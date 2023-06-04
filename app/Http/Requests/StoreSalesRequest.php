<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSalesRequest extends FormRequest
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
        $productId = $this->getProductId();
        return [
            'trans_date' => 'date|required',
            'buyer_name' => 'string|required',
            'sales_code' => [
                'string',
                'required',
                Rule::unique('sales')
            ],
            'product_id' => [
                'array',
                'in:' . $productId
            ],

        ];
    }

    /**
     * Mengambil id group contact yang tersedia / active
     *
     * @return string
     */
    private function getProductId()
    {
        $products = Product::all()->toArray();

        $getProductid = [];
        foreach ($products as $product) {
            $getProductid[] = $product['id'];
        }

        return  implode(',', $getProductid);
    }
}
