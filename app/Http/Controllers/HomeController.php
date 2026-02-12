<?php

namespace App\Http\Controllers;

use App\Models\ConsultancyProfile;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        $loggedInDevices = 0;
        if (Auth::check()) {
            $loggedInDevices = DB::table('sessions')->where("user_id", Auth::user()->id)->count();
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
        }

        if (Auth::check() && !Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        $profile = ConsultancyProfile::where('is_active', true)->first();
        
        // Get theme from session, default to 'default'
        $theme = session('home_theme', 'default');

        return view('home', compact('loggedInDevices', 'profile', 'theme'));
    }

    public function switchTheme(Request $request)
    {
        // Ensure only admins can change theme
        if (!Auth::check() || (Auth::user()->role_id != 1 && Auth::user()->role_id != 2)) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'theme' => 'required|in:default,dark,modern,classic'
        ]);

        session(['home_theme' => $request->theme]);

        return redirect()->back()->with('success', 'Theme changed successfully!');
    }

}