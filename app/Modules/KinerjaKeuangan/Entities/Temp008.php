<?php

namespace Modules\KinerjaKeuangan\Entities;

class Temp008 extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_008_txt';

    /**
     * @var array
     */
    protected $fillable = [
        'id_realisasi_detail',
        'flag_detail',
        'sandi_kantor',
        'sandi_pos',
        'nilai_rasio',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array
     */
    // protected $hidden = [
    //     'id',
    // ];

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

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @param boolean $export
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function scopeAmbil($query, $request, $export = false)
    {
        $q = $query
        ->select('app_008_txt.*', 'app_realisasirbb_detail.*')
        ->join('app_realisasirbb_detail', 'app_008_txt.id_realisasi_detail', '=', 'app_realisasirbb_detail.id')
        ->orderBy('sandi_pos');
        
        return $q->get();
    }

    // public function scopeFetch($query, $request, $export = false)
    // {
    //     if ($request->tahun) {
    //         $query->where('tahun', 'like', '%' . $request->tahun . '%');
    //     }

    //     if ($request->id_comprof) {
    //         $query->where('id_comprof', 'like', '%' . $request->id_comprof . '%');
    //     }

    //     $q = $query->orderBy('created_at', 'DESC');

    //     if ($export === false) {
    //         if ($request->has('per_page')) {
    //             return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
    //         }

    //         return $q->paginate(config('app.display_per_page'));
    //     }

    //     return $q->get();
    // }
}
