<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Check if user has one of the allowed roles
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Redirect based on user's actual role
        return $this->redirectToRoleDashboard($user->role);
    }

    /**
     * Redirect user to their appropriate dashboard
     */
    private function redirectToRoleDashboard($role)
    {
        return match($role) {
            'admin' => redirect()->route('admin.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
            'kasir online' => redirect()->route('kasir.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
            'kasir offline' => redirect()->route('kasir.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
            default => redirect()->route('customer.catalog')
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
        };
    }
}
