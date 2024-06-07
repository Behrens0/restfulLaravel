<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use App\Models\Token;


class MiddlewareUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->headers->get('user-token');
        $validator = Validator::make(['user-token' => $token], [
            'user-token' => 'required|exists:tokens, token',
        ]);
        $tokenDetails = Token::where('token', $token)->first();

        $loginTime = $tokenDetails->login_time;
        $email = $tokenDetails->email;
        $customer = Customer::where('email', $email)->first();
        if ($customer->status != 'A') {
            throw ValidationException::withMessages(["Usuario denegado"]);
        }

        $loginTime = Carbon::createFromFormat('Y/m/d-h:i:sa', $loginTime);

        $currentDateTime = Carbon::now();

        // Check if it's the same day
        if ($currentDateTime->isSameDay($loginTime) || $currentDateTime->diffInMinutes($loginTime) >= 30) {

            throw ValidationException::withMessages(["El token ha expirado"]);  
        }
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $next($request);
    }
}
