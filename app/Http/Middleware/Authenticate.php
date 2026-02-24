<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // For API requests, return null (no redirect) which triggers a 401 response
        if ($request->expectsJson()) {
            return null;
        }

        // For web requests, redirect to login
        return route('login');
    }

    /**
     * Handle an unauthenticated user.
     */
    protected function unauthenticated($request, array $guards)
    {
        // For API requests, throw an exception that returns JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            throw new AuthenticationException('Unauthorized');
        }

        parent::unauthenticated($request, $guards);
    }
}
