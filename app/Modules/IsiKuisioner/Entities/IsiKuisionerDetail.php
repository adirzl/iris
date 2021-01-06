<?php

namespace Modules\IsiKuisioner\Entities;

class IsiKuisionerDetail extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_penilaian_detail';

    /**
     * @var array
     */
    protected $fillable = [
        'id_induk',
        'id_pertanyaan',
        'id_pertanyaan_detail',
        'jawaban',
        'file',
        'description',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    protected $timestamp = true;

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

        $q = $query->select(array_merge($this->fillable, ['id', 'id_induk', 'id_pertanyaan', 'id_pertanyaan_detail', 'jawaban', 'file', 'description', 'created_at', 'updated_at']))
            ->orderBy('user');

        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }

    public function relation_penilaian()
    {
        return $this->hasmany(PertanyaanDetail::class, 'id_pertanyaan_detail', 'id');
    }
}
