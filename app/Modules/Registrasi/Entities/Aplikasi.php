<?php

namespace Modules\Registrasi\Entities;

class Aplikasi extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_reg_aplikasi';

    /**
     * @var array
     */
    protected $fillable = [
        'idaplikasi', 'nama', 'keterangan', 'alamat', 'ada_limit', 'akses', 'muncul_di_uim', 'otentikasi_user',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * @param mixed $value
     * @return void
     */
    public function setKeteranganAttribute($value)
    {
        $this->attributes['keterangan'] = is_null($value) ? '-' : $value;
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function setAlamatAttribute($value)
    {
        $this->attributes['alamat'] = is_null($value) ? '-' : $value;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fungsi()
    {
        return $this->hasMany(Fungsi::class, 'reg_aplikasi_id');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return int
     */
    public function scopeSequenceIdAplikasi($query)
    {
        return ($query->select('idaplikasi')->latest('idaplikasi')->first())->idaplikasi + 1;
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
        
        if ($request->otentikasi_user) {
            $query->where('otentikasi_user', $request->otentikasi_user);
        }
        
        if (in_array($request->sinkronisasi, ['0', '1'])) {
            $query->where('sinkronisasi', $request->sinkronisasi);
        }

        $q = $query->select(array_merge($this->fillable, ['id', 'keterangan', 'alamat', 'sinkronisasi', 'created_at', 'updated_at']))
            ->orderBy('idaplikasi')
            ->orderBy('nama');

        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }
}