<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();

        // 👑 ADMIN HAS FULL ACCESS ALWAYS
        if ($user->hasRole('admin')) {
            return $next($request);
        }

        // ✅ CHECK OTHER ROLES (manager, staff)
        if ($user->hasAnyRole($roles)) {
            return $next($request);
        }

        abort(403, 'Access denied');
    }
}