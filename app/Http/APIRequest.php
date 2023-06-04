<?php

namespace App\Http;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use App\Http\ResponseUtil;
use Illuminate\Support\Facades\Response;

class APIRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Get the proper failed validation response for the request.
     *
     * @param array $errors
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        $messages = implode(' ', Arr::flatten($errors));

        return Response::json(ResponseUtil::makeError($messages), 400);
    }
}
