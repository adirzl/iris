<?php

namespace Modules\KinerjaKeuangan\Entities;

class TargetRBBDetail2 extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_targetrbblabarugi_detail';

    /**
     * @var array
     */
    protected $fillable = [
        'bunga_kredit',
        'bunga_ppbl',
        'pendapatan_provinsi',
        'pendapatan_lainnya',
        'tabungan',
        'deposito',
        'pinjaman_diterima',
        'penyisihan_kerugian',
        'penyusutan_ati',
        'beban_restrukturisasi',
        'beban_pemasaran',
        'tenaga_kerja',
        'pendidikan',
        'premi_asuransi',
        'sewa',
        'barang_dan_jasa',
        'pemeliharaan_perbaikan',
        'pajak',
        'beban_lainnya',
        'laba_rugi',
        'created_at',
        'updated_at',
        'id_targetrbb',
        'periode',
        'simpanan_banklain',
    ];

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
