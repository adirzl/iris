<?php

namespace Modules\KinerjaKeuangan\Entities;

class TargetRBBDetail1 extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_targetrbbvolperkusaha_detail';

    /**
     * @var array
     */
    protected $fillable = ['total_aset', 'total_aba', 'total_kredit','dana_pihak_ketiga','simpanan_bank_lain','pinjaman_yang_diterima','modal','laba_rugi','created_at','updated_at','id_targetrbb','periode'];

    /**
     * @var array
     */
    protected $hidden = ['id'];

    // public function targettbbdetail()
    // {
    //     return $this->belongsTo('TargetRBB', 'id_targetrbb');
    // }

    public function scopeFetch($query, $request, $export = false)
    {
        if ($request->tahun) {
            $query->where('periode', 'like', '%' . $request->tahun . '%');
        }

        $q = $query->orderBy('created_at', 'DESC');

        if ($export === false) {
            if ($request->has('per_page')) {
                return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
            }

            return $q->paginate(config('app.display_per_page'));
        }

        return $q->get();
    }
}