<?php

namespace App\Http\Middleware;

use App\Models\Region;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
class MiddlewareCommune
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $validator = Validator::make($request->all(), [
            'communeName' => 'required|string|max:90|unique:communes,description',
            'communeReg' => 'required|integer|exists:regions,id_reg',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => [
                    'communeName' => ['The provided commune is not valid.'],
                ]
            ], 422);
        }

        return $next($request);
        
    }
}
