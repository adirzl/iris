<?php

namespace Modules\Dokumen\Entities;

use Modules\RequestFile\Entities\Requestfile;

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
        'id', 'unitkerja_kode', 'filetype_id', 'version','tipe_dokumen','status', 'filename', 'fileext', 'label'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
    ];


    public function scopeFetch($query, $request, $export = false)
    {

        $q = $query->select(array_merge($this->fillable, ['created_at','updated_at'
        ]))->wherenull('deleted_at')->orderBy('created_at','desc');


        if($request->filetype_id){
            if(is_array($request->filetype_id)){
                $q->whereIn('filetype_id', $request->filetype_id);
            }else{
                $q->where('filetype_id', $request->filetype_id);
            }
        }

        if($request->unitkerja_kode){
            $q->where('unitkerja_kode', $request->unitkerja_kode);
        }

        if($request->tipe_dokumen){
            $q->where('tipe_dokumen', $request->tipe_dokumen);
        }

        if($request->status){
            $q->where('status', $request->status);
        }

        if($request->keyword){
            $q->where('label', 'ilike', '%'.$request->keyword.'%');
        }


        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }

    public function file_type(){
        return $this->belongsTo(FileType::class, 'filetype_id');
    }

    public function unitkerja(){
        return $this->hasone('Modules\UnitKerja\Entities\UnitKerja','kode','unitkerja_kode');
    }

    public function last_requestfile(){
        return $this->hasMany(Requestfile::class, 'filearchive_id')->orderBy('created_at', 'desc');
    }

}
