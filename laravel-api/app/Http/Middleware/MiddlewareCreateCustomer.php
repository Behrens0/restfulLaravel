<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class MiddlewareCreateCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|string|max:255',
            
            'email' => 'required|string|email|max:120|unique:customers, email',
            'id_com' => 'required|integer|exists:communes,id_com',
            'dni' => [
                'required',
                'string',
                'max:45',
                function ($value, $fail) use ($request) {
                    $exists = DB::table('customers')
                        ->where('dni', $value)
                        ->where('id_com', $request->id_com)
                        ->exists();
                    if ($exists) {
                        $fail('The combination of DNI, ID_COM, and ID_REG must be unique.');
                    }
                },
            ],
            'last_name' => 'required|string|max:45',
            'name' => 'required|string|max:45',
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $next($request);
    }
}
