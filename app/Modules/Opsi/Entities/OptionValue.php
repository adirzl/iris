<?php

namespace Modules\Opsi\Entities;

class OptionValue extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'mst_option_value';

    /**
     * @var array
     */
    protected $fillable = [
        'option_group_id', 'key', 'value', 'sequence',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
    ];
}