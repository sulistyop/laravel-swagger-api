<?php

namespace App\Http\Requests;

use App\Http\APIRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteSalesRequest extends APIRequest
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
        return 'haha';
        // return [
        //     'sales_code' => [
        //         'required',
        //         Rule::exists('sales')->where(function ($query) use ($id) {
        //             $query->where('id', $id);
        //         }),
        //     ]
        // ];
    }
}
