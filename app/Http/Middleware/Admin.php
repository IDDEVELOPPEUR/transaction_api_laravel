<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        
        if(Auth::check()){
            if(Auth::user()->role=='admin'){
               return $next($request);
            }
                    
        return redirect('/dashboard')->with('error', 'Accès refusé. Vous devez être Propriétaire de Matériel pour cette action.');
        }
        return redirect('/login')->with('error', 'Accès refusé. Vous devez être Propriétaire de Matériel pour cette action.');

        
    }
}
