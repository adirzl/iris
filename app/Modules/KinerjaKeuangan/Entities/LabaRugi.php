<?php

namespace Modules\KinerjaKeuangan\Entities;

class LabaRugi extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_realisasi_labarugi';

    /**
     * @var array
     */
    protected $fillable = [
        'id_realisasi_detail',
        'bunga_kredit',
        'bunga_ppbl',
        'pend_provisi',
        'pend_lainya',
        'tabungan',
        'deposito',
        'pin_diterima',
        'sbl',
        'peny_kerugian',
        'peny_ATI',
        'beban_restruk',
        'beban_pemasaran',
        'tenaga_kerja',
        'pendidikan',
        'premi_asuransi',
        'sewa',
        'barangjasa',
        'pemeliharaan_perbaikan',
        'pajak',
        'bebanlainya',
        'labarugi',
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
    // public function setTitleAttribute($value)
    // {
    //     $this->attributes['title'] = is_null($value) ? '-' : $value;
    // }

    /**
     * @param mixed $value
     * @return void
     */
    // public function setDescriptionAttribute($value)
    // {
    //     $this->attributes['description'] = is_null($value) ? '-' : $value;
    // }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function fungsi()
    // {
    //     return $this->hasMany(Fungsi::class, 'reg_aplikasi_id');
    // }

    // /**
    //  * @param \Illuminate\Database\Eloquent\Builder $query
    //  * @return int
    //  */
    // public function scopeSequenceIdAplikasi($query)
    // {
    //     return ($query->select('idaplikasi')->latest('idaplikasi')->first())->idaplikasi + 1;
    // }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @param boolean $export
     * @return \Illuminate\Database\Eloquent\Collection
     */

    // public function targetrbb()
    // {
    //     return $this->hasMany('TargetRBBDetail', 'id_targetrbb');
    // }

    public function scopeFetch($query, $request, $export = false)
    {
        if ($request->tahun) {
            $query->where('tahun', 'like', '%' . $request->tahun . '%');
        }

        if ($request->id_comprof) {
            $query->where('id_comprof', 'like', '%' . $request->id_comprof . '%');
        }

        $q = $query->orderBy('created_at', 'DESC');

        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }
}
