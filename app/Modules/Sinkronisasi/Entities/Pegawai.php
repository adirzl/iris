<?php

namespace Modules\Sinkronisasi\Entities;

class Pegawai extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_sync_pegawai';

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
        if ($request->userid) {
            $query->where('userid', $request->userid);
        }

        if ($request->nama) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        if (in_array($request->sinkronisasi, ['0', '1'])) {
            $query->where('sinkronisasi', $request->sinkronisasi);
        }
        
        if ($request->tanggal) {
            $query->whereDate('tgl_sinkronisasi', $request->tanggal);
        } else {
            $query->whereDate('tgl_sinkronisasi', now());
        }

        $q = $query->orderBy('sinkronisasi')
            ->orderByDesc('tgl_sinkronisasi')
            ->orderBy('userid');

        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }
}