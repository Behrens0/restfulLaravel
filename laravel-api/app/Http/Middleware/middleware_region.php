<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class middleware_region
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $validator = Validator::make($request->all(), [
            'regionName' => 'required|string|max:90|unique:regions,description',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => [
                    'regionName' => ['The provided region is not valid.'],
                ]
            ], 422);
        }

        return $next($request);
    }
}
