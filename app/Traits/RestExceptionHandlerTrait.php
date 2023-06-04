<?php

namespace App\Traits;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;

trait RestExceptionHandlerTrait
{

    /**
     * Creates a new JSON response based on exception type.
     *
     * @param Request $request
     * @param Throwable $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getJsonResponseForException(Request $request, Throwable $e)
    {
        switch (true) {
            case $this->isModelNotFoundException($e):
                $retval = $this->modelNotFound($e);
                break;

            case $this->isAuthorizationException($e):
                $retval = $this->accessDenied();
                break;

            case $this->AuthenticationException($e):
                $retval = $this->restUnauthenticated();
                break;

            default:
                if (config('app.env') != 'production') {
                    $message = (method_exists($e, 'errors')) ? $e->errors() : $e->__toString();

                    if (method_exists($e, 'errors')) {
                        $message = $e->errors();
                    } else {
                        $message =  $GLOBALS["unexpected_error"] = "Error Unexpected:" .  $request->fullUrl() . print_r($request->all(), 1) .  $e->__toString();
                        /**
                         * di die() supaya tampilan di swaggernya gampang dibaca kalau error
                         */
                        if (config('app.env') !== 'production' && config('app.env') !== 'testing') {
                            die($GLOBALS["unexpected_error"]);
                        }
                    }
                    if (is_array($message)) {
                        $message = reset($message)[0];
                    }
                } else {
                    if (method_exists($e, 'errors')) {
                        $message = $e->errors();
                    } else {
                        if (
                            !preg_match('/NotFoundHttpException/', $e->__toString()) &&
                            !preg_match('/UnauthorizedException/', $e->__toString())
                        ) {
                            $message = "Something wrong";

                            $GLOBALS["unexpected_error"] = "Error Unexpected:" . $request->fullUrl() . " --- eof url --- " . $e->__toString(); //print_r($_REQUEST,1) . print_r($request->all(),1) .
                            $GLOBALS["unexpected_error"] = substr($GLOBALS["unexpected_error"], 0, 1000) . " --- eof e string --- ";
                        } else {
                            $message = "Something wrong";
                        }
                    }
                    if (isset($message) && is_array($message)) {
                        $message = reset($message)[0];
                    }
                }
                $message    = ucfirst($message);
                $retval = $this->badRequest($message);
        }

        return $retval;
    }

    /**
     * Returns json response for generic bad request.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function badRequest($message = 'Bad request', $statusCode = 400)
    {
        return $this->jsonResponse(['message' => $message], $statusCode);
    }

    /**
     * Returns json response for Eloquent model not found exception.
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function modelNotFound($e, $message = 'Record not found', $statusCode = 404)
    {
        if (config('app.env') != 'production') {
            $message = (method_exists($e, 'errors')) ? $e->errors() : $e->__toString();
            if (is_array($message)) {
                $message = reset($message)[0];
            }
        }

        return $this->jsonResponse(['message' => $message], $statusCode);
    }


    protected function accessDenied($message = 'Access denied', $statusCode = 403)
    {
        return $this->jsonResponse(['message' => $message], $statusCode);
    }

    protected function restUnauthenticated($message = 'Unauthenticated', $statusCode = 401)
    {
        return $this->jsonResponse(['message' => $message], $statusCode);
    }

    /**
     * Returns json response.
     *
     * @param array|null $payload
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse(array $payload = null, $statusCode = 404)
    {
        $payload = $payload ?: [];
        $payload['success'] = false;
        return response()->json($payload, $statusCode);
    }

    /**
     * Determines if the given exception is an Eloquent model not found.
     *
     * @param Exception $e
     * @return bool
     */
    protected function isModelNotFoundException(Throwable $e)
    {
        return $e instanceof ModelNotFoundException;
    }

    protected function isAuthorizationException(Throwable $e)
    {
        return $e instanceof AuthorizationException;
    }

    protected function AuthenticationException(Throwable $e)
    {
        return $e instanceof AuthenticationException;
    }
}
