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
        $request->validate([
            'email' => 'required|string|email|max:120|exists:users,email',

        ]);
        $user = User::where('email', $request->email)->first();
        if(!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'The provided credentials do not match our records.',
            ])->withInput();
        }


        return $next($request);
    }
}
