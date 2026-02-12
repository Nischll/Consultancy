<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                
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
                
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
