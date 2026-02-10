<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UpdateUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Only update status for non-admin users
            if ($user instanceof \Illuminate\Database\Eloquent\Model && $user->role !== 'admin') {
                $user->status = 'active';
                $user->last_seen = now(); // optional timestamp
                $user->save();
            }
        }

        return $next($request);
    }
}
