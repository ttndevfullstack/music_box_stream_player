<?php

namespace App\Presentation\Http\Middleware;

use Closure;
use Flugg\Responder\Exceptions\Http\UnauthenticatedException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        throw new UnauthenticatedException();
    }
    
    // public function handle(Request $request, Closure $next) // @phpcs:ignore
    // {
    // dd($request);
    // if ($request->user()?->tokenCan('*')) {
    // return $next($request);
    // }

    // abort_if($request->ajax() || $request->wantsJson(), Response::HTTP_UNAUTHORIZED);

    // return redirect()->guest('/');
    // }
}
