<?php

namespace App\Http\Controllers;

use App\Http\ResponseUtil;
use Illuminate\Support\Facades\Response;

trait ResponseTrait
{
    public function sendResponse($result, $message, int $code = 200)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result), $code);
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }
}
