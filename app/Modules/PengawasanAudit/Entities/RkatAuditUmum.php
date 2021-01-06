<?php

namespace Modules\PengawasanAudit\Entities;

class RkatAuditUmum extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_rkat_umum';

    /**
     * @var array
     */
    protected $fillable = [
        'rkat_audit_id',
        'sequence_umum', 
        'objek_judul_umum',
        'tgl_mulai_umum',
        'tgl_selesai_umum',
        'jml_temuan_umum',
        'jml_tindak_lanjut_umum',
        'keterangan_umum',
    ];

    /**
     * @var array
     */
    protected $hidden = ['id'];

    /**
     * @param mixed $value
     * @return void
     */
    // public function setTitleAttribute($value)
    // {
    //     $this->attributes['title'] = is_null($value) ? '-' : $value;
    // }

    /**
     * @param mixed $value
     * @return void
     */
    // public function setDescriptionAttribute($value)
    // {
    //     $this->attributes['description'] = is_null($value) ? '-' : $value;
    // }

    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function fungsi()
    // {
    //     return $this->hasMany(Fungsi::class, 'reg_aplikasi_id');
    // }

    // /**
    //  * @param \Illuminate\Database\Eloquent\Builder $query
    //  * @return int
    //  */
    // public function scopeSequenceIdAplikasi($query)
    // {
    //     return ($query->select('idaplikasi')->latest('idaplikasi')->first())->idaplikasi + 1;
    // }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @param boolean $export
     * @return \Illuminate\Database\Eloquent\Collection
     */
    // public function scopeFetch($query, $request, $export = false)
    // {
    //     if ($request->title) {
    //         $query->where('ljk', 'like', '%' . $request->title . '%');
    //     }

    //     $q = $query->orderBy('created_at', 'ASC');

    //     if ($export === false) {
    //         if ($request->has('per_page')) {
    //             return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
    //         }

    //         return $q->paginate(config('app.display_per_page'));
    //     }

    //     return $q->get();
    // }
}