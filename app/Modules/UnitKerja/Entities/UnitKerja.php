<?php

namespace Modules\UnitKerja\Entities;

class UnitKerja extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_unit_kerja';

    /**
     * @var array
     */
    protected $fillable = ['kode','nama','kode_induk','kode_kanwil','nama_kanwil','status'];

    /**
     * @var array
     */
    protected $hidden = [
        'kode',
    ];
    
    protected $primaryKey = 'kode';

    
    protected $keyType = 'string';
    /**
     * @param mixed $value
     * @return void
     */

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @param boolean $export
     * @return \Illuminate\Database\Eloquent\Collection
     */


}