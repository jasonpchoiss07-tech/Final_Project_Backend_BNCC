<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== $role) {
            if ($role === 'admin') {
                return redirect()->route('user.katalog')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }
            return redirect()->route('login');
        }

        return $next($request);
    }
}
