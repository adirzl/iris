<?php

namespace Modules\KinerjaKeuangan\Entities;
// use Modules\KinerjaKeuangan\Entities\RealisasiRBBDetail;

class RealisasiRBB extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_realisasirbb';

    /**
     * @var array
     */
    protected $fillable = [
        'tahun',
        'bulan',
        'id_comprof',
        'status_approval',
        'status_dokumen',
        'ket',
        'status_progres', 
        'created_at',
        'updated_at',
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

    public function realisasirbbDetail()
    {
        return $this->hasMany('RealisasiRBBDetail::class'); 
    }

    public function scopeFetch($query, $request, $export = false)
    {
        if ($request->tahun) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->id_comprof) {
            $query->where('id_comprof', $request->id_comprof);
        }

        $q = $query->orderBy('tahun', 'DESC')->orderBY('bulan', 'ASC');

        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }
}
