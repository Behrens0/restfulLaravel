<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class logRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $log = [
            'URI' => $request->getUri(),
            'METHOD' => $request->getMethod(),
            'REQUEST_BODY' => $request->all(),
            'IP_address'=> $request->getClientIp(),
        ];
        Log::info(json_encode($log));

        $response = $next($request);

        if (app()->environment('local')) {
            $log2 = [
                'STATUS_CODE' => $response->getStatusCode(),
                'CONTENT' => $response->getContent(),
                'Protocol_VERSION' => $response->getProtocolVersion(),
                'IP_address'=> $request->getClientIp(),
            ];
            Log::info(json_encode($log2));
            
        }
        

        return $response;
    }
}
