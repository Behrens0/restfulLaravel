<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Customer;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Log;

class MiddlewareToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info("hola");
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:120|exists:customers,email',
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        Log::info("hola");

        return $next($request);
    }
}
