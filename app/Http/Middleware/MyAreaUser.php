<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class MyAreaUser
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
        if(!\Session::has('user_id')){
            return redirect()->route("login");
        }

        return $next($request);
    }
}
