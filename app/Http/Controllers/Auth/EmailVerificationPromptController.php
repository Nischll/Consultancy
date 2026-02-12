<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        if ($request->user()->hasVerifiedEmail()) {
            $user = $request->user();
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
        return view('auth.verify-email');
    }
}
