<?php

namespace Modules\Kuisioner\Entities;

class Penilaian extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_penilaian';

    /**
     * @var array
     */
    protected $fillable = [
        'user', 'created_at', 'updated_at', 'status_kuisioner', 'periode', 'status', 'modal_inti', 'nama_perusahaan',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @param boolean $export
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFetch($query, $request, $export = false)
    {
        if ($request->periode) {
            $query->where('periode', 'like', '%' . $request->periode . '%');
        }

        if ($request->nama_perusahaan) {
            $query->where('nama_perusahaan', 'like', '%' . $request->nama_perusahaan . '%');
        }

        $q = $query->select(array_merge($this->fillable, ['id', 'user', 'created_at', 'updated_at', 'status_kuisioner', 'periode', 'status', 'modal_inti', 'nama_perusahaan', 'status', 'modal_inti', 'nama_perusahaan']))
            ->orderBy('created_at');

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
        return $this->hasMany(Pertanyaan::class, 'id_pertanyaan', 'id');
    }

    public function get_company_name()
    {
        return $this->hasOne(\Modules\Kelola\Entities\Comprof::class, 'id', 'nama_perusahaan');
    }
}
