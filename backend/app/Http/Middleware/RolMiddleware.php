<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $userRole = strtolower(trim(Auth::user()->rol));
    $allowedRoles = array_map('trim', $roles);

    if (in_array($userRole, $allowedRoles)) {
        return $next($request);
    }

    abort(403, 'Acceso denegado: no tienes el rol requerido.');
}
}