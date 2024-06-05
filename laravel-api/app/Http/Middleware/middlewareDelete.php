<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Customer;
use Symfony\Component\HttpKernel\Exception\HttpException;

class middlewareDelete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $email = $request->route('email');
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            // Return a response with validation errors
            throw new ValidationException($validator);
        }
        
        // Find the customer by email
        $customer = Customer::where('email', $email)->first();

        if (!$customer || $customer->status === 'trash') {
            throw new HttpException(404, 'Registro no existe');
        }

        $request->attributes->add(['customer' => $customer]);
        return $next($request);
    }
}
