<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsApproved
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            if (Auth::user()->status !== 'approved') {
                Auth::logout();
                return redirect('/login')
                    ->withErrors(['email' => 'Account waiting for admin approval']);
            }
        }

        return $next($request);
    }
}
