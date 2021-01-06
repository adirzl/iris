<?php

namespace Modules\Kelola\Entities;

class Laporan extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_laporan';

    /**
     * @var array
     */
    protected $fillable = [
        'periode', 'tahun', 'title', 'description', 'image', 'file', 'created_at', 'updated_at', 'status', 'status_progres', 'company_name',
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
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = is_null($value) ? '-' : $value;
    }

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
        if ($request->company_name) {
            $query->where('company_name', 'like', '%' . $request->company_name . '%');
        }

        if ($request->user) {
            $query->where('user', 'ilike', '%' . $request->user . '%');
        }

        if (in_array($request->status, ['1', '2'])) {
            $query->where('status', $request->status);
        }

        $q = $query->select(array_merge($this->fillable, ['id', 'periode', 'tahun', 'title', 'description', 'image', 'file', 'created_at', 'updated_at', 'status', 'status_progres', 'company_name']))
            ->orderBy('created_at', 'DESC');

        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }

    public function get_company_name()
    {
        return $this->hasOne(Comprof::class, 'id', 'company_name');
    }
}
