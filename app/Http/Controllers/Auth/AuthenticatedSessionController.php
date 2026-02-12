<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $profile = \App\Models\ConsultancyProfile::where('is_active', true)->first();
        return view('auth.login', compact('profile'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        // Count active sessions for this user
        $activeSessions = \DB::table('sessions')
            ->where('user_id', $user->id)
            ->get();

        // If already 2 or more devices are logged in, block login
        if ($activeSessions->count() >= 2) {
            Auth::logout(); // logout immediately
            return back()->withErrors([
                'email' => 'Login limit reached. You are already logged in on 2 devices.',
            ]);
        }

        // Proceed to login and create session
        $request->session()->regenerate();

        // Redirect based on role
        switch($user->role_id) {
            case 1: // Super Admin
            case 2: // Admin
                return redirect()->route('consultancy.dashboard');
            case 3: // Editor
                return redirect()->route('editor.dashboard');
            case 4: // Student
                return redirect()->route('portal.dashboard');
            case 5: // Employee
                return redirect()->route('employee.dashboard');
            case 6: // Teacher
                return redirect()->route('teacher.dashboard');
            case 7: // HR
                return redirect()->route('hr.dashboard');
            case 8: // Counselor
                return redirect()->route('counselor.dashboard');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
