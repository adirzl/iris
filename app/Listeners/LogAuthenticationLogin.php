<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Attempting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\Activitylog\Contracts\Activity;

class LogAuthenticationLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Attempting  $event
     * @return void
     */
    public function handle(Attempting $event)
    {
        $user = \Modules\User\Entities\User::where('username', $event->credentials['username'])->first();

        if (isset($user->id)) {
            activity()
                ->performedOn($user)
                ->causedBy($user->id)
                ->tap(function (Activity $activity) {
                    $activity->ip_address = request()->getClientIp();
                    $activity->user_agent = request()->userAgent();
                    $activity->fulluri = request()->fullUrl();
                })
                ->log($event->credentials['username'] . ' attempting to login.');
        }
    }
}
