<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LastRoute
{
    public function handle(Request $request, Closure $next)
    {
        // Store the current URL in the session
        if ($request->route() && !$request->ajax()) {
            if (url()->current() != session('last_route')) {
                session(['last_route' => url()->current()]);
            }
        }

        return $next($request);
    }
}
