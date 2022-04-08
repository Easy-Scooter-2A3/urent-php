<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Support\Facades\Auth;
 
class Admin
{
    /**
     * Check if the current user is an admin.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $check = Auth::user()->isAdmin == 1;
        return $check ? $next($request) : redirect('/');
    }
}