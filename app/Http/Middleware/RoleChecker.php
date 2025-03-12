<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        //CHECK ROLE OF USER ROLE WAS NOT EQUAL TO THE SPECIFIC USER THEN REDIRECT TO LOGIN
        if(Auth::user()->role != $role){
            return redirect()->route('logout');
        }

        // IF OKAY THEN PROCEED TO NEXT REQUEST
        return $next($request);
    }
}
