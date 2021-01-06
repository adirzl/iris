<?php

namespace Modules\User\Http\Middleware;

use Closure;

class UpdateLastActivity
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
        $user = $request->user();

        if (!is_null($user)) {
            $user->last_activity = now();
            $user->save();
        }

        return $next($request);
    }
}
