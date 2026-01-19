<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            abort(403);
        }

        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Kamu tidak punya akses');
            Auth::logout();

            // Hancurkan session
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirect ke login dengan pesan
            return redirect()->route('login')
                ->withErrors([
                    'role' => 'Akses ditolak. Kamu telah logout.',
                ]);
        }

        return $next($request);
    }

}
