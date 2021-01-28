<?php

namespace Modules\Evaluasi\Entities;

use Modules\Dokumen\Entities\FileArchive;
use Modules\UnitKerja\Entities\UnitKerja;
use Modules\User\Entities\User;

class Evaluasidetail extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_evaluasi_detail';

    /**
     * @var array
     */
    protected $fillable = ['id', 'evaluasi_id', 'aspect', 'description', 'created_at'];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    // protected $primaryKey = 'kode';


    protected $keyType = 'string';
    /**
     * @param mixed $value
     * @return void
     */

         /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFetch($query, $request)
    {
        if ($request->user_id) {
            $query->where('user_id', 'like', '%' . $request->user_id . '%');
        }

        $q = $query->select(array_merge($this->fillable, ['id']))
            ->orderBy('created_at');

        if ($request->has('per_page')) {
            return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
        }

        return $q->paginate(config('app.display_per_page'));
    }

    public function unitkerja(){
        return $this->belongsTo(UnitKerja::class, 'unitkerja_kode');
    }


}
