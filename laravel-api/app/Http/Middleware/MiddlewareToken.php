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

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class MiddlewareToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = ['errors' => []];
        $responseFlag = false;


        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $response['errors']['email'] = ['The provided credentials do not match our records.'];
            $responseFlag = true;
            return response()->json([
                'errors' => [
                    'email' => ['The provided email does not match our records.'],
                ]
            ], 422);
        }

        if(!Hash::check($request->password, $user->password)) {
            $responseFlag = true;
            $response['errors']['password'] = ['The provided credentials do not match our records.'];
            return response()->json([
                'errors' => [
                    'password' => ['The provided email does not match our records.'],
                ]
            ], 422);
            
        }

        if($responseFlag) {
            return response()->json($response, 422);
        }
        

        return $next($request);
    }
}
