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
    /** Mostrar login */
    public function create(): View
    {
        return view('auth.login');
    }

    /** Manejar login */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    $rol = Auth::user()->rol;

    if ($rol === 'admin' || $rol === 'vendedor') {
        return redirect()->route('dashboard');
    }

    // Si tiene otro rol no reconocido
    Auth::guard('web')->logout();
    return redirect()->route('login')->with('error', 'No tienes acceso al sistema.');
}
    /** Logout */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}