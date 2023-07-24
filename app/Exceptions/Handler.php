<?php

namespace App\Exceptions;

use App\Traits\HasApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{   
    use HasApiResponse;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        $response = [
            'message' => $exception->getMessage()
        ];

        if ($exception instanceof ValidationException)
        {
            return $this->respondUnprocessableContent($response);
        }

        if ($exception instanceof AuthenticationException)
        {
            return $this->respondUnAuthorized($response);
        }

        return $this->respondInternalServerError($response);
    }
}
