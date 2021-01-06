<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\Activitylog\Contracts\Activity;

class LogVerifiedUser
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Verified $event)
    {
        $user = \Modules\User\Entities\User::where('email', $event->credentials['email'])->first();

        activity()
            ->performedOn($user)
            ->causedBy($user->id)
            ->tap(function (Activity $activity) {
                $activity->ip_address = request()->getClientIp();
                $activity->user_agent = request()->userAgent();
                $activity->fulluri = request()->fullUrl();
            })
            ->log($user->username . ' logged in successfully.');
    }
}
