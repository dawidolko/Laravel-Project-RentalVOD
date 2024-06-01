<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
    
        if ($exception instanceof BadRequestHttpException) {
            return response()->view('errors.400', [], 400);
        }
    
        if ($exception instanceof UnauthorizedHttpException) {
            return response()->view('errors.401', [], 401);
        }
    
        if ($exception instanceof AuthorizationException) {
            return response()->view('errors.403', [], 403);
        }
        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }
    
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->view('errors.405', [], 405);
        }
    
        if ($exception instanceof HttpException && $exception->getStatusCode() == 500) {
            return response()->view('errors.500', [], 500);
        }
    
        if ($exception instanceof HttpException && $exception->getStatusCode() == 503) {
            return response()->view('errors.503', [], 503);
        }
    
        return parent::render($request, $exception);
    }
}
