<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class MiddlewareShow
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info("hola");
        $identifier = $request->route('identifier');
        $customer = Customer::where('email', $identifier)
            ->orWhere('dni', $identifier)
            ->first();
       
        if (!$customer) {
            throw ValidationException::withMessages(["Customer no Existe"]);
        }
        if ($customer->status != "A") {
            throw ValidationException::withMessages(["El usuario debe estar Activo"]);
        }
        if ($customer->email === $identifier) {
            $foundBy = 'email';
        } elseif ($customer->dni === $identifier) {
            $foundBy = 'dni';
        }

        $request->attributes->add(['foundBy' => $foundBy]);

        return $next($request);
    }
}
