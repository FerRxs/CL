<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        if ($user->rol !== 'Administrador' && $user->rol !== 'Empleado') {
            return redirect('home')->with('error', 'No tienes permisos para acceder a esta sección');
        }

        return $next($request);
    }
}
