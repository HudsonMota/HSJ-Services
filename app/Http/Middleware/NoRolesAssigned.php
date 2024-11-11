<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class NoRolesAssigned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        foreach (auth()->user()->roles as $role) {
            if (Auth::check() && (($role->name == "SUPER ADM") || ($role->name == "ADM") || ($role->name == "MANAGER") || ($role->name == "USER REQUEST") || ($role->name == "PAD"))) {
                return redirect(RouteServiceProvider::HOME);
            }   
        }
        return redirect('/accessdenied');
    }
}
