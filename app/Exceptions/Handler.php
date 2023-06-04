<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Traits\RestExceptionHandlerTrait;
use Illuminate\Support\Str;

class Handler extends ExceptionHandler
{
    use RestExceptionHandlerTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Throwable  $exception
     * @return mixed
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        $oauthUriPattern = "#^http(s)?:\/\/(.*)\/api\/v\d\/oauth\/(authorize|tokens?|clients|personal-access-tokens|scopes)((\/|\?).*)?$#";

        if (preg_match($oauthUriPattern, $request->getUri())) {
            if ($exception instanceof AuthenticationException && !Str::contains($request->getUri(), 'authorize')) {
                return $this->restUnauthenticated();
            }
            return parent::render($request, $exception);
        }

        return $this->getJsonResponseForException($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? response()->json(['message' => $exception->getMessage()], 401)
            : redirect()->guest(\route('auth.login'));
    }
}
