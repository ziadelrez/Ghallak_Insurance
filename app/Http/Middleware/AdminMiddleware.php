<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
//        if (Auth::user()->types->role == 'المشرف العام')
//        {
//            return $next($request);
//        }
//        elseif (Auth::user()->types->role == 'المدير')
//        {
//            return $next($request);
//        }
//        elseif (Auth::user()->types->role == 'مستخدم عادي')
//            {
//            return redirect('/home')->with('status','You Are Not Allowed To Go To Admin Dashboard');
//        }
        return $next($request);

    }
}
