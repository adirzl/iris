<?php

namespace Modules\UIM\Entities;

class UnitKerja extends \Illuminate\Database\Eloquent\Model
{
    /**
     * @var string
     */
    protected $table = 'uim_unit_kerja';

    /**
     * @var boolean
     */
    protected $primaryKey = false;

    /**
     * @var boolean
     */
    public $incrementing = false;

    /**
     * @var boolean
     */
    public $timestamps = false;

    /**
     * @param mixed $value
     * @return string
     */
    public function getStatusAttribute($value)
    {
        return $value === '-' ? $value : config('options.status')[$value];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @param boolean $export
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFetch($query, $request, $export = false)
    {
        if ($request->nama) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        $q = $query->select(['kode_cabang', 'nama_cabang', 'nama_induk', 'nama_kanwil', 'kode_hc', 'alamat', 'kota', 'status'])
            ->orderBy('kode_cabang');

        if (!$export) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }
        
        return $q->get();
    }
}
