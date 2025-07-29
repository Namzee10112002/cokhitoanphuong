<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUser
{
    public function handle(Request $request, Closure $next)
    {
        $user = session('user');

        if (!$user || $user->role != 0) {
            return redirect('/');
        }

        return $next($request);
    }
}
