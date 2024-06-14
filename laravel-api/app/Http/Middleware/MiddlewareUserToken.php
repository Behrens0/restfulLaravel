<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\Token;
// use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\Facades\Log;

class MiddlewareUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorizationHeader = $request->headers->get('Authorization');
        if (!$authorizationHeader || !preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            throw ValidationException::withMessages(['Authorization' => 'Token is required']);
        }
        $token = $matches[1];
        Log::info('Request Headers: ' . json_encode($request->headers->all()));
        Log::info($authorizationHeader);
        Log::info(json_encode($token));

        $validator = Validator::make(['user-token' => $token], [
            'user-token' => 'required|exists:tokens,token',
        ]);
        $tokenDetails = Token::where('token', $token)->first();

        $loginTime = $tokenDetails->login_time;
        $email = $tokenDetails->email;
        // $customer = User::where('email', $email)->first();
        Log::info(json_encode($email));
        $loginTime = Carbon::createFromFormat('Y-m-d H:i:s', $loginTime);

        $currentDateTime = Carbon::now();

        if ($currentDateTime->isSameDay($loginTime) && $currentDateTime->diffInMinutes($loginTime) >= 30) {
            Auth::logout();
            Cookie::forget('encrypted_token');
            throw ValidationException::withMessages(["El token ha expirado"]);  
        }
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        return $next($request);
    }
}
