<?php

namespace Modules\UIM\Entities;

class Pegawai extends \Illuminate\Database\Eloquent\Model
{
    /**
     * @var string
     */
    protected $table = 'uim_pegawai';

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'kode_cabang', 'kode_cabang');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unitKerjaInduk()
    {
        return $this->belongsTo(UnitKerja::class, 'kode_induk', 'kode_cabang');
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

        if ($request->unit_kerja) {
            $query->where('kode_cabang', $request->unit_kerja);
        }

        if ($request->has('status') && !is_null($request->status)) {
            $query->where('status_karyawan', $request->status);
        }

        $q = $query->select([
                'userid', 'nama', 'nip', 'email', 'hp', 'kode_induk', 'kode_cabang', 'kode_jabatan', 'nama_jabatan', 
                'kode_penempatan', 'nama_penempatan', 'kode_grade', 'nama_grade', 'admin_spv_ti', 'hakakses', 'status_karyawan'
            ])
            ->orderBy('nama')
            ->orderBy('userid');

        if (!$export) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }
        
        return $q->get();
    }
}
