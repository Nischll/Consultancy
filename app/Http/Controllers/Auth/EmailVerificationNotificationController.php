<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        if ($user->hasVerifiedEmail()) {
            switch($user->role_id) {
                case 1: case 2: return redirect()->route('consultancy.dashboard');
                case 3: return redirect()->route('editor.dashboard');
                case 4: return redirect()->route('portal.dashboard');
                case 5: return redirect()->route('employee.dashboard');
                case 6: return redirect()->route('teacher.dashboard');
                case 7: return redirect()->route('hr.dashboard');
                case 8: return redirect()->route('counselor.dashboard');
            }
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
