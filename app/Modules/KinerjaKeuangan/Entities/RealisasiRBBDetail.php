<?php

namespace Modules\KinerjaKeuangan\Entities;
// use Modules\KinerjaKeuangan\Entities\RealisasiRBB;

class RealisasiRBBDetail extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_realisasirbb_detail';

    /**
     * @var array
     */
    protected $fillable = [
        'kategori_keuangan',
        'id_realisasirbb',
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

    public function realisasirbb()
    {
        return $this->belongsTo('RealisasiRBB::class');
    }

    public function scopeFetch($query, $request, $export = false)
    {
        // if ($request->kategori_keuangan) {
        //     $query->where('kategori_keuangan', 'like', '%' . $request->tahun . '%');
        // }

        // if ($request->id_comprof) {
        //     $query->where('id_comprof', 'like', '%' . $request->id_comprof . '%');
        // }

        $q = $query->orderBy('created_at', 'ASC');

        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }
}
