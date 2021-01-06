<?php

namespace Modules\KinerjaKeuangan\Entities;

class LCR extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_realisasi_lcr';

    /**
     * @var array
     */
    protected $fillable = [
        'id_realisasi_detail',
        'rasio_lcr',
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
    // public function scopeAmbil($query, $request, $export = false)
    // {
    //     $q = $query
    //     ->select('app_008_txt.*', 'app_realisasirbb_detail.*')
    //     ->join('app_realisasirbb_detail', 'app_realisasi_rasiopermodalan.id_realisasi_detail', '=', 'app_realisasirbb_detail.id')
    //     ->orderBy('created_at');
        
    //     return $q->get();
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
