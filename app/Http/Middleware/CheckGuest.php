<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckGuest
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('user')) {
            return redirect('/');
        }

        return $next($request);
    }
}
