<?php


namespace App\Exceptions;


use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Exception;

class ExceptionHandler extends Exception
{
    public function render($request, Throwable $exception)
    {
        // Handle validation exceptions
        if ($exception instanceof ValidationException) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $exception->errors(),
            ], 422);
        }

        // Handle HTTP exceptions
        if ($exception instanceof HttpException) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], $exception->getStatusCode());
        }


    }
}
