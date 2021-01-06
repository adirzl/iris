<?php

namespace Modules\KinerjaKeuangan\Entities;

class Temp600 extends \App\Entities\Model
{
    /**
     * @var string
     */
    protected $table = 'app_600_txt';

    /**
     * @var array
     */
    protected $fillable = [
        'id_realisasi_detail',
        'flag_detail', 
        'sandi_kantor', 
        'no_cif', 
        'no_identitas',
        'kode_kelompok_kredit',
        'no_rekening',
        'jenis',
        'status_restrukturisasi',
        'jenis_penggunaan',
        'hub_dengan_bank',
        'sumber_dana_pelunasan',
        'periode_pemb_pokok',
        'periode_pemb_bunga',
        'tanggal_mulai',
        'tanggal_jatuh_tempo',
        'angsuran_pokok_pertama',
        'kualitas',
        'tanggal_mulai_macet',
        'jml_hari_tgk_pokok',
        'jml_hari_tgk_bunga',
        'tgk_pokok',
        'tgk_bunga',
        'gol_debitur',
        'sandi_bank',
        'sektor_ekonomi',
        'kategori_usaha',
        'lokasi_penggunaan',
        'suku_bunga',
        'suku_bunga_cara',
        'gol_penjamin',
        'bagian_dijamin',
        'nilai_agun_liquid',
        'nilai_agun_nonliquid',
        'longgar_tarik',
        'plafond_awal',
        'plafond_efektif',
        'baki_debet',
        'provisi_belum_diamor',
        'biaya_trans_blm_diamor',
        'pend_bunga_ditangguhkan',
        'cad_kerugian_restruk',
        'baki_debet_netto',
        'ppap_dibentuk',
        'kelebihan_ppap',
        'pbyad',
        'pend_bunga_dalam_p',
        'status_bmpk',
    ];

    /**
     * @var array
     */
    // protected $hidden = [
    //     'id',
    // ];

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

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return int
     */
    public function scopeAmbil($query, $request, $export = false)
    {
        $q = $query
        ->select('app_600_txt.*', 'app_realisasirbb_detail.*')
        ->join('app_realisasirbb_detail', 'app_600_txt.id_realisasi_detail', '=', 'app_realisasirbb_detail.id')
        ->orderBy('sandi_kantor');
        
        return $q->get();
    }

    // public function scopeFetch($query, $request, $export = false)
    // {
    //     if ($request->tahun) {
    //         $query->where('tahun', 'like', '%' . $request->tahun . '%');
    //     }

    //     if ($request->id_comprof) {
    //         $query->where('id_comprof', 'like', '%' . $request->id_comprof . '%');
    //     }

    //     $q = $query->orderBy('created_at', 'DESC');

    //     if ($export === false) {
    //         if ($request->has('per_page')) {
    //             return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
    //         }

    //         return $q->paginate(config('app.display_per_page'));
    //     }

    //     return $q->get();
    // }
}
