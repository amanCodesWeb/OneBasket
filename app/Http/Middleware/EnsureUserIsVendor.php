<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsVendor
{
    /**
     * Handle an incoming request — redirects to vendor login if unauthenticated,
     * or returns 403 if the user doesn't have the vendor role.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('vendor.login');
        }

        if ($request->user()->role === 'vendor') {
            return $next($request);
        }

        abort(403, 'Unauthorized — vendor access only.');
    }
}
