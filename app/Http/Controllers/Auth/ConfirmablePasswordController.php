<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request): RedirectResponse
    {
        if (
            !Auth::guard('web')->validate([
                'email' => $request->user()->email,
                'password' => $request->password,
            ])
        ) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());
        $user = Auth::user();
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
}
