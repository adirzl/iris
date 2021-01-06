<?php

namespace App\Entities;

class Configuration extends \Illuminate\Database\Eloquent\Model
{
    /**
     * @var string
     */
    protected $table = 'mst_configuration';

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
