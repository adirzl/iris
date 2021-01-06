<?php

namespace Modules\HCS\Entities;

class Pegawai extends \Illuminate\Database\Eloquent\Model
{
    /**
     * @var string
     */
    protected $table = 'hcs_pegawai';

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
        return $this->belongsTo(UnitKerja::class, 'kode_unit_kerja', 'kode');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'kode_jabatan', 'kode');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penempatan()
    {
        return $this->belongsTo(UnitKerja::class, 'kode_penempatan', 'kode');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'kode_grade', 'kode');
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
            $query->where('kode_unit_kerja', $request->unit_kerja);
        }

        if ($request->has('status') && !is_null($request->status)) {
            $query->where('status_karyawan', $request->status);
        }

        $q = $query->select(['userid', 'nama', 'nip', 'email', 'hp', 'kode_unit_kerja', 'kode_jabatan', 'kode_penempatan', 'kode_grade', 'status_karyawan'])
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
