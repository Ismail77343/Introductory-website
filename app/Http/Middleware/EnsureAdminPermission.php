<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('admin.login');
        }

        if (! $user->hasPermission($permission)) {
            if ($request->routeIs('admin.dashboard') || ! $user->hasPermission('dashboard.view')) {
                abort(403, __('admin.permission_denied'));
            }

            return redirect()->route('admin.dashboard')->with('error', __('admin.permission_denied'));
        }

        return $next($request);
    }
}
