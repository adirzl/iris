<?php

namespace Modules\HCS\Entities;

class Jabatan extends \Illuminate\Database\Eloquent\Model
{
    /**
     * @var string
     */
    protected $table = 'hcs_jabatan';

    /**
     * @var boolean
     */
    protected $primaryKey = false;

    /**
     * @var boolean
     */
    public $incrementing = false;

    /**
     * @var boolean
     */
    public $timestamps = false;

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @param boolean $export
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFetch($query, $request, $export = false)
    {
        if ($request->nama) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        if ($request->has('status') && !is_null($request->status)) {
            $query->where('status', $request->status);
        }

        $q = $query->select(['kode', 'nama', 'status'])
            ->orderBy('kode');

        if (!$export) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }
        
        return $q->get();
    }
}
