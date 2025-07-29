<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminOrStaff
{
    public function handle(Request $request, Closure $next)
    {
        $user = session('user');

        if (!$user || !in_array($user->role, [1, 2])) {
            return redirect('/');
        }

        return $next($request);
    }
}
