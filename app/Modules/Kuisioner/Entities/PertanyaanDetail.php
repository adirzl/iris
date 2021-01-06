<?php

namespace Modules\Kuisioner\Entities;

class PertanyaanDetail extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_pertanyaan_detail';

    /**
     * @var array
     */
    protected $fillable = [
        'id_induk', 'no_pertanyaan', 'pertanyaan',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    // /**
    //  * @param mixed $value
    //  * @return void
    //  */
    // public function setTitleAttribute($value)
    // {
    //     $this->attributes['title'] = is_null($value) ? '-' : $value;
    // }

    // /**
    //  * @param mixed $value
    //  * @return void
    //  */
    // public function setDescriptionAttribute($value)
    // {
    //     $this->attributes['title'] = is_null($value) ? '-' : $value;
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
    public function scopeFetch($query, $request, $export = false)
    {
        $q = $query->select(array_merge($this->fillable, ['id', 'id_induk', 'no_pertanyaan', 'pertanyaan']))
            ->orderBy('no_pertanyaan');

        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }
            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }
}
