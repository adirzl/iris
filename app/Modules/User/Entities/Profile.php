<?php

namespace Modules\User\Entities;

use App\Concerns\TapActivity;

class Profile extends \Illuminate\Database\Eloquent\Model
{
    use TapActivity;

    /**
     * @var string
     */
    protected $table = 'app_profile';

    /**
     * @var bool
     */
    protected $primaryKey = false;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'nama', 'nip', 'hp',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}