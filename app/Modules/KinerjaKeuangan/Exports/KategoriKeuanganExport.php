<?php

namespace Modules\KinerjaKeuangan\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\KinerjaKeuangan\Entities\RealisasiRBB;
use Modules\KinerjaKeuangan\Entities\RealisasiRBBDetail;
use Modules\KinerjaKeuangan\Entities\PerkembanganVolumeUsaha;
use Illuminate\Support\Facades\DB;

class KategoriKeuanganExport implements FromView, ShouldAutoSize, WithEvents
{
    use Exportable;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $id;

    /**
     * ExportLaporanPerjanjian constructor.
     * @param \Illuminate\Http\Request $request
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        // dd($this->id);exit;
        $data = RealisasiRBBDetail::findOrFail($this->id);

        if($data->kategori_keuangan == 1){
            $now = DB::table('v_realisasi_perkembangan_volume')->where('id_realisasi_detail', $data->id)->first();
            $last = DB::table('v_realisasi_perkembangan_volume')->where('tahun', $now->tahun - 1)->where('bulan', $now->bulan)->first();
            $target = DB::table('v_target_perkembangan_volume')->where('periode', $now->bulan)->where('id_comprof', $now->id_comprof)->where('tahun', $now->tahun)->first();
            
            $p_aset = (is_null($last)) ? 0 : $now->total_aset - $last->total_aset;
            $p_persen_aset = (is_null($last)) ? 0 : round((float)$p_aset / $last->total_aset * 100);
            $p_aset_penc = (is_null($target)) ? 0 : round((float)$now->total_aset / ($target->total_aset * 1000000) * 100);
            $p_aba = (is_null($last)) ? 0 : $now->total_aba - $last->total_aba;
            $p_persen_aba = (is_null($last)) ? 0 : round((float)$p_aba / $last->total_aba * 100);
            $p_aba_penc = (is_null($target)) ? 0 : round((float)$now->total_aba / ($target->total_aba * 1000000) * 100);
            $p_kredit = (is_null($last)) ? 0 : $now->total_kredit - $last->total_kredit;
            $p_persen_kredit = (is_null($last)) ? 0 : round((float)$p_kredit / $last->total_kredit * 100);
            $p_kredit_penc = (is_null($target)) ? 0 : round((float)$now->total_kredit / ($target->total_kredit * 1000000) * 100);
            $p_dana_pihaktiga = (is_null($last)) ? 0 : $now->dana_pihaktiga - $last->dana_pihaktiga;
            $p_persen_dana_pihaktiga = (is_null($last)) ? 0 : round((float)$p_dana_pihaktiga / $last->dana_pihaktiga * 100);
            $p_dpk_penc = (is_null($target)) ? 0 : round((float)$now->dana_pihaktiga / ($target->dana_pihak_ketiga * 1000000) * 100);
            $p_pinjaman_diterima = (is_null($last)) ? 0 : $now->pinjaman_diterima - $last->pinjaman_diterima;
            $p_persen_pinjaman_diterima = (is_null($last)) ? 0 : round((float)$p_pinjaman_diterima / $last->pinjaman_diterima * 100);
            $p_pindit_penc = (is_null($target)) ? 0 : round((float)$now->pinjaman_diterima / ($target->pinjaman_yang_diterima * 1000000) * 100);
            $p_modal = (is_null($last)) ? 0 : $now->modal - $last->modal;
            $p_persen_modal = (is_null($last)) ? 0 : round((float)$p_modal / $last->modal * 100);
            $p_modal_penc = (is_null($target)) ? 0 : round((float)$now->modal / ($target->modal * 1000000) * 100);
            $p_laba_rugi = (is_null($last)) ? 0 : $now->laba_rugi - $last->laba_rugi;
            $p_persen_laba_rugi = (is_null($last)) ? 0 : round((float)$p_laba_rugi / $last->laba_rugi * 100);
            $p_laba_rugi_penc = (is_null($target)) ? 0 : round((float)$now->laba_rugi / ($target->laba_rugi * 1000000) * 100);
            
            return view('KinerjaKeuangan::realisasirbb.excel.perkembanganvolumeXLS', compact('now', 'last', 'target', 'p_aset', 'p_persen_aset', 'p_aset_penc', 'p_aba', 'p_persen_aba', 'p_kredit', 'p_persen_kredit', 'p_dana_pihaktiga', 'p_persen_dana_pihaktiga', 'p_pinjaman_diterima', 'p_persen_pinjaman_diterima', 'p_modal', 'p_persen_modal', 'p_laba_rugi', 'p_persen_laba_rugi', 'p_aba_penc', 'p_kredit_penc', 'p_dpk_penc', 'p_pindit_penc', 'p_modal_penc', 'p_laba_rugi_penc'));
        
        } 
        if($data->kategori_keuangan == 2){
            $now = DB::table('v_realisasi_labarugi')->where('id_realisasi_detail', $data->id)->first();
            $last = DB::table('v_realisasi_labarugi')->where('tahun', $now->tahun - 1)->where('bulan', $now->bulan)->first();
            $target = DB::table('v_target_labarugi')->where('periode', $now->bulan)->where('id_comprof', $now->id_comprof)->where('tahun', $now->tahun)->first();

            $pendops_realisasi = $now->bunga_kredit + $now->bunga_ppbl + $now->pend_provisi + $now->pend_lainya;
            $pendops_realisasi_last = (is_null($last)) ? 0 : $last->bunga_kredit + $last->bunga_ppbl + $last->pend_provisi + $last->pend_lainya;
            $pendops_realisasi_target = (is_null($target)) ? 0 : round((float)($target->bunga_kredit + $target->bunga_ppbl + $target->pendapatan_provinsi + $target->pendapatan_lainnya) * 1000000);
            $p_pendops = $pendops_realisasi - $pendops_realisasi_last;
            $p_persen_pendops = (is_null($last)) ? 0 : round((float)$p_pendops / $pendops_realisasi_last * 100);
            $p_pendops_penc = (is_null($target)) ? 0 : round((float)$pendops_realisasi / $pendops_realisasi_target * 100);
            $p_bungakredit = (is_null($last)) ? 0 : $now->bunga_kredit - $last->bunga_kredit;
            $p_persen_bungakredit = (is_null($last)) ? 0 : round((float)$p_bungakredit / $last->bunga_kredit * 100);
            $p_bungakredit_penc = (is_null($target)) ? 0 : round((float)$now->bunga_kredit / ($target->bunga_kredit * 1000000) * 100);
            $p_bungappbl = (is_null($last)) ? 0 : $now->bunga_ppbl - $last->bunga_ppbl;
            $p_persen_bungappbl = (is_null($last)) ? 0 : round((float)$p_bungappbl / $last->bunga_ppbl * 100);
            $p_bungappbl_penc = (is_null($target)) ? 0 : round((float)$now->bunga_ppbl / ($target->bunga_ppbl * 1000000) * 100);
            $p_pendprov = (is_null($last)) ? 0 : $now->pend_provisi - $last->pend_provisi;
            $p_persen_pendprov = (is_null($last)) ? 0 : round((float)$p_pendprov / $last->pend_provisi * 100);
            $p_pendprov_penc = (is_null($target)) ? 0 : round((float)$now->pend_provisi / ($target->pendapatan_provinsi * 1000000) * 100);
            $p_pendlainya = (is_null($last)) ? 0 : $now->pend_lainya - $last->pend_lainya;
            $p_persen_pendlainya = (is_null($last)) ? 0 : round((float)$p_pendlainya / $last->pend_lainya * 100);
            $p_pendlainya_penc = (is_null($target)) ? 0 : round((float)$now->pend_lainya / ($target->pendapatan_lainnya * 1000000) * 100);
            $bunga_realisasi = $now->tabungan + $now->deposito + $now->pin_diterima + $now->sbl;
            $bunga_realisasi_last = (is_null($last)) ? 0 : $last->tabungan + $last->deposito + $last->pin_diterima + $last->sbl;
            $bunga_realisasi_target = (is_null($target)) ? 0 : round((float)($target->tabungan + $target->deposito + $target->pinjaman_diterima + $target->simpanan_banklain) * 1000000);
            $bebanops_realisasi = $bunga_realisasi + $now->peny_kerugian + $now->peny_ATI + $now->beban_restruk + $now->beban_pemasaran + $now->tenaga_kerja + $now->pendidikan + $now->premi_asuransi + $now->sewa + $now->barangjasa + $now->pemeliharaan_perbaikan + $now->pajak + $now->bebanlainya;
            $bebanops_realisasi_last = (is_null($last)) ? 0 : $bunga_realisasi_last + $last->peny_kerugian + $last->peny_ATI + $last->beban_restruk + $last->beban_pemasaran + $last->tenaga_kerja + $last->pendidikan + $last->premi_asuransi + $last->sewa + $last->barangjasa + $last->pemeliharaan_perbaikan + $last->pajak + $last->bebanlainya;
            $bebanops_realisasi_target = (is_null($target)) ? 0 : $bunga_realisasi_target + round((float)($target->penyisihan_kerugian + $target->penyusutan_ati + $target->beban_restrukturisasi + $target->beban_pemasaran + $target->tenaga_kerja + $target->pendidikan + $target->premi_asuransi + $target->sewa + $target->barang_dan_jasa + $target->pemeliharaan_perbaikan + $target->pajak + $target->beban_lainnya) * 1000000);
            $p_bebanops = $bebanops_realisasi - $bebanops_realisasi_last;
            $p_persen_bebanops = (is_null($last)) ? 0 : round((float)$p_bebanops / $bebanops_realisasi_last * 100);
            $p_bebanops_penc = (is_null($target)) ? 0 : round((float)$bebanops_realisasi / $bebanops_realisasi_target * 100);
            $p_bunga = $bunga_realisasi - $bunga_realisasi_last;
            $p_persen_bunga = (is_null($last)) ? 0 : round((float)$p_bunga / $bunga_realisasi_last * 100);
            $p_bunga_penc = (is_null($target)) ? 0 : round((float)$bunga_realisasi / $bunga_realisasi_target * 100);
            $p_tabungan = (is_null($last)) ? 0 : $now->tabungan - $last->tabungan;
            $p_persen_tabungan = (is_null($last)) ? 0 : round((float)$p_tabungan / $last->tabungan * 100);
            $p_tabungan_penc = (is_null($target)) ? 0 : round((float)$now->tabungan / ($target->tabungan * 1000000) * 100);
            $p_deposito = (is_null($last)) ? 0 : $now->deposito - $last->deposito;
            $p_persen_deposito = (is_null($last)) ? 0 : round((float)$p_deposito / $last->deposito * 100);
            $p_deposito_penc = (is_null($target)) ? 0 : round((float)$now->deposito / ($target->deposito * 1000000) * 100);
            $p_sbl = (is_null($last)) ? 0 : $now->sbl - $last->sbl;
            $p_persen_sbl = (is_null($last)) ? 0 : round((float)$p_sbl / $last->sbl * 100);
            $p_sbl_penc = (is_null($target)) ? 0 : round((float)$now->sbl / ($target->simpanan_banklain * 1000000) * 100);
            $p_pin_diterima = (is_null($last)) ? 0 : $now->pin_diterima - $last->pin_diterima;
            $p_persen_pin_diterima = (is_null($last)) ? 0 : round((float)$p_pin_diterima / $last->pin_diterima * 100);
            $p_pin_diterima_penc = (is_null($target)) ? 0 : round((float)$now->pin_diterima / ($target->pinjaman_diterima * 1000000) * 100);
            $p_peny_kerugian = (is_null($last)) ? 0 : $now->peny_kerugian - $last->peny_kerugian;
            $p_persen_peny_kerugian = (is_null($last)) ? 0 : round((float)$p_peny_kerugian / $last->peny_kerugian * 100);
            $p_peny_kerugian_penc = (is_null($target)) ? 0 : round((float)$now->peny_kerugian / ($target->penyisihan_kerugian * 1000000) * 100);
            $p_peny_ATI = (is_null($last)) ? 0 : $now->peny_ATI - $last->peny_ATI;
            $p_persen_peny_ATI = (is_null($last)) ? 0 : round((float)$p_peny_ATI / $last->peny_ATI * 100);
            $p_peny_ATI_penc = (is_null($target)) ? 0 : round((float)$now->peny_ATI / ($target->penyusutan_ati * 1000000) * 100);
            $p_tenaga_kerja = (is_null($last)) ? 0 : $now->tenaga_kerja - $last->tenaga_kerja;
            $p_persen_tenaga_kerja = (is_null($last)) ? 0 : round((float)$p_tenaga_kerja / $last->tenaga_kerja * 100);
            $p_tenaga_kerja_penc = (is_null($target)) ? 0 : round((float)$now->tenaga_kerja / ($target->tenaga_kerja * 1000000) * 100);
            $p_pendidikan = (is_null($last)) ? 0 : $now->pendidikan - $last->pendidikan;
            $p_persen_pendidikan = (is_null($last)) ? 0 : round((float)$p_pendidikan / $last->pendidikan * 100);
            $p_pendidikan_penc = (is_null($target)) ? 0 : round((float)$now->pendidikan / ($target->pendidikan * 1000000) * 100);
            $p_premi_asuransi = (is_null($last)) ? 0 : $now->premi_asuransi - $last->premi_asuransi;
            $p_persen_premi_asuransi = (is_null($last)) ? 0 : round((float)$p_premi_asuransi / $last->premi_asuransi * 100);
            $p_premi_asuransi_penc = (is_null($target)) ? 0 : round((float)$now->premi_asuransi / ($target->premi_asuransi * 1000000) * 100);
            $p_sewa = (is_null($last)) ? 0 : $now->sewa - $last->sewa;
            $p_persen_sewa = (is_null($last)) ? 0 : round((float)$p_sewa / $last->sewa * 100);
            $p_sewa_penc = (is_null($target)) ? 0 : round((float)$now->sewa / ($target->sewa * 1000000) * 100);
            $p_pemeliharaan_perbaikan = (is_null($last)) ? 0 : $now->pemeliharaan_perbaikan - $last->pemeliharaan_perbaikan;
            $p_persen_pemeliharaan_perbaikan = (is_null($last)) ? 0 : round((float)$p_pemeliharaan_perbaikan / $last->pemeliharaan_perbaikan * 100);
            $p_pemeliharaan_perbaikan_penc = (is_null($target)) ? 0 : round((float)$now->pemeliharaan_perbaikan / ($target->pemeliharaan_perbaikan * 1000000) * 100);
            $p_barangjasa = (is_null($last)) ? 0 : $now->barangjasa - $last->barangjasa;
            $p_persen_barangjasa = (is_null($last)) ? 0 : round((float)$p_barangjasa / $last->barangjasa * 100);
            $p_barangjasa_penc = (is_null($target)) ? 0 : round((float)$now->barangjasa / ($target->barang_dan_jasa * 1000000) * 100);
            $p_bebanlainya = (is_null($last)) ? 0 : $now->bebanlainya - $last->bebanlainya;
            $p_persen_bebanlainya = (is_null($last)) ? 0 : round((float)$p_bebanlainya / $last->bebanlainya * 100);
            $p_bebanlainya_penc = (is_null($target)) ? 0 : round((float)$now->bebanlainya / ($target->beban_lainnya * 1000000) * 100);
            $p_labarugi = (is_null($last)) ? 0 : $now->labarugi - $last->labarugi;
            $p_persen_labarugi = (is_null($last)) ? 0 : round((float)$p_labarugi / $last->labarugi * 100);
            $p_labarugi_penc = (is_null($target)) ? 0 : round((float)$now->labarugi / ($target->laba_rugi * 1000000) * 100);

        return view('KinerjaKeuangan::realisasirbb.excel.labarugiXLS', compact('now', 'last', 'target', 'pendops_realisasi', 'pendops_realisasi_last', 'pendops_realisasi_target', 'p_pendops', 'p_persen_pendops', 'p_pendops_penc', 'p_bungakredit', 'p_persen_bungakredit', 'p_bungakredit_penc', 'p_bungappbl', 'p_persen_bungappbl', 'p_bungappbl_penc', 'p_pendprov', 'p_persen_pendprov', 'p_pendprov_penc', 'p_pendlainya', 'p_persen_pendlainya', 'p_pendlainya_penc', 'bunga_realisasi', 'bunga_realisasi_last', 'bunga_realisasi_target', 'bebanops_realisasi', 'bebanops_realisasi_last', 'bebanops_realisasi_target', 'p_bebanops', 'p_persen_bebanops', 'p_bebanops_penc', 'p_bunga', 'p_persen_bunga', 'p_bunga_penc', 'p_tabungan', 'p_persen_tabungan', 'p_tabungan_penc', 'p_deposito', 'p_persen_deposito', 'p_deposito_penc', 'p_sbl', 'p_persen_sbl', 'p_sbl_penc', 'p_pin_diterima', 'p_persen_pin_diterima', 'p_pin_diterima_penc', 'p_peny_kerugian', 'p_persen_peny_kerugian', 'p_peny_kerugian_penc', 'p_peny_ATI', 'p_persen_peny_ATI', 'p_peny_ATI_penc', 'p_tenaga_kerja', 'p_persen_tenaga_kerja', 'p_tenaga_kerja_penc', 'p_pendidikan', 'p_persen_pendidikan', 'p_pendidikan_penc', 'p_premi_asuransi', 'p_persen_premi_asuransi', 'p_premi_asuransi_penc', 'p_sewa', 'p_persen_sewa', 'p_sewa_penc', 'p_pemeliharaan_perbaikan', 'p_persen_pemeliharaan_perbaikan', 'p_pemeliharaan_perbaikan_penc', 'p_barangjasa', 'p_persen_barangjasa', 'p_barangjasa_penc', 'p_bebanlainya', 'p_persen_bebanlainya', 'p_bebanlainya_penc', 'p_labarugi', 'p_persen_labarugi', 'p_labarugi_penc'));
        }

        if($data->kategori_keuangan == 3){
            $now = DB::table('v_realisasi_rasiokeuangan')->where('id_realisasi_detail', $data->id)->first();
            $last = DB::table('v_realisasi_rasiokeuangan')->where('tahun', $now->tahun - 1)->where('bulan', $now->bulan)->first();
            
            $p_car = (is_null($last)) ? 0 : $now->car - $last->car;
            $p_npl = (is_null($last)) ? 0 : $now->npl - $last->npl;
            $p_cr = (is_null($last)) ? 0 : $now->cr - $last->cr;
            $p_ldr = (is_null($last)) ? 0 : $now->ldr - $last->ldr;
            $p_roa = (is_null($last)) ? 0 : $now->roa - $last->roa;
            $p_bopo = (is_null($last)) ? 0 : $now->bopo - $last->bopo;
            
            return view('KinerjaKeuangan::realisasirbb.excel.rasiokeuanganiXLS', compact('now', 'last', 'p_car', 'p_npl', 'p_cr', 'p_ldr', 'p_roa', 'p_bopo'));
        }

        if($data->kategori_keuangan == 4){
            $now = DB::table('v_realisasi_rasiopermodalan')->where('id_realisasi_detail', $data->id)->first();
            $last = DB::table('v_realisasi_rasiopermodalan')->where('tahun', $now->tahun - 1)->where('bulan', $now->bulan)->first();
        
                $p_atmr = (is_null($last)) ? 0 : $now->ATMR - $last->ATMR;
                $p_persen_atmr = (is_null($last)) ? 0 : round((float)$p_atmr / $last->ATMR * 100);
                $p_antarbank_aktiva = (is_null($last)) ? 0 : $now->antarbank_aktiva - $last->antarbank_aktiva;
                $p_persen_antarbank_aktiva = (is_null($last)) ? 0 : round((float)$p_antarbank_aktiva / $last->antarbank_aktiva * 100);
                $p_kredit_diberikan = (is_null($last)) ? 0 : $now->kredit_diberikan - $last->kredit_diberikan;
                $p_persen_kredit_diberikan = (is_null($last)) ? 0 : round((float)$p_kredit_diberikan / $last->kredit_diberikan * 100);
                $p_ati =  (is_null($last)) ? 0 : $now->ATI - $last->ATI;
                $p_persen_ati = (is_null($last)) ? 0 : round((float)$p_ati / $last->ATI * 100);
                $p_rupa_aktiva = (is_null($last)) ? 0 : $now->rupa_aktiva - $last->rupa_aktiva;
                $p_persen_rupa_aktiva = (is_null($last)) ? 0 : round((float)$p_rupa_aktiva / $last->rupa_aktiva * 100);
                $p_modal = (is_null($last)) ? 0 : $now->modal - $last->modal;
                $p_persen_modal = (is_null($last)) ? 0 : round((float)$p_modal / $last->modal * 100);
                $p_modal_disetor = (is_null($last)) ? 0 : $now->modal_disetor - $last->modal_disetor;
                $p_persen_modal_disetor = (is_null($last)) ? 0 : round((float)$p_modal_disetor / $last->modal_disetor * 100);
                $p_cadangan_umum = (is_null($last)) ? 0 : $now->cadangan_umum - $last->cadangan_umum;
                $p_persen_cadangan_umum = (is_null($last)) ? 0 : round((float)$p_cadangan_umum / $last->cadangan_umum * 100);
                $p_cadangan_tujuan = (is_null($last)) ? 0 : $now->cadangan_tujuan - $last->cadangan_tujuan;
                $p_persen_cadangan_tujuan = (is_null($last)) ? 0 : round((float)$p_cadangan_tujuan / $last->cadangan_tujuan * 100);
                $p_laba_rugi_thnberjalan = (is_null($last)) ? 0 : $now->laba_rugi_thnberjalan - $last->laba_rugi_thnberjalan;
                $p_persen_laba_rugi_thnberjalan = (is_null($last)) ? 0 : round((float)$p_laba_rugi_thnberjalan / $last->laba_rugi_thnberjalan * 100);
                $p_laba_rugi_thnlalu = (is_null($last)) ? 0 : $now->laba_rugi_thnlalu - $last->laba_rugi_thnlalu;
                $p_persen_laba_rugi_thnlalu = (is_null($last)) ? 0 : round((float)$p_laba_rugi_thnlalu / $last->laba_rugi_thnlalu * 100);
                $p_modal_pelengkap = (is_null($last)) ? 0 : $now->modal_pelengkap - $last->modal_pelengkap;
                $p_persen_modal_pelengkap = (is_null($last)) ? 0 : round((float)$p_modal_pelengkap / $last->modal_pelengkap * 100);
                $p_godwill = (is_null($last)) ? 0 : $now->godwill - $last->godwill;
                $p_persen_godwill = (is_null($last)) ? 0 : round((float)$p_godwill / $last->godwill * 100);
                $p_car = (is_null($last)) ? 0 : $now->CAR - $last->CAR;
                $p_persen_car = (is_null($last)) ? 0 : round((float)$p_car / $last->CAR * 100);

            return view('KinerjaKeuangan::realisasirbb.excel.carXLS', compact('now','last','p_atmr','p_antarbank_aktiva','p_kredit_diberikan','p_ati','p_rupa_aktiva','p_modal','p_modal_disetor','p_cadangan_umum','p_cadangan_tujuan','p_laba_rugi_thnberjalan','p_laba_rugi_thnlalu','p_modal_pelengkap','p_godwill','p_car','p_persen_atmr','p_persen_antarbank_aktiva','p_persen_kredit_diberikan','p_persen_ati','p_persen_rupa_aktiva','p_persen_modal','p_persen_modal_disetor','p_persen_cadangan_umum','p_persen_cadangan_tujuan','p_persen_laba_rugi_thnberjalan','p_persen_laba_rugi_thnlalu','p_persen_modal_pelengkap','p_persen_godwill','p_persen_car'));
        }

        if($data->kategori_keuangan == 5){
            $now = DB::table('v_realisasi_rasionpl')->where('id_realisasi_detail', $data->id)->first();
            $lastyear = DB::table('v_realisasi_rasionpl')->where('tahun', $now->tahun - 1)->where('bulan', $now->bulan)->first();
            $lastmonth = DB::table('v_realisasi_rasionpl')->where('tahun', $now->tahun)->where('bulan', $now->bulan - 1)->where('id_comprof', $now->id_comprof)->first();

                $p_lancar_month = (is_null($lastmonth)) ? 0 : $now->lancar - $lastmonth->lancar;
                $p_lancar_year = (is_null($lastyear)) ? 0 : $now->lancar - $lastyear->lancar;
                $p_persen_lancarmonth = (is_null($lastmonth)) ? 0 : (($now->lancar - $lastmonth->lancar)/$lastmonth->lancar)*100;
                $p_persen_lancaryear = (is_null($lastyear)) ? 0 : (($now->lancar - $lastyear->lancar)/$lastyear->lancar)*100;
                $p_dalamperhatian_month = (is_null($lastmonth)) ? 0 : $now->dalam_perhatian - $lastmonth->dalam_perhatian;
                $p_dalamperhatian_year = (is_null($lastyear)) ? 0 : $now->dalam_perhatian - $lastyear->dalam_perhatian;
                // // $p_persen_dalamperhatianmonth = (($now->dalam_perhatian - $lastmonth->dalam_perhatian)/$lastmonth->dalam_perhatian)*100;
                // // $p_persen_dalamperhatianyear = (($now->dalam_perhatian - $lastyear->dalam_perhatian)/$lastyear->dalam_perhatian)*100;
                $p_kuranglancar_month = (is_null($lastmonth)) ? 0 : $now->kurang_lancar - $lastmonth->kurang_lancar;
                $p_kuranglancar_year = (is_null($lastyear)) ? 0 : $now->kurang_lancar - $lastyear->kurang_lancar;
                $p_persen_kuranglancarmonth = (is_null($lastmonth)) ? 0 : (($now->kurang_lancar - $lastmonth->kurang_lancar)/$lastmonth->kurang_lancar)*100;
                $p_persen_kuranglancaryear =  (is_null($lastyear)) ? 0 : (($now->kurang_lancar - $lastyear->kurang_lancar)/$lastyear->kurang_lancar)*100;
                $p_diragukan_month = (is_null($lastmonth)) ? 0 : $now->diragukan - $lastmonth->diragukan;
                $p_diragukan_year = (is_null($lastyear)) ? 0 : $now->diragukan - $lastyear->diragukan;
                $p_persen_diragukanmonth = (is_null($lastmonth)) ? 0 : (($now->diragukan - $lastmonth->diragukan)/$lastmonth->diragukan)*100;
                $p_persen_diragukanyear = (is_null($lastyear)) ? 0 : (($now->diragukan - $lastyear->diragukan)/$lastyear->diragukan)*100;
                $p_macet_month = (is_null($lastmonth)) ? 0 : $now->macet - $lastmonth->macet;
                $p_macet_year = (is_null($lastyear)) ? 0 : $now->macet - $lastyear->macet;
                $p_persen_macetmonth = (is_null($lastmonth)) ? 0 : (($now->macet - $lastmonth->macet)/$lastmonth->macet)*100;
                $p_persen_macetyear = (is_null($lastyear)) ? 0 : (($now->macet - $lastyear->macet)/$lastyear->macet)*100;
                $total = $now->lancar + $now->dalam_perhatian + $now->kurang_lancar + $now->diragukan + $now->macet;
                $totalastyear = (is_null($lastyear)) ? 0 : $lastyear->lancar + $lastyear->dalam_perhatian + $lastyear->kurang_lancar + $lastyear->diragukan + $lastyear->macet;
                $totalastmonth = (is_null($lastmonth)) ? 0 :$lastmonth->lancar + $lastmonth->dalam_perhatian + $lastmonth->kurang_lancar + $lastmonth->diragukan + $lastmonth->macet;
                $totalnonlancar = $now->kurang_lancar + $now->diragukan + $now->macet;
                $totalnonlancar_lastyear = (is_null($lastyear)) ? 0 : $lastyear->kurang_lancar + $lastyear->diragukan + $lastyear->macet;
                $totalnonlancar_lastmonth = (is_null($lastmonth)) ? 0 : $lastmonth->kurang_lancar + $lastmonth->diragukan + $lastmonth->macet;
                $total_pertumbuhan_month = $p_lancar_month + $p_dalamperhatian_month + $p_kuranglancar_month + $p_diragukan_month + $p_macet_month;
                $total_pertumbuhan_year = $p_lancar_year + $p_dalamperhatian_year + $p_kuranglancar_year + $p_diragukan_year + $p_macet_year;
                $p_persen_totalmonth = (is_null($lastmonth)) ? 0 : (($total - $totalastmonth)/$totalastmonth)*100;
                $p_persen_totalyear = (is_null($lastyear)) ? 0 : (($total - $totalastyear)/$totalastyear)*100;
                $total_nonlancarmonth = $p_kuranglancar_month + $p_diragukan_month + $p_macet_month;
                $total_nonlancaryear = $p_kuranglancar_year + $p_diragukan_year + $p_macet_year;

            return view('KinerjaKeuangan::realisasirbb.excel.rasionplXLS', compact('now', 'lastyear', 'lastmonth', 'total', 'totalastyear', 'totalastmonth', 'totalnonlancar','totalnonlancar_lastyear', 'totalnonlancar_lastmonth', 'p_lancar_month', 'p_lancar_year', 'p_dalamperhatian_month', 'p_dalamperhatian_year', 'p_kuranglancar_month', 'p_kuranglancar_year', 'p_diragukan_month', 'p_diragukan_year', 'p_macet_month', 'p_macet_year', 'total_pertumbuhan_month', 'total_pertumbuhan_year', 'p_persen_lancarmonth', 'p_persen_kuranglancarmonth', 'p_persen_diragukanmonth', 'p_persen_totalmonth', 'p_persen_totalyear', 'p_persen_macetmonth', 'p_persen_lancaryear', 'p_persen_kuranglancaryear', 'p_persen_diragukanyear', 'p_persen_macetyear', 'total_nonlancarmonth', 'total_nonlancaryear'));
        }

        if($data->kategori_keuangan == 6){
            $now = DB::table('v_realisasi_kolekpersektor')->where('id_realisasi_detail', $data->id)->first();

                $jumlah = $now->produktif + $now->konsumtif;
                $p_produktif = ($now->produktif / $jumlah) * 100;
                $p_konsumtif = ($now->konsumtif / $jumlah) * 100;

            return view('KinerjaKeuangan::realisasirbb.excel.kolekpersektorXLS', compact('now', 'jumlah', 'p_produktif', 'p_konsumtif'));
        }
        
        if($data->kategori_keuangan == 7){
            $now = DB::table('v_realisasi_cashrasio')->where('id_realisasi_detail', $data->id)->first();
            $lastyear = DB::table('v_realisasi_cashrasio')->where('tahun', $now->tahun - 1)->where('bulan', $now->bulan)->first();

                $p_persen_cashrasio = (is_null($lastyear)) ? 0 : $now->cash_rasio - $lastyear->cash_rasio;
                $p_alatliquid = (is_null($lastyear)) ? 0 : $now->alat_liquid - $lastyear->alat_liquid;
                $p_persen_alatliquid = (is_null($lastyear)) ? 0 : (($now->alat_liquid - $lastyear->alat_liquid)/$lastyear->alat_liquid)*100;
                $p_kas = (is_null($lastyear)) ? 0 : $now->kas - $lastyear->kas;
                $p_persen_kas = (is_null($lastyear)) ? 0 : (($now->kas - $lastyear->kas)/$lastyear->kas)*100;
                $p_giro = (is_null($lastyear)) ? 0 : $now->giro - $lastyear->giro;
                $p_persen_giro = (is_null($lastyear)) ? 0 : (($now->giro - $lastyear->giro)/$lastyear->giro)*100;
                $p_tabungan = (is_null($lastyear)) ? 0 : $now->tabungan - $lastyear->tabungan;
                $p_persen_tabungan = (is_null($lastyear)) ? 0 : (($now->tabungan - $lastyear->tabungan)/$lastyear->tabungan)*100;
                $p_hutanglancar = (is_null($lastyear)) ? 0 : $now->hutang_lancar - $lastyear->hutang_lancar;
                $p_persen_hutanglancar = (is_null($lastyear)) ? 0 : (($now->hutang_lancar - $lastyear->hutang_lancar)/$lastyear->hutang_lancar)*100;
                $p_kewajibansegera = (is_null($lastyear)) ? 0 : $now->kewajiban_segera - $lastyear->kewajiban_segera;
                $p_persen_kewajibansegera = (is_null($lastyear)) ? 0 : (($now->kewajiban_segera - $lastyear->kewajiban_segera)/$lastyear->kewajiban_segera)*100;
                $p_hutang_bungapajak = (is_null($lastyear)) ? 0 : $now->hutang_bungapajak - $lastyear->hutang_bungapajak;
                $p_persen_hutangbungapajak = ((is_null($lastyear)) || (is_null($now->hutang_bungapajak))) ? 0 : (($now->hutang_bungapajak - $lastyear->hutang_bungapajak)/$lastyear->hutang_bungapajak)*100;
                $p_deposito = (is_null($lastyear)) ? 0 : $now->deposito - $lastyear->deposito;
                $p_persen_deposito = (is_null($lastyear)) ? 0 : (($now->deposito - $lastyear->deposito)/$lastyear->deposito)*100;
                $p_Tabungan = (is_null($lastyear)) ? 0 : $now->Tabungan - $lastyear->Tabungan;
                $p_persen_Tabungan = (is_null($lastyear)) ? 0 : (($now->Tabungan - $lastyear->Tabungan)/$lastyear->Tabungan)*100;

            return view('KinerjaKeuangan::realisasirbb.excel.cashrasioXLS', compact('now', 'lastyear', 'p_persen_cashrasio', 'p_alatliquid', 'p_kas', 'p_giro', 'p_tabungan', 'p_hutanglancar', 'p_kewajibansegera', 'p_hutang_bungapajak', 'p_deposito', 'p_Tabungan', 'p_persen_alatliquid', 'p_persen_kas', 'p_persen_giro', 'p_persen_tabungan', 'p_persen_hutanglancar', 'p_persen_kewajibansegera', 'p_persen_hutangbungapajak', 'p_persen_deposito', 'p_persen_Tabungan'));
        }

        if($data->kategori_keuangan == 8){
            $now = DB::table('v_realisasi_ldr')->where('id_realisasi_detail', $data->id)->first();
            $lastyear = DB::table('v_realisasi_ldr')->where('tahun', $now->tahun - 1)->where('bulan', $now->bulan)->first();

                $p_persen_ldr = (is_null($lastyear)) ? 0 : $now->ldr - $lastyear->ldr;
                $p_kreditdiberikan = (is_null($lastyear)) ? 0 : $now->kredit_diberikan - $lastyear->kredit_diberikan;
                $p_persen_kreditdiberikan = (is_null($lastyear)) ? 0 : (($now->kredit_diberikan - $lastyear->kredit_diberikan)/$lastyear->kredit_diberikan)*100;
                $p_simpananpihaktiga = (is_null($lastyear)) ? 0 : $now->simpanan_pihaktiga - $lastyear->simpanan_pihaktiga;
                $p_persen_simpananpihaktiga = (is_null($lastyear)) ? 0 : (($now->simpanan_pihaktiga - $lastyear->simpanan_pihaktiga)/$lastyear->simpanan_pihaktiga)*100;
                $p_deposito = (is_null($lastyear)) ? 0 : $now->deposito - $lastyear->deposito;
                $p_persen_deposito = (is_null($lastyear)) ? 0 : (($now->deposito - $lastyear->deposito)/$lastyear->deposito)*100;
                $p_tabungan = (is_null($lastyear)) ? 0 : $now->tabungan - $lastyear->tabungan;
                $p_persen_tabungan = (is_null($lastyear)) ? 0 : (($now->tabungan - $lastyear->tabungan)/$lastyear->tabungan)*100;
                $p_pinjamanditerima = (is_null($lastyear)) ? 0 : $now->pinjaman_diterima - $lastyear->pinjaman_diterima;
                $p_persen_pinjamanditerima = (is_null($lastyear)) ? 0 : (($now->pinjaman_diterima - $lastyear->pinjaman_diterima)/$lastyear->pinjaman_diterima)*100;
                $p_antarbankpasiva = (is_null($lastyear)) ? 0 : $now->antarbank_pasiva - $lastyear->antarbank_pasiva;
                $p_persen_antarbankpasiva = (is_null($lastyear)) ? 0 : (($now->antarbank_pasiva - $lastyear->antarbank_pasiva)/$lastyear->antarbank_pasiva)*100;
                $p_modalinti = (is_null($lastyear)) ? 0 : $now->modal_inti - $lastyear->modal_inti;
                $p_persen_modalinti = (is_null($lastyear)) ? 0 : (($now->modal_inti - $lastyear->modal_inti)/$lastyear->modal_inti)*100;

            return view('KinerjaKeuangan::realisasirbb.excel.ldrXLS', compact('now', 'lastyear', 'p_persen_ldr', 'p_kreditdiberikan', 'p_simpananpihaktiga', 'p_deposito', 'p_tabungan', 'p_pinjamanditerima', 'p_antarbankpasiva', 'p_modalinti', 'p_persen_kreditdiberikan', 'p_persen_simpananpihaktiga', 'p_persen_deposito', 'p_persen_tabungan', 'p_persen_pinjamanditerima', 'p_persen_antarbankpasiva', 'p_persen_modalinti'));
        }

        if($data->kategori_keuangan == 9){
            $now = DB::table('v_realisasi_roa')->where('id_realisasi_detail', $data->id)->first();
            $lastyear = DB::table('v_realisasi_roa')->where('tahun', $now->tahun - 1)->where('bulan', $now->bulan)->first();

                $p_persen_roa = (is_null($lastyear)) ? 0 : $now->roa - $lastyear->roa;
                $p_aset = (is_null($lastyear)) ? 0 : $now->aset - $lastyear->aset;
                $p_persen_aset = (is_null($lastyear)) ? 0 : (($now->aset - $lastyear->aset)/$lastyear->aset)*100;
                $p_labasebelumpajak = (is_null($lastyear)) ? 0 : $now->laba_sebelum_pajak - $lastyear->laba_sebelum_pajak;
                $p_persen_labasebelumpajak = (is_null($lastyear)) ? 0 : (($now->laba_sebelum_pajak - $lastyear->laba_sebelum_pajak)/$lastyear->laba_sebelum_pajak)*100;

            return view('KinerjaKeuangan::realisasirbb.excel.roaXLS', compact('now', 'lastyear', 'p_persen_roa', 'p_aset', 'p_labasebelumpajak', 'p_persen_aset', 'p_persen_labasebelumpajak'));
        }

        if($data->kategori_keuangan == 10){
            $now = DB::table('v_realisasi_bopo')->where('id_realisasi_detail', $data->id)->first();
            $lastyear = DB::table('v_realisasi_bopo')->where('tahun', $now->tahun - 1)->where('bulan', $now->bulan)->first();

                $p_persen_bopo = (is_null($lastyear)) ? 0 :  $now->bopo - $lastyear->bopo;
                $p_bebanoperasional = (is_null($lastyear)) ? 0 : $now->beban_operasional - $lastyear->beban_operasional;
                $p_persen_bebanoperasional = (is_null($lastyear)) ? 0 : (($now->beban_operasional - $lastyear->beban_operasional)/$lastyear->beban_operasional)*100;
                $p_pendapatanoperasional = (is_null($lastyear)) ? 0 : $now->pendapatan_operasional - $lastyear->pendapatan_operasional;
                $p_persen_pendapatanoperasional = (is_null($lastyear)) ? 0 : (($now->pendapatan_operasional - $lastyear->pendapatan_operasional)/$lastyear->pendapatan_operasional)*100;

            return view('KinerjaKeuangan::realisasirbb.excel.bopoXLS', compact('now', 'lastyear','p_persen_bopo', 'p_bebanoperasional', 'p_pendapatanoperasional', 'p_persen_bebanoperasional', 'p_persen_pendapatanoperasional'));
        }

        if ($data->kategori_keuangan == 11) {
            $now = DB::table('v_realisasi_tingkatkesehatan')->where('id_realisasi_detail', $data->id)->first();
            $lastyear = DB::table('v_realisasi_tingkatkesehatan')->where('tahun', $now->tahun - 1)->where('bulan', $now->bulan)->first();

                $total_reward_last = (is_null($lastyear)) ? 0 : $lastyear->bobot_car + $lastyear->bobot_kap + $lastyear->bobot_ppap + $lastyear->bobot_cr + $lastyear->bobot_ldr + $lastyear->bobot_roa + $lastyear->bobot_bopo + $lastyear->manajemen_umum;
                $total_reward_current = $now->bobot_car + $now->bobot_kap + $now->bobot_ppap + $now->bobot_cr + $now->bobot_ldr + $now->bobot_roa + $now->bobot_bopo + $now->manajemen_umum;

            return view('KinerjaKeuangan::realisasirbb.excel.tingkatkesehatanXLS', compact('now', 'lastyear', 'total_reward_current', 'total_reward_last'));
        }
        if ($data->kategori_keuangan == 12) {
            $now = DB::table('v_realisasi_nsfr')->where('id_realisasi_detail', $data->id)->first();
            $lastyear = DB::table('v_realisasi_nsfr')->where('tahun', $now->tahun - 1)->where('bulan', $now->bulan)->first();

            return view('KinerjaKeuangan::realisasirbb.excel.nsfrXLS', compact('now', 'lastyear'));
        }
        if ($data->kategori_keuangan == 13) {
            $now = DB::table('v_realisasi_lcr')->where('id_realisasi_detail', $data->id)->first();
            $lastyear = DB::table('v_realisasi_lcr')->where('tahun', $now->tahun - 1)->where('bulan', $now->bulan)->first();

            return view('KinerjaKeuangan::realisasirbb.excel.lcrXLS', compact('now', 'lastyear'));
        }
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $arrStyle = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '00000000']
                        ]
                    ],
                ];

                $sheet = $event->getSheet()->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestCol = $sheet->getHighestColumn();

                $sheet->getStyle('A1:' . $highestCol . '1')->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:' . $highestCol . $highestRow)->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $sheet->getStyle('A1:' . $highestCol . $highestRow)
                    ->applyFromArray($arrStyle);

                $sheet->getStyle('A1:' . $highestCol . '1')->getFont()->setBold(true);

                $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            }
        ];
    }
}
