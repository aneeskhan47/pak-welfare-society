<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LastActivity
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // The user is logged in...
            $user = Auth::user();
            $user->last_active_at = date('Y-m-d H:i:s');
            $user->save();
        }

        return $next($request);
    }
}
