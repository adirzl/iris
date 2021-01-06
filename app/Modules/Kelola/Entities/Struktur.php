<?php

namespace Modules\Kelola\Entities;

class Struktur extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_struktur';

    /**
     * @var string
     */
    protected $primaryKey = 'key';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var bool
     */
    public $timestamps = false;
}
