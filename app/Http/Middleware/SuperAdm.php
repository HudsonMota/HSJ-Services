<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        foreach (auth()->user()->roles as $role) {
            $permissions = $role->permissions;
            foreach ($permissions as $permission) {
                if (Auth::check() && (($role->name == "SUPER ADM") || ($role->name == "ADM"))) {
                    return $next($request);
                } elseif (Auth::check() && (($permission->name == "Access reports"))) {
                    return $next($request);
                }
            }
        }
        return redirect(RouteServiceProvider::HOME);
    }
}