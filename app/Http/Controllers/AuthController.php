<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\ActivityLog;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN VIEW
    |--------------------------------------------------------------------------
    */
    public function showLogin()
    {
        return Auth::check()
            ? redirect()->route('dashboard')
            : view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN PROCESS (WITH APPROVAL CHECK)
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|min:6',
    ]);

    $credentials = $request->only('email', 'password');
    $remember    = $request->boolean('remember');

    if (Auth::attempt($credentials, $remember)) {

        $user = Auth::user();

        // ❌ BLOCK UNAPPROVED USERS
        if ($user->status !== 'approved') {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Your account is waiting for admin approval.']);
        }

        $request->session()->regenerate();

        ActivityLog::create([
            'user_id'     => $user->id,
            'action'      => 'login',
            'description' => 'User logged in from ' . $request->ip(),
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('dashboard');
    }

    return back()->withErrors([
        'email' => 'Invalid credentials. Please try again.'
    ]);
}
    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'logout',
            'description'=> 'User logged out',
            'ip_address' => $request->ip()
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out.');
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER VIEW
    |--------------------------------------------------------------------------
    */
    public function showRegister()
    {
        return view('auth.register');
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER PROCESS (PENDING BY DEFAULT)
    |--------------------------------------------------------------------------
    */
    public function register(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'status'   => 'pending', // 👈 IMPORTANT
    ]);

    return redirect()->route('login')
        ->with('success', 'Account created. Wait for admin approval.');
}


    /*
    |--------------------------------------------------------------------------
    | FORGOT PASSWORD VIEW
    |--------------------------------------------------------------------------
    */
    public function showForgot()
    {
        return view('auth.forgot-password');
    }

    /*
    |--------------------------------------------------------------------------
    | SEND RESET LINK
    |--------------------------------------------------------------------------
    */
    public function sendReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Reset link sent!')
            : back()->withErrors(['email' => 'Unable to send reset link.']);
    }
}