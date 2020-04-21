<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class CheckClientOwnsProject
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
        if ($request->project->client_id != auth()->user()->id) {
            Log::debug('Client doesnt own this project');
            abort(404);
        }

        return $next($request);
    }
}
