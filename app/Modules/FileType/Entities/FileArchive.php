<?php

namespace Modules\FileType\Entities;

class FileArchive extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_filearchive';

    /**
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'path', 'unitkerja_kode', 'status'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
    ];
}
