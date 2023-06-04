<?php

namespace App\Http\Controllers;

/**
 * @OA\SecurityScheme(
 *   securityScheme="Bearer",
 *   type="apiKey",
 *   name="Authorization",
 *   in="header"
 * )
 */
class AppBaseController extends Controller
{
    use ResponseTrait;
}
