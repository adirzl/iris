<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\Activitylog\Contracts\Activity;

class LogSuccessfulLogout
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
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        activity()
            ->performedOn($event->user)
            ->causedBy($event->user->id)
            ->tap(function (Activity $activity) {
                $activity->ip_address = request()->getClientIp();
                $activity->user_agent = request()->userAgent();
                $activity->fulluri = request()->fullUrl();
            })
            ->log($event->user->username . ' logged out successfully.');
    }
}
