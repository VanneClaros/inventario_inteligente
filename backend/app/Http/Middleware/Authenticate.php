<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Redirige al usuario según su rol si no está autenticado.
     */
    protected function redirectTo($request)
{
    if (!$request->expectsJson()) {
        return route('login');
    }
}
        
}