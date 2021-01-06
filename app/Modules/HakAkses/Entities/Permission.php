<?php

namespace Modules\HakAkses\Entities;

use App\Concerns\TapActivity;

class Permission extends \Spatie\Permission\Models\Permission
{
    use TapActivity;

    /**
     * @var bool
     */
    protected static $logFillable = true;

    /**
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return get_class() . ' ' . json_encode($this->attributesToArray()) . ' ' . $eventName . '.';
    }
}