<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $permissionOrRole): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Super Admin gets access to everything
        if ($user->hasRole('super-admin')) {
            return $next($request);
        }

        // Check if the user has the specified permission or role
        if ($user->hasPermission($permissionOrRole) || $user->hasRole($permissionOrRole)) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
