<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Define the allowed origins, methods, and headers.
        // For a public API, '*' is fine. For a specific frontend, replace '*' with the URL.
        $allowedOrigins = ['*']; // Example: 'http://localhost:3000'
        $allowedMethods = ['POST', 'GET', 'OPTIONS', 'PUT', 'PATCH', 'DELETE'];
        $allowedHeaders = ['Content-Type', 'X-Requested-With', 'Authorization'];

        $response = $next($request);

        // This is a crucial part for handling CORS.
        // We set the headers on the response object.
        $response->headers->set('Access-Control-Allow-Origin', implode(', ', $allowedOrigins));
        $response->headers->set('Access-Control-Allow-Methods', implode(', ', $allowedMethods));
        $response->headers->set('Access-Control-Allow-Headers', implode(', ', $allowedHeaders));
        $response->headers->set('Access-Control-Allow-Credentials', 'true');

        // Handle preflight requests (OPTIONS method)
        // If the request method is OPTIONS, we return the response immediately with the CORS headers.
        if ($request->isMethod('OPTIONS')) {
            return $response;
        }

        // For other requests, we continue with the response.
        // This allows the request to proceed with the CORS headers set.
        // $response->headers->set('Vary', 'Origin, Access-Control-Request-Method, Access-Control-Request-Headers');

        return $response;
    }
}
