<?php

namespace Modules\Kuisioner\Entities;

class Pertanyaan extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_pertanyaan';

    /**
     * @var array
     */
    protected $fillable = [
        'description','created_at','updated_at','status','status_user',
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

    /**
     * @param mixed $value
     * @return void
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = is_null($value) ? '-' : $value;
    }

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
        if ($request->description) {
            $query->where('description', 'like', '%' . $request->description . '%');
        }
        
        if (in_array($request->status, ['1', '2'])) {
            $query->where('status', $request->status);
        }

        if (in_array($request->status_user, ['1', '2'])) {
            $query->where('status_user', $request->status_user);
        }

        $q = $query->select(array_merge($this->fillable, ['id','description','created_at','updated_at','status','status_user']))
            ->orderBy('status', 'ASC')->orderBy('status_user', 'ASC');

        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }

    public function detail_pertanyaan()
    {
        return $this->hasMany(PertanyaanDetail::class,'id_induk','id');
    }
}