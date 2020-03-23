<?php

namespace App\Http\Middleware;

use Closure;

class CheckVendor
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
        if ( ! $request->user()->isVendor()) {
            return redirect()->route('welcome');
        }

        return $next($request);
    }
}
