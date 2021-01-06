<?php

namespace Modules\API\Entities;

class LogTransaksi extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'api_transaksi';

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFetch($query, $request)
    {
        if (!is_null($request->tgl_awal) && !is_null($request->tgl_akhir))
            $query->whereBetween('tgl_transaksi', [$request->tgl_awal . ' 00:00:00', $request->tgl_akhir . ' 23:59:59']);
        if (!is_null($request->tgl_awal) && is_null($request->tgl_akhir))
            $query->whereDate('tgl_transaksi', $request->tgl_awal);
        if (is_null($request->tgl_awal) && !is_null($request->tgl_akhir))
            $query->whereDate('tgl_transaksi', $request->tgl_akhir);

        $q = $query->select([
            'id', 'tgl_transaksi', 'ipaddress', 'jobtype', 'jobname', 'reqdata', 'resdata', 'status',
        ])->orderByDesc('tgl_transaksi');

        if ($request->has('per_page'))
            return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);

        return $q->paginate(config('app.display_per_page'));
    }
}