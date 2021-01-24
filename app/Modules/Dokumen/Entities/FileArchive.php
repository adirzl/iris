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

        $q = $query->select(array_merge($this->fillable, ['id', 'unitkerja_kode', 'filetype', 'version', 'path','status'
        ]))->orderBy('created_at','desc');

        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }

    public function filetype(){
        return $this->belongsTo(FileType::class, 'filetype_id');
    }

}
