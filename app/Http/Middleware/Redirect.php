<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Redirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->Students->status == 1) {
            return redirect('/take-exams');
        }
        if(auth()->user()->Students->status == 2) {
            return redirect('/post-take-exams');
        }
        return $next($request);
    }
}
