<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthenticationKeyMiddleware
{
    protected $API_KEY;
    public function __construct()
    {
        $this->API_KEY = env("APP_KEY");
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $api_key = $request->headers->get("API_KEY");
        if ($api_key != $this->API_KEY) {
            throw new UnauthorizedHttpException('Invalid API key');
        }

        return $next($request);
    }
}
