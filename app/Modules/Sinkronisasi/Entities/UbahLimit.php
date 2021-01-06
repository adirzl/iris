<?php

namespace Modules\Sinkronisasi\Entities;

class UbahLimit extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_sync_ubah_limit';

    /**
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * @var boolean
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function jabatan()
    {
        return $this->hasOne(\Modules\HCS\Entities\Pegawai::class, 'userid', 'userid')
            ->select(['hcs_pegawai.*', 'hcs_jabatan.nama as jabatan'])
            ->join('hcs_jabatan', 'hcs_pegawai.kode_jabatan', '=', 'hcs_jabatan.kode');
    }

    /**
     * @param mixed $value
     * @return string
     */
    public function getLimitOtoKreditAttribute($value)
    {
        return number_format($value);
    }

    /**
     * @param mixed $value
     * @return string
     */
    public function getLimitOtoDebitAttribute($value)
    {
        return number_format($value);
    }

    /**
     * @param mixed $value
     * @return string
     */
    public function getLimitOtoKreditDefaultAttribute($value)
    {
        return number_format($value);
    }

    /**
     * @param mixed $value
     * @return string
     */
    public function getLimitOtoDebitDefaultAttribute($value)
    {
        return number_format($value);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @param boolean $export
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFetch($query, $request, $export = false)
    {
        if ($request->userid) {
            $query->where('userid', $request->userid);
        }

        if ($request->nama) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        if (in_array($request->sinkronisasi, ['0', '1'])) {
            $query->where('sinkronisasi', $request->sinkronisasi);
        }
        
        if ($request->tanggal) {
            $query->whereDate('tgl_sinkronisasi', $request->tanggal);
        } else {
            $query->whereDate('tgl_sinkronisasi', now()->yesterday());
        }

        $q = $query->orderByDesc('tgl_sinkronisasi')
            ->orderByDesc('sinkronisasi')
            ->orderBy('userid');

        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }
}