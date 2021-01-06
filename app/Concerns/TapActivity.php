<?php

namespace App\Concerns;

use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

trait TapActivity
{
    use LogsActivity;

    /**
     * @param Activity $activity
     * @param string $eventName
     */
    public function tapActivity(Activity $activity, string $eventName): void
    {
        if (request()->userAgent() == 'Symfony') {
            $activity->log_name = 'system';
        }

        $activity->ip_address = request()->getClientIp();
        $activity->fulluri = request()->fullUrl();
        $activity->user_agent = request()->userAgent();
    }
}