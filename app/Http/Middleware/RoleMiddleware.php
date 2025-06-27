<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
        
        if ($user->role === 'author' && !$user->is_approved) {
            abort(403, 'Your author account is awaiting approval.');
        }
        if (auth()->check() && auth()->user()->role === 'admin') {
            abort(403);
            return $next($request);
        }
    
        
    }
}
