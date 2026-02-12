<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        if ($user->hasVerifiedEmail()) {
            switch($user->role_id) {
                case 1: case 2: return redirect()->route('consultancy.dashboard')->with('verified', true);
                case 3: return redirect()->route('editor.dashboard')->with('verified', true);
                case 4: return redirect()->route('portal.dashboard')->with('verified', true);
                case 5: return redirect()->route('employee.dashboard')->with('verified', true);
                case 6: return redirect()->route('teacher.dashboard')->with('verified', true);
                case 7: return redirect()->route('hr.dashboard')->with('verified', true);
                case 8: return redirect()->route('counselor.dashboard')->with('verified', true);
            }
            return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        
        switch($user->role_id) {
            case 1: case 2: return redirect()->route('consultancy.dashboard')->with('verified', true);
            case 3: return redirect()->route('editor.dashboard')->with('verified', true);
            case 4: return redirect()->route('portal.dashboard')->with('verified', true);
            case 5: return redirect()->route('employee.dashboard')->with('verified', true);
            case 6: return redirect()->route('teacher.dashboard')->with('verified', true);
            case 7: return redirect()->route('hr.dashboard')->with('verified', true);
            case 8: return redirect()->route('counselor.dashboard')->with('verified', true);
        }
        return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
    }
}
