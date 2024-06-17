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
        Log::info("hola");
        if (!$email) {
            throw ValidationException::withMessages(["Customer no Existe"]);
        }
        Log::info("hola");
        $customer = Customer::where('email', $email)->first();

        if (!$customer || $customer->status === 'trash') {
            throw new HttpException(404, 'Registro no existe');
        }

        $request->attributes->add(['customer' => $customer]);
        return $next($request);
    }
}
