<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DetectClientSubdomain
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();
        $parts = explode('.', $host);

        if (count($parts) >= 2) {
            $subdomain = $parts[0];

            // Skip main domains
            if (!in_array($subdomain, ['www', 'localhost', '127', '0'])) {

                // Find the user with this subdomain
                $user = \App\Models\User::where('ervop_url', $subdomain)->first();

                if (!$user) {
                    // Return a custom Blade view instead of abort()
                    return response()->view('errors.404', [
                        'subdomain' => $subdomain,
                        'message' => 'The client website "' . $subdomain . '" does not exist in our system.',
                    ], 404);
                }


                // Share globally to get the user and userid (client)
                app()->instance('client_user', $user);
                app()->instance('client_user_id', $user->id);

                view()->share('client_user', $user);

                // Store user data for later
                session([
                    'client_username' => $subdomain,
                    'client_data' => $user,
                ]);

                $request->attributes->set('client_username', $subdomain);
                $request->attributes->set('client_data', $user);
            }
        }

        return $next($request);
    }
}
