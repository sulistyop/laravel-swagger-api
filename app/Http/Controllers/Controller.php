<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 *
 *
 *
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Recap App API",
 *         description= "Cara login:
 * Login menggunakan endpoint `/authentication` dengan email dan password Anda.
 * Salin token dari respon yang dihasilkan, pada bagian `data.data.access_token`.
 * Klik tombol Authorize di pojok kanan atas.
 * Masukkan token, dengan format:  `Bearer <access_token>`.
 * Klik tombol Authorize."
 *     ),
 *     @OA\Server(
 *         description="LIVE server",
 *         url="/api/v1/",
 *     ),
 * )
 */


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
