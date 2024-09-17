<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $rolDelUsuario = $user->role ? $user->role->role_name : null;

            if ($rolDelUsuario === $role) {
                return $next($request);
            }
        }

        return redirect()->route('login');
    }
}
