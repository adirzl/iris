<?php

namespace Modules\Log\Entities;

use Carbon\Carbon;

class LogActivity extends \Spatie\Activitylog\Models\Activity
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\Modules\User\Entities\User::class, 'causer_id')
            ->join('app_profile', 'app_user.id', '=', 'app_profile.user_id');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFetch($query, $request)
    {
        if ($request->causer_id)
            $query->where('causer_id', $request->causer_id);

        if (!is_null($request->tgl_awal) && !is_null($request->tgl_akhir)) {
            $tglAwal = Carbon::parse($request->tgl_awal)->format('Y-m-d 00:00:00');
            $tglAkhir = Carbon::parse($request->tgl_akhir)->format('Y-m-d 23:59:59');
            $query->whereBetween('created_at', [$tglAwal, $tglAkhir]);
        }

        if (!is_null($request->tgl_awal) && is_null($request->tgl_akhir)) {
            $query->whereDate('created_at', $request->tgl_awal);
        }

        if (is_null($request->tgl_awal) && !is_null($request->tgl_akhir)) {
            $query->whereDate('created_at', $request->tgl_akhir);
        }

        $q = $query->select([
            'id', 'log_name', 'description', 'causer_id', 'properties', 'ip_address', 'user_agent', 'created_at'
        ])->orderBy('created_at', 'desc');

        if ($request->has('per_page'))
            return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);

        return $q->paginate(config('app.display_per_page'));
    }
}