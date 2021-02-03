<?php

namespace Modules\Dokumen\Entities;
use Illuminate\Support\Facades\DB;

class FileType extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_filetype';

    /**
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'unitkerja_kode', 'status'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        // 'id',
    ];

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @param boolean $export
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFetch($query, $request, $export = false)
    {
        $q = DB::table('app_filetype')
            ->join('app_unit_kerja', 'app_filetype.unitkerja_kode', '=', 'app_unit_kerja.kode')
            ->select(DB::raw('distinct app_filetype.unitkerja_kode'), 'app_unit_kerja.nama')
            ->orderBy('app_unit_kerja.nama');

        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }



}
