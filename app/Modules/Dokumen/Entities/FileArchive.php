<?php

namespace Modules\Dokumen\Entities;

class FileArchive extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_filearchive';

    /**
     * @var array
     */
    protected $fillable = [
        'id', 'unitkerja_kode', 'filetype', 'version', 'path','status'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
    ];


    public function scopeFetch($query, $request, $export = false)
    {

        $q = $query->select(array_merge($this->fillable, ['id', 'unitkerja_kode', 'filetype', 'version', 'path','status','created_at','updated_at'
        ]))->wherenull('deleted_at')->orderBy('created_at','desc');

        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }

    public function file_type(){
        return $this->belongsTo(FileType::class, 'filetype');
    }
    public function unitkerja(){
        return $this->hasone('Modules\UnitKerja\Entities\UnitKerja','kode','unitkerja_kode');
    }

}
