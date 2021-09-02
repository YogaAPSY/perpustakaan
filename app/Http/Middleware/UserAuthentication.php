<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class UserAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $role = null)
    {
        if ($this->auth->guest()) {
            return redirect('/');
        }

        if (auth()->user()->role != 'admin') {
            return redirect('home');
        }

        return $next($request);
    }
}
