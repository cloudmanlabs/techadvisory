<?php

namespace App\Http\Middleware;

use App\Project;
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
        if ($request->project && $request->project->client_id != auth()->user()->id) {
            abort(404);
        }
        if ($request->project_id) {
            $project = Project::find($request->project_id);
            if ($project == null) {
                Log::debug('Project doesn\'t exist');
                abort(404);
            }
            if ($project->client_id != auth()->user()->id) {
                abort(404);
            }
        }

        return $next($request);
    }
}
