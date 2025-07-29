<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming login request and redirect by role.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    $user = Auth::user();

    // ✅ Role-based redirection with flash message
    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!'),
        'employer' => redirect()->route('employer.dashboard')->with('success', 'Welcome back, Employer!'),
        'seeker' => redirect()->route('seeker.dashboard')->with('success', 'Welcome back!'),
        default => redirect()->route('dashboard')->with('success', 'Logged in!'),
    };
}


    /**
     * Handle logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
