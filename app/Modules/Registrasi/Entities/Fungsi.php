<?php

namespace Modules\Registrasi\Entities;

class Fungsi extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_reg_aplikasi_fungsi';

    /**
     * @var array
     */
    protected $fillable = [
        'reg_aplikasi_id', 'nama', 'menu', 'status', 'limit_debit', 'limit_kredit', 'spv', 'akses1', 'akses2',
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
    public function setMenuAttribute($value)
    {
        $this->attributes['menu'] = is_null($value) ? '-' : $value;
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function setAkses2Attribute($value)
    {
        $this->attributes['akses2'] = is_null($value) ? '-' : $value;
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function setLimitDebitAttribute($value)
    {
        $this->attributes['limit_debit'] = str_replace(',', '', $value);
    }

    /**
     * @param mixed $value
     * @return void
     */
    public function setLimitKreditAttribute($value)
    {
        $this->attributes['limit_kredit'] = str_replace(',', '', $value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aplikasi()
    {
        return $this->belongsTo(Aplikasi::class, 'reg_aplikasi_id');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @param boolean $export
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFetch($query, $request, $export = false)
    {
        if ($request->aplikasi) {
            $query->where('reg_aplikasi_id', $request->aplikasi);
        }

        if ($request->nama) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        if (in_array($request->sinkronisasi, ['0', '1'])) {
            $query->where('sinkronisasi', $request->sinkronisasi);
        }

        $q = $query->select(array_merge($this->fillable, ['id', 'idfungsi', 'sinkronisasi', 'created_at', 'updated_at']))
            ->orderBy('idfungsi')
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