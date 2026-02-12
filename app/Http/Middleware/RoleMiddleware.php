<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if user is authenticated
        if (!$request->user()) {
            abort(403, 'Unauthorized');
        }
        
        // Handle roles - Laravel passes role:1,2 as separate arguments ['1', '2']
        // But also handle case where it might be passed as single string "1,2"
        $allowedRoles = [];
        foreach ($roles as $role) {
            // If role contains comma, split it (handles case where Laravel passes "1,2" as single string)
            if (strpos($role, ',') !== false) {
                $splitRoles = array_map('trim', explode(',', $role));
                foreach ($splitRoles as $splitRole) {
                    $allowedRoles[] = (int) $splitRole;
                }
            } else {
                $allowedRoles[] = (int) trim($role);
            }
        }
        
        // Remove duplicates and re-index array
        $allowedRoles = array_values(array_unique($allowedRoles));
        
        $userRoleId = (int) $request->user()->role_id;
        
        if (!in_array($userRoleId, $allowedRoles, true)) {
            abort(403, 'Unauthorized. Your role ID: ' . $userRoleId . ', Allowed roles: ' . implode(', ', $allowedRoles));
        }
        return $next($request);
    }
}
