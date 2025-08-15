<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Attempt to authenticate the user using the JWT token
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            // If authentication fails, return a JSON response with an error
            // Added debugging to show the specific error message
            return response()->json(
                [
                    'status' => false,
                    'status_code' => 401,
                    'message' => 'Unauthorized. Please Login',
                    'error' => $e->getMessage() // This will show you the exact reason for the failure
                ],
                401
            );
        }

        // If authentication is successful, continue to the next middleware or controller
        return $next($request);
    }
}
