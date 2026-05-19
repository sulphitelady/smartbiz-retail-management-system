<?php
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class SessionTimeout
{
    protected $timeout = 1800; // 30 minutes
 
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = session('last_activity', time());
            if (time() - $lastActivity > $this->timeout) {
                Auth::logout();
                $request->session()->invalidate();
                return redirect()->route('login')->with('error', 'Session expired. Please login again.');
            }
            session(['last_activity' => time()]);
        }
        return $next($request);
    }
}