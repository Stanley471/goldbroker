<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureKycVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // If user is not logged in, let them pass (auth middleware will handle it)
        if (!$user) {
            return $next($request);
        }

        // Allow admins to pass without KYC
        if ($user->hasRole('admin')) {
            return $next($request);
        }

        // Allow access to KYC routes and gate
        if ($request->routeIs('kyc.*') || $request->routeIs('kyc.gate')) {
            return $next($request);
        }

        // Check KYC status
        if (!$user->isKycVerified()) {
            return redirect()->route('kyc.gate');
        }

        return $next($request);
    }
}
