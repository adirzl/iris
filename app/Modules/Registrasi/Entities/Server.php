<?php

namespace Modules\Registrasi\Entities;

class Server extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_reg_server';

    /**
     * @var array
     */
    protected $fillable = [
        'ip_address', 'nama', 'environment', 'blacklist', 'koneksi',
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
        if ($request->ip_address) {
            $query->where('ip_address', 'like', '%' . $request->ip_address . '%');
        }

        if ($request->nama) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }
        
        if ($request->environment) {
            $query->where('environment', $request->environment);
        }
        
        if ($request->koneksi) {
            $query->where('koneksi', $request->koneksi);
        }

        $q = $query->select(array_merge($this->fillable, ['id', 'hash_key', 'created_at', 'updated_at']))
            ->orderBy('ip_address')
            ->orderBy('nama');

        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }
}