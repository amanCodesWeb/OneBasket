<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request — redirects to admin login if unauthenticated,
     * or returns 403 if the user doesn't have an admin role.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('admin.login');
        }

        $allowed = ['super_admin', 'ops_manager'];
        foreach ($allowed as $role) {
            if ($request->user()->role === $role) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized — insufficient permissions.');
    }
}
