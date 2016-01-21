<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class AuthenticateAdmin
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {

                return response('Unauthorized.', 401);
            } else {

                return redirect()->route('admin.login.index');
            }
        } else {
            if ($this->auth->user()->role != User::ROLE_ADMIN) {

                return redirect()->route('admin.login.index')->withMessages('Email or Password is incorrect');
            }

            return $next($request);
        }
    }
}
