<?php

namespace Modules\KinerjaKeuangan\Http\Controllers;

use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Modules\Kelola\Entities\Comprof;
use Modules\Opsi\Entities\OptionValue;
use Modules\KinerjaKeuangan\Entities\RealisasiRBB;
use Modules\KinerjaKeuangan\Entities\RealisasiRBBDetail;
use Modules\KinerjaKeuangan\Entities\Temp008;
use Modules\KinerjaKeuangan\Entities\Temp100;
use Modules\KinerjaKeuangan\Entities\Temp200;
use Modules\KinerjaKeuangan\Entities\Temp600;
use Modules\KinerjaKeuangan\Entities\PerkembanganVolumeUsaha;
use Modules\KinerjaKeuangan\Entities\LabaRugi;
use Modules\KinerjaKeuangan\Entities\LDR;
use Modules\KinerjaKeuangan\Entities\LCR;
use Modules\KinerjaKeuangan\Entities\NSFR;
use Modules\KinerjaKeuangan\Entities\ROA;
use Modules\KinerjaKeuangan\Entities\BOPO;
use Modules\KinerjaKeuangan\Entities\RasioKeuangan;
use Modules\KinerjaKeuangan\Entities\CashRasio;
use Modules\KinerjaKeuangan\Entities\RasioPermodalan;
use Modules\KinerjaKeuangan\Entities\TingkatKesehatan;
use Modules\KinerjaKeuangan\Entities\KolekPersektor;
use Modules\KinerjaKeuangan\Entities\RasioNpl;
use Modules\KinerjaKeuangan\Http\Requests\RealisasiRequest;
use Illuminate\Http\UploadedFile;
use Ramsey\Uuid\Uuid;
use File;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RealisasiRBBController extends \App\Http\Controllers\Controller
{
    // private $kategori_keuangan;
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
        $data = RealisasiRBB::fetch($request);

        return view('KinerjaKeuangan::realisasirbb.default', compact('data', 'company_name'));
        // return view('KinerjaKeuangan::sumberdata.default');
    }

    public function store(Request $request)
    {
        // dd($request->id_comprof);exit;
        $rbb = new RealisasiRBB;
        // $rbb->id = Uuid::uuid4();
        $rbb->status_progres = 0;
        $datas = $request->only(['bulan', 'tahun', 'id_comprof']);

        foreach ($datas as $key => $value) {
            $rbb->$key = $value;
        }
        $company_name = to_dropdown(Comprof::where('status', 1)->where('id', $request->id_comprof)->get(), 'id', 'company_name');
        foreach ($company_name as $key => $value) {
            $company_name = $value;
        }
        // dd($company_name);exit;

        $message = ['key' => 'Realisasi RBB ', 'value' => $company_name . ' Periode ' . $request->bulan . ' Tahun ' . $request->tahun];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($rbb->save()) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }
        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }
        // return $this;
        return redirect('realisasi-rbb')->with($status, $response);
    }

    /**
     * @param Artikel $realisasi_rbb
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
    }

    /**
     * @param ArtikelRequest $request
     * @param Artikel $realisasi_rbb
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update()
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, RealisasiRBB $realisasi_rbb)
    {
        // dd($request);exit;
        // dd($realisasi_rbb);exit();
        // $data = RkatAudit::findOrFail($id);
        $data = RealisasiRBBDetail::all()->where('id_realisasirbb', $realisasi_rbb->id)->sortBy('kategori_keuangan');
        $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');

        // dd($data);exit;

        return view('KinerjaKeuangan::realisasirbb.show', compact('realisasi_rbb', 'data', 'company_name'));
    }

    protected function upload_txt(RealisasiRequest $request, $id)
    {
        // dd($request);exit;
        ini_set('memory_limit', -1);
        ini_set('max_execution_time', 0);

        $rbd = new RealisasiRBBDetail;
        $rbd->id = Uuid::uuid4();
        $rbd->id_realisasirbb = $id;
        $datas = $request->only(['kategori_keuangan']);
        if ($request['kategori_keuangan'] != '4' && $request['kategori_keuangan'] != '6' && $request['kategori_keuangan'] != '8' && $request['kategori_keuangan'] != '9' && $request['kategori_keuangan'] != '10' && $request['kategori_keuangan'] != '11' && $request['kategori_keuangan'] != '12' && $request['kategori_keuangan'] != '13') {
            $this->data = [];
            $file = $request->file('file');
            // membuat nama file unik
            // $nama_file = rand() . $file->getClientOriginalName();
            $nama_file = $file->getClientOriginalName();
            $kode_file = substr($nama_file, 7, 4);
            // upload ke folder file di dalam folder public
            $file->move('realisasi_files', $nama_file);
            // import data
            // $value = File::get(public_path('/realisasi_files/' . $nama_file));
            $file_path = public_path('/realisasi_files/' . $nama_file);
            // $file = ($this->filename instanceof UploadedFile ? $this->filename : storage_path('app/realisasi_files' . $this->filename));
            $lines = file($file_path, FILE_IGNORE_NEW_LINES);
            $header = explode('|', $lines[1]);
            // $nHeader = 4;
            $nHeader = count($header);
            array_shift($lines);

            // 
            foreach ($lines as $line) {
                $values = explode('|', $line);
                for ($i = 0; $i < $nHeader; $i++) {
                    $value[$i] = $values[$i];
                    // $value[2] = $values[2];
                }
                // dd($value[2]);exit;
                if ($request['kategori_keuangan'] === '1') { //Perkembangan Volume Usaha
                    if ($value[2] === '1000000000' && $value[1] === '000') {
                        $totalaset[] = $value[3];
                    }
                    if ($value[2] === '1103010000' && $value[1] === '000') {
                        $totalABA[] = $value[3];
                    }
                    if ($value[2] === '1104010100' && $value[1] === '000') {
                        $totalkredit[] = $value[3];
                    }
                    if (($value[2] === '2102010100' || $value[2] === '2102010200' || $value[2] === '2102020100' || $value[2] === '2102020200') && ($value[1] === '000')) {
                        $dpk[] = $value[3]; //dana pihak ketiga
                    }
                    if ($value[2] === '2103010000' && $value[1] === '000') {
                        $sbl[] = $value[3]; //simpanan bank lain
                    }
                    if (($value[2] === '220101000' || $value[2] === '2201020000' || $value[2] === '2201030000') && ($value[1] === '000')) {
                        $pyd[] = $value[3]; //pinjaman yang diterima
                    }
                    if (($value[2] === '3101010000' || $value[2] === '3101020000') && ($value[1] === '000')) {
                        $modal[] = $value[3];
                    }
                    if ($value[2] === '3105020000' && $value[1] === '000') {
                        $lr[] = $value[3]; //labarugi
                    }
                    $txt_100[] = $value;
                }

                if ($request['kategori_keuangan'] === '2') { //Laba Rugi
                    if (($value[2] === '4101010301' || $value[2] === '4101010302') && ($value[1] === '000')) {
                        $bungakredit[] = $value[3]; //Pend Bunga (Bunga Kredit + Bunga PPBL)
                    }
                    if (($value[2] === '4101010201' || $value[2] === '4101010202' || $value[2] === '4101010203' || $value[2] === '4101010204') && ($value[1] === '000')) {
                        $bungappbl[] = $value[3]; //Pend Bunga (Bunga Kredit + Bunga PPBL)
                    }
                    if (($value[2] === '4101020100' || $value[2] === '4101020200') && ($value[1] === '000')) {
                        $pendprov[] = $value[3]; //Pendapatan Provisi
                    }
                    if (($value[2] === '4102010000' || $value[2] === '4102020000' || $value[2] === '4102030000' || $value[2] === '4102040000' || $value[2] === '4102050000' || $value[2] === '4102990000') && ($value[1] === '000')) {
                        $pendlain[] = $value[3]; //Pendapatan Lainya
                    }
                    if ($value[2] === '5101010100' && $value[1] === '000') {
                        $tabungan[] = $value[3];
                    }
                    if ($value[2] === '5101010200' && $value[1] === '000') {
                        $deposito[] = $value[3];
                    }
                    if (($value[2] === '5101010401' || $value[2] === '5101010402' || $value[2] === '5101010403' || $value[2] === '5101010404') && ($value[1] === '000')) {
                        $pindit[] = $value[3]; //Pinjaman Diterima
                    }
                    if ($value[2] === '5101010300' && $value[1] === '000') {
                        $sbl[] = $value[3]; //simpanan bank lain
                    }
                    if (($value[2] === '5103010000' || $value[2] === '5103020000' || $value[2] === '5103030100' || $value[2] === '5103030200') && ($value[1] === '000')) {
                        $penker[] = $value[3]; //Penyisihan Kerugian
                    }
                    if ($value[2] === '5106040000' && $value[1] === '000') {
                        $penyATI[] = $value[3]; //Penyusunan ATI
                    }
                    if ($value[2] === '5102000000' && $value[1] === '000') {
                        $berest[] = $value[3]; //Beban Restrukturasi
                    }
                    if ($value[2] === '5104000000' && $value[1] === '000') {
                        $bepem[] = $value[3]; //Beban Pemasaran
                    }
                    if (($value[2] === '5106010100' || $value[2] === '5106010200' || $value[2] === '5106019900') && ($value[1] === '000')) {
                        $tenagakerja[] = $value[3];
                    }
                    if ($value[2] === '5106020000' && $value[1] === '000') {
                        $pendidikan[] = $value[3];
                    }
                    if ($value[2] === '5106060000' && $value[1] === '000') {
                        $preasur[] = $value[3]; //Premi Asuransi
                    }
                    if (($value[2] === '5106030100' || $value[2] === '5106039900') && ($value[1] === '000')) {
                        $sewa[] = $value[3];
                    }
                    if ($value[2] === '5106080000' && $value[1] === '000') {
                        $barjas[] = $value[3]; //Barang & Jasa
                    }
                    if ($value[2] === '5106070000' && $value[1] === '000') {
                        $pemper[] = $value[3]; //Pemeliharaan & Perbaikan
                    }
                    if ($value[2] === '5106090000' && $value[1] === '000') {
                        $pajak[] = $value[3]; //
                    }
                    if (($value[2] === '5199010000' || $value[2] === '5199020000' || $value[2] === '5199990000') && ($value[1] === '000')) {
                        $bebanlainya[] = $value[3];
                    }
                    if ($value[2] === '3104040400' && $value[1] === '000') {
                        $labarugi[] = $value[3]; //
                    }
                    $txt_200[] = $value;
                }

                if ($request['kategori_keuangan'] === '3') { //Rasio Keuangan
                    if ($value[1] === '0101') {
                        $car = $value[2];
                    }
                    if ($value[1] === '0201') {
                        $kap = $value[2];
                    }
                    if ($value[1] === '0202') {
                        $ppap = $value[2];
                    }
                    if ($value[1] === '0203') {
                        $npl = $value[2];
                    }
                    if ($value[1] === '0401') {
                        $roa = $value[2];
                    }
                    if ($value[1] === '0402') {
                        $bopo = $value[2];
                    }
                    if ($value[1] === '0501') {
                        $ldr = $value[2];
                    }
                    if ($value[1] === '0502') {
                        $cr = $value[2];
                    }
                    $txt_008[] = $value;
                }

                if ($request['kategori_keuangan'] === '5') { // rasio npl
                    if ($value[16] === '1') {
                        $lancar[] = $value[36];
                    }
                    // if ($value[16] === '2') {
                    //     $dalamperhatian[] = $value[36];
                    // }
                    if ($value[16] === '3') {
                        $kurang_lancar[] = $value[36];
                    }
                    if ($value[16] === '4') {
                        $diragukan[] = $value[36];
                    }
                    if ($value[16] === '5') {
                        $macet[] = $value[36];
                    }
                    $txt_600[] = $value;
                }

                if ($request['kategori_keuangan'] === '7') { // rasio npl
                    if ($value[4] === '10') {
                        $giro[] = $value[10];
                    }
                    if ($value[4] === '20') {
                        $tabungan[] = $value[10];
                    }
                }
            }
        }

        foreach ($datas as $key => $value) {
            $rbd->$key = $value;
        }

        // foreach ($txt_100 as $key => $value){
        //         // echo '<b>'.$key.'</b><br>';
        //         // echo $key.' => '.$value.',<br>';
        //     foreach($value as $a => $d){
        //         // echo $key.' => '.$d.',<br>';
        //         $da[$a] = $d;

        //     }dd($da[0]);exit;
        // }
        // $data200 = Temp200::ambil($request)->where('id_realisasirbb', $id);
        // // $drp = RasioPermodalan::ambil($request)->where('id_realisasirbb', $id);

        // foreach($data200 as $d){
        //     // echo $d.'<br>';
        //     // $modalbank = $d['modal'];
        //     // $modalpelengkap = $d['modal_pelengkap']; 
        //     if ($d['sandi_pos'] == '3104040300' && $d['sandi_kantor'] == '001') {
        //         $a[] = $d['jumlah'];
        //     }
        //     if ($d['sandi_pos'] == '3104040300' && $d['sandi_kantor'] != '001') {
        //         $b[] = $d['jumlah'];
        //     }

        // }
        // dd($kode_file);exit;
        $kategori_keuangan = to_dropdown(OptionValue::where('option_group_id', '3d29d1de-6eb9-473e-a78c-1b2ae38cc55d')->where('key', $request->kategori_keuangan)->get(), 'key', 'value');

        foreach ($kategori_keuangan as $key => $value) {
            $kategori_keuangan = $value;
        }
        // dd($kategori_keuangan);exit;

        $message = ['key' => 'Realisasi RBB ', 'value' => $kategori_keuangan];
        $status = 'error';
        $response = trans('message.upload_error', $message);

        $before = RealisasiRBBDetail::where('kategori_keuangan', $request->kategori_keuangan - 1)->where('id_realisasirbb', '=', $id)->first();
        $det = RealisasiRBBDetail::where('kategori_keuangan', '=', $request->kategori_keuangan)->where('id_realisasirbb', '=', $id)->first();
        // dd($det, $before, $request);exit;
        if ((is_null($det)) && (!empty($before)) || $request['kategori_keuangan'] === '1' && $kode_file == '0100') {
            if ($rbd->save()) {
                $status = 'success';
                $response = trans('message.upload_success', $message);

                if ($request['kategori_keuangan'] === '1') {
                    $pvu = new PerkembanganVolumeUsaha;
                    $pvu->id_realisasi_detail = $rbd->id;
                    $pvu->total_aset = array_sum($totalaset);
                    $pvu->total_aba = array_sum($totalABA);
                    $pvu->total_kredit = array_sum($totalkredit);
                    $pvu->dana_pihaktiga = array_sum($dpk);
                    $pvu->simpanan_banklain = array_sum($sbl);
                    $pvu->pinjaman_diterima = array_sum($pyd);
                    $pvu->modal = array_sum($modal);
                    $pvu->laba_rugi = array_sum($lr);
                    $pvu->save();

                    foreach ($txt_100 as $key => $value) {
                        foreach ($value as $a => $d) {
                            $da[$a] = $d;
                        }
                        $option[] = [
                            'id_realisasi_detail' => $rbd->id,
                            'flag_detail' => $da[0],
                            'sandi_kantor' => $da[1],
                            'sandi_pos' => $da[2],
                            'jumlah' => $da[3],
                        ];
                    }
                    Temp100::insert($option);
                }
                if ($request['kategori_keuangan'] === '2') {
                    $lr = new LabaRugi;
                    $lr->id_realisasi_detail = $rbd->id;
                    $lr->bunga_kredit = array_sum($bungakredit);
                    $lr->bunga_ppbl = array_sum($bungappbl);
                    $lr->pend_provisi = array_sum($pendprov);
                    $lr->pend_lainya = array_sum($pendlain);
                    $lr->tabungan = array_sum($tabungan);
                    $lr->deposito = array_sum($deposito);
                    $lr->pin_diterima = array_sum($pindit);
                    $lr->sbl = array_sum($sbl);
                    $lr->peny_kerugian = array_sum($penker);
                    $lr->peny_ATI = array_sum($penyATI);
                    $lr->beban_restruk = array_sum($berest);
                    $lr->beban_pemasaran = array_sum($bepem);
                    $lr->tenaga_kerja = array_sum($tenagakerja);
                    $lr->pendidikan = array_sum($pendidikan);
                    $lr->premi_asuransi = array_sum($preasur);
                    $lr->sewa = array_sum($sewa);
                    $lr->barangjasa = array_sum($barjas);
                    $lr->pemeliharaan_perbaikan = array_sum($pemper);
                    $lr->pajak = array_sum($pajak);
                    $lr->bebanlainya = array_sum($bebanlainya);
                    $lr->labarugi = array_sum($labarugi);
                    $lr->save();

                    foreach ($txt_200 as $key => $value) {
                        foreach ($value as $a => $d) {
                            $da[$a] = $d;
                        }
                        $option[] = [
                            'id_realisasi_detail' => $rbd->id,
                            'flag_detail' => $da[0],
                            'sandi_kantor' => $da[1],
                            'sandi_pos' => $da[2],
                            'jumlah' => $da[3],
                        ];
                    }
                    Temp200::insert($option);
                }
                if ($request['kategori_keuangan'] === '3') {
                    $rk = new RasioKeuangan;
                    $rk->id_realisasi_detail = $rbd->id;
                    $rk->car = $car;
                    $rk->kap = $kap;
                    $rk->ppap = $ppap;
                    $rk->npl = $npl;
                    $rk->cr = $cr;
                    $rk->ldr = $ldr;
                    $rk->roa = $roa;
                    $rk->bopo = $bopo;
                    $rk->save();

                    foreach ($txt_008 as $key => $value) {
                        foreach ($value as $a => $d) {
                            $da[$a] = $d;
                        }
                        $option[] = [
                            'id_realisasi_detail' => $rbd->id,
                            'flag_detail' => $da[0],
                            // 'sandi_kantor' => $da[1],
                            'sandi_pos' => $da[1],
                            'nilai_rasio' => $da[2],
                        ];
                    }
                    Temp008::insert($option);
                }

                if ($request['kategori_keuangan'] === '4') {
                    $data100 = Temp100::ambil($request)->where('id_realisasirbb', $id);
                    $data008 = Temp008::ambil($request)->where('id_realisasirbb', $id);

                    foreach ($data100 as $d) {
                        // echo $d->sandi_pos;
                        if ($d['sandi_pos'] == '1103010000') {
                            $antarbankaktiva[] = $d['jumlah'];
                        }
                        if ($d['sandi_pos'] == '1202010000') {
                            $ATI1[] = $d['jumlah'];
                        }
                        if ($d['sandi_pos'] == '1202020000') {
                            $ATI2[] = $d['jumlah']; //
                        }
                        if ($d['sandi_pos'] === '3101010000') {
                            $modaldisetor1[] = $d['jumlah'];
                        }
                        if ($d['sandi_pos'] === '3101020000') {
                            $modaldisetor2[] = $d['jumlah'];
                        }
                        if ($d['sandi_pos'] === '3104010000') {
                            $cadanganumum[] = $d['jumlah'];
                        }
                        if ($d['sandi_pos'] === '3104020000') {
                            $cadangantujuan[] = $d['jumlah'];
                        }
                        if ($d['sandi_pos'] === '3105020000') {
                            $lrthnberjalan[] = $d['jumlah'];
                        }
                        if ($d['sandi_pos'] === '3105010000') {
                            $lrthnlalu[] = $d['jumlah'];
                        }
                    }
                    foreach ($data008 as $d) {
                        if ($d['sandi_pos'] == '101') {
                            $CAR = $d['nilai_rasio'];
                        }
                    }

                    $rp = new RasioPermodalan;
                    $rp->id_realisasi_detail = $rbd->id;
                    $rp->ATMR = (array_sum($antarbankaktiva) * 20 / 100) + $request->kredit_diberikan + (array_sum($ATI1) - array_sum($ATI2)) + $request->rupa_aktiva;
                    $rp->antarbank_aktiva = array_sum($antarbankaktiva) * 20 / 100;
                    $rp->kredit_diberikan = $request->kredit_diberikan;
                    $rp->ATI = array_sum($ATI1) -  array_sum($ATI2);
                    $rp->rupa_aktiva = $request->rupa_aktiva;
                    $rp->modal = (array_sum($modaldisetor1) - array_sum($modaldisetor1)) + array_sum($cadanganumum) + array_sum($cadangantujuan) + (array_sum($lrthnberjalan) * 50 / 100) + array_sum($lrthnlalu) + $request->modal_pelengkap;
                    $rp->modal_disetor = array_sum($modaldisetor1) -  array_sum($modaldisetor2);
                    $rp->cadangan_umum = array_sum($cadanganumum);
                    $rp->cadangan_tujuan = array_sum($cadangantujuan);
                    $rp->laba_rugi_thnberjalan = array_sum($lrthnberjalan) * 50 / 100;
                    $rp->laba_rugi_thnlalu = array_sum($lrthnlalu);
                    $rp->modal_pelengkap = $request->modal_pelengkap;
                    $rp->godwill = $request->godwill;
                    $rp->CAR = $CAR;
                    $rp->save();
                }

                if ($request['kategori_keuangan'] === '5') {
                    $data008 = Temp008::ambil($request)->where('id_realisasirbb', $id);

                    foreach ($data008 as $d) {
                        if ($d['sandi_pos'] == '203') {
                            $gross = $d['nilai_rasio'];
                        }
                    }

                    $rnpl = new RasioNpl;
                    $rnpl->id_realisasi_detail = $rbd->id;
                    $rnpl->lancar = array_sum($lancar);
                    $rnpl->kurang_lancar = array_sum($kurang_lancar);
                    $rnpl->diragukan = array_sum($diragukan);
                    $rnpl->macet = array_sum($macet);
                    $rnpl->total = (array_sum($lancar)) + (array_sum($kurang_lancar)) + (array_sum($diragukan)) + (array_sum($macet));
                    $rnpl->total_kredit_nonlancar = (array_sum($kurang_lancar)) + (array_sum($diragukan)) + (array_sum($macet));
                    $rnpl->rasio_npl_gross = $gross;
                    $rnpl->save();

                    $insert_data = [];
                    foreach ($txt_600 as $key => $value) {
                        foreach ($value as $a => $d) {
                            $da[$a] = $d;
                        }
                        $option[] = [
                            'id_realisasi_detail' => $rbd->id,
                            'flag_detail' => $da[0],
                            'sandi_kantor' => $da[1],
                            'no_cif' => $da[2],
                            'no_identitas' => $da[3],
                            'kode_kelompok_kredit' => $da[4],
                            'no_rekening' => $da[5],
                            'jenis' => $da[6],
                            'status_restrukturisasi' => $da[7],
                            'jenis_penggunaan' => $da[8],
                            'hub_dengan_bank' => $da[9],
                            'sumber_dana_pelunasan' => $da[10],
                            'periode_pemb_pokok' => $da[11],
                            'periode_pemb_bunga' => $da[12],
                            'tanggal_mulai' => $da[13],
                            'tanggal_jatuh_tempo' => $da[14],
                            'angsuran_pokok_pertama' => $da[15],
                            'kualitas' => $da[16],
                            'tanggal_mulai_macet' => $da[17],
                            'jml_hari_tgk_pokok' => $da[18],
                            'jml_hari_tgk_bunga' => $da[19],
                            'tgk_pokok' => $da[20],
                            'tgk_bunga' => $da[21],
                            'gol_debitur' => $da[22],
                            'sandi_bank' => $da[23],
                            'sektor_ekonomi' => $da[24],
                            'kategori_usaha' => $da[25],
                            'lokasi_penggunaan' => $da[26],
                            'suku_bunga' => $da[27],
                            'suku_bunga_cara' => $da[28],
                            'gol_penjamin' => $da[29],
                            'bagian_dijamin' => $da[30],
                            'nilai_agun_liquid' => $da[31],
                            'nilai_agun_nonliquid' => $da[32],
                            'longgar_tarik' => $da[33],
                            'plafond_awal' => $da[34],
                            'plafond_efektif' => $da[35],
                            'baki_debet' => $da[36],
                            'provisi_belum_diamor' => $da[37],
                            'biaya_trans_blm_diamor' => $da[38],
                            'pend_bunga_ditangguhkan' => $da[39],
                            'cad_kerugian_restruk' => $da[40],
                            'baki_debet_netto' => $da[41],
                            'ppap_dibentuk' => $da[42],
                            'kelebihan_ppap' => $da[43],
                            'pbyad' => $da[44],
                            'pend_bunga_dalam_p' => $da[45],
                            'status_bmpk' => $da[46],
                        ];
                        // $insert_data[] = $option;
                    }
                    $insert_data = collect($option);
                    $chunks = $insert_data->chunk(500);
                    $chunks->toArray();

                    foreach ($chunks as $chunk) {
                        Temp600::insert($chunk->toArray());
                    }
                }

                if ($request['kategori_keuangan'] === '6') {  //kolekpersektor
                    $data = Temp600::ambil($request)->where('id_realisasirbb', $id);

                    foreach ($data as $d) {
                        // echo $d;
                        if ($d['kualitas'] === '1') {
                            if ($d['sektor_ekonomi'] === '001100' || $d['sektor_ekonomi'] === '001110' || $d['sektor_ekonomi'] === '001120' || $d['sektor_ekonomi'] === '001130' || $d['sektor_ekonomi'] === '001210' || $d['sektor_ekonomi'] === '001220' || $d['sektor_ekonomi'] === '001230' || $d['sektor_ekonomi'] === '001300' || $d['sektor_ekonomi'] === '002100' || $d['sektor_ekonomi'] === '002200' || $d['sektor_ekonomi'] === '002300' || $d['sektor_ekonomi'] === '002900' || $d['sektor_ekonomi'] === '003100' || $d['sektor_ekonomi'] === '003200' || $d['sektor_ekonomi'] === '003300' || $d['sektor_ekonomi'] === '003900' || $d['sektor_ekonomi'] === '004120' || $d['sektor_ekonomi'] === '004130' || $d['sektor_ekonomi'] === '004140' || $d['sektor_ekonomi'] === '004150' || $d['sektor_ekonomi'] === '004160' || $d['sektor_ekonomi'] === '004170' || $d['sektor_ekonomi'] === '004180' || $d['sektor_ekonomi'] === '004190' || $d['sektor_ekonomi'] === '004900' || $d['sektor_ekonomi'] === '009000') {
                                $konsumtif[] = $d['baki_debet'];
                            } else {
                                $produktif[] = $d['baki_debet'];
                            }
                        }
                    }
                    $kp = new KolekPersektor;
                    $kp->id_realisasi_detail = $rbd->id;
                    $kp->produktif = array_sum($produktif);
                    $kp->konsumtif = array_sum($konsumtif);
                    $kp->save();
                }

                if ($request['kategori_keuangan'] === '7') {  //cashratio
                    $data100 = Temp100::ambil($request)->where('id_realisasirbb', $id);
                    $data008 = Temp008::ambil($request)->where('id_realisasirbb', $id);

                    foreach ($data008 as $d) {
                        if ($d['sandi_pos'] == '502') {
                            $cr = $d['nilai_rasio'];
                        }
                    }
                    foreach ($data100 as $d) {
                        if ($d['sandi_pos'] == '1101010000' || $d['sandi_pos'] == '1101020000') {
                            $kas[] = $d['jumlah'];
                        }
                        if ($d['sandi_pos'] == '2101000000') {
                            $kewajiban[] = $d['jumlah'];
                        }
                        // if ($d['sandi_pos'] == '2299010201' || $d['sandi_pos'] == '2299010202' || $d['sandi_pos'] == '2299010201' || $d['sandi_pos'] == '2299010202' || $d['sandi_pos'] == '2299010201' || $d['sandi_pos'] == '2299010202' || $d['sandi_pos'] == '2299010201' || $d['sandi_pos'] == '2299010202' || $d['sandi_pos'] == '2299010201') {
                        //     $hutang_bungapajak[] = $d['jumlah'];
                        // }
                        if ($d['sandi_pos'] == '2102020100') {
                            $depo1[] = $d['jumlah'];
                        }
                        if ($d['sandi_pos'] == '2102020200') {
                            $depo2[] = $d['jumlah'];
                        }
                        if ($d['sandi_pos'] == '2102010100') {
                            $tab1[] = $d['jumlah'];
                        }
                        if ($d['sandi_pos'] == '2102010200') {
                            $tab2[] = $d['jumlah'];
                        }
                    }

                    $crs = new CashRasio;
                    $crs->id_realisasi_detail = $rbd->id;
                    $crs->cash_rasio = $cr;
                    $crs->alat_liquid = array_sum($kas) + array_sum($giro) + array_sum($tabungan);
                    $crs->kas = array_sum($kas);
                    $crs->giro = array_sum($giro);
                    $crs->tabungan = array_sum($tabungan);
                    $crs->hutang_lancar = array_sum($kewajiban) /* + array_sum($hutang_bungapajak) */ + (array_sum($depo1) - array_sum($depo2)) + (array_sum($tab1) - array_sum($tab2));
                    $crs->kewajiban_segera = array_sum($kewajiban);
                    // $crs->hutang_bungapajak = array_sum($hutang_bungapajak);
                    $crs->deposito = (array_sum($depo1) - array_sum($depo2));
                    $crs->Tabungan = (array_sum($tab1) - array_sum($tab2));
                    $crs->save();
                }

                if ($request['kategori_keuangan'] === '8') {  //loan deposit ratio(LDR)
                    $data100 = Temp100::ambil($request)->where('id_realisasirbb', $id);
                    $data008 = Temp008::ambil($request)->where('id_realisasirbb', $id);
                    $drp = RasioPermodalan::ambil($request)->where('id_realisasirbb', $id);

                    foreach ($data008 as $d) {
                        if ($d['sandi_pos'] == '501') {
                            $ld = $d['nilai_rasio'];
                        }
                    }
                    foreach ($drp as $d) {
                        $modalbank = $d['modal'];
                        $modalpelengkap = $d['modal_pelengkap'];
                    }
                    foreach ($data100 as $d) {
                        if ($d['sandi_pos'] == '1104010100') {
                            $kredit[] = $d['jumlah'];
                        }
                        if ($d['sandi_pos'] == '2102020100') {
                            $deposito[] = $d['jumlah'];
                        }
                        if ($d['sandi_pos'] == '2102010100') {
                            $tabungan[] = $d['jumlah'];
                        }
                        if ($d['sandi_pos'] == '2201010000') {
                            $pindit1[] = $d['jumlah'];
                        }
                        if ($d['sandi_pos'] == '2201020000') {
                            $pindit2[] = $d['jumlah'];
                        }
                        if ($d['sandi_pos'] == '2103010000') {
                            $antarbank_pasiva[] = $d['jumlah'];
                        }
                    }

                    $ldr = new LDR;
                    $ldr->id_realisasi_detail = $rbd->id;
                    $ldr->ldr = $ld;
                    $ldr->kredit_diberikan = array_sum($kredit);
                    $ldr->simpanan_pihaktiga = array_sum($deposito) + array_sum($tabungan) + (array_sum($pindit1) - array_sum($pindit2)) + array_sum($antarbank_pasiva);
                    $ldr->deposito = array_sum($deposito);
                    $ldr->tabungan = array_sum($tabungan);
                    $ldr->pinjaman_diterima = array_sum($pindit1) - array_sum($pindit2);
                    $ldr->antarbank_pasiva = array_sum($antarbank_pasiva);
                    $ldr->modal_inti = $modalbank - $modalpelengkap;
                    $ldr->save();
                }

                if ($request['kategori_keuangan'] === '9') { //ROA [sementara belum di rata2 kan krn data belum lengkap]
                    $data100 = Temp100::ambil($request)->where('id_realisasirbb', $id);
                    $data008 = Temp008::ambil($request)->where('id_realisasirbb', $id);
                    $data200 = Temp200::ambil($request)->where('id_realisasirbb', $id);

                    foreach ($data008 as $d) {
                        if ($d['sandi_pos'] == '401') {
                            $roa = $d['nilai_rasio'];
                        }
                    }
                    foreach ($data100 as $d) {
                        if ($d['sandi_pos'] == '1000000000') {
                            $aset[] = $d['jumlah'];
                        }
                    }
                    foreach ($data200 as $d) {
                        if ($d['sandi_pos'] == '3104040300') {
                            $laba_sebelumpajak[] = $d['jumlah'];
                        }
                    }

                    $ro = new ROA;
                    $ro->id_realisasi_detail = $rbd->id;
                    $ro->roa = $roa;
                    $ro->aset = array_sum($aset);
                    $ro->laba_sebelum_pajak = array_sum($laba_sebelumpajak);
                    $ro->save();
                }

                if ($request['kategori_keuangan'] === '10') { //BOPO [sementara belum di rata2 kan krn data belum lengkap]
                    $data008 = Temp008::ambil($request)->where('id_realisasirbb', $id);
                    $data200 = Temp200::ambil($request)->where('id_realisasirbb', $id);

                    foreach ($data008 as $d) {
                        if ($d['sandi_pos'] == '402') {
                            $bopo = $d['nilai_rasio'];
                        }
                    }
                    foreach ($data200 as $d) {
                        if ($d['sandi_pos'] == '5100000000' && $d['sandi_kantor'] == '000') {
                            $beban_operasional = $d['jumlah'];
                        }
                        if ($d['sandi_pos'] == '4100000000' && $d['sandi_kantor'] == '000') {
                            $pendapatan_operasional = $d['jumlah'];
                        }
                    }

                    $bpo = new BOPO;
                    $bpo->id_realisasi_detail = $rbd->id;
                    $bpo->bopo = $bopo;
                    $bpo->beban_operasional = $beban_operasional;
                    $bpo->pendapatan_operasional = $pendapatan_operasional;
                    $bpo->save();
                }

                if ($request['kategori_keuangan'] === '11') { //tingkat kesehatan bank
                    $data008 = Temp008::ambil($request)->where('id_realisasirbb', $id);

                    foreach ($data008 as $d) {
                        if ($d['sandi_pos'] == '101') {
                            $car = $d['nilai_rasio'];
                        }
                        if ($d['sandi_pos'] == '201') {
                            $kap = $d['nilai_rasio'];
                        }
                        if ($d['sandi_pos'] == '202') {
                            $ppap = $d['nilai_rasio'];
                        }
                        if ($d['sandi_pos'] == '502') {
                            $cr = $d['nilai_rasio'];
                        }
                        if ($d['sandi_pos'] == '501') {
                            $ldr = $d['nilai_rasio'];
                        }
                        if ($d['sandi_pos'] == '401') {
                            $roa = $d['nilai_rasio'];
                        }
                        if ($d['sandi_pos'] == '402') {
                            $bopo = $d['nilai_rasio'];
                        }
                    }
                    $tk = new TingkatKesehatan;
                    $tk->id_realisasi_detail = $rbd->id;
                    $tk->bobot_car = $request->bobot_car;
                    $tk->bobot_kap = $request->bobot_kap;
                    $tk->bobot_ppap = $request->bobot_ppap;
                    $tk->bobot_cr = $request->bobot_cr;
                    $tk->bobot_ldr = $request->bobot_ldr;
                    $tk->bobot_roa = $request->bobot_roa;
                    $tk->bobot_bopo = $request->bobot_bopo;
                    $tk->nilai_car = $car;
                    $tk->nilai_kap = $kap;
                    $tk->nilai_ppap = $ppap;
                    $tk->nilai_cr = $cr;
                    $tk->nilai_ldr = $ldr;
                    $tk->nilai_roa = $roa;
                    $tk->nilai_bopo = $bopo;
                    $tk->manajemen_umum = $request->manajemen_umum;
                    $tk->manajemen_resiko = $request->manajemen_resiko;
                    $tk->save();
                }
                if ($request['kategori_keuangan'] === '12') { //NSFR
                    $nsfr = new NSFR;
                    $nsfr->id_realisasi_detail = $rbd->id;
                    $nsfr->rasio_nsfr = $request->nsfr;
                    $nsfr->save();
                }
                if ($request['kategori_keuangan'] === '13') { //NSFR
                    $lcr = new LCR;
                    $lcr->id_realisasi_detail = $rbd->id;
                    $lcr->rasio_lcr = $request->lcr;
                    $lcr->save();
                } else {
                    return redirect('realisasi-rbb/' . $id)->with($status, $response);
                }
            }
            if ($request->ajax()) {
                return response()->json(['message' => $response, 'status' => $status]);
            }
            return redirect('realisasi-rbb/' . $id)->with($status, $response);
        } else {
            return redirect('realisasi-rbb/' . $id)->with($status, $response);
        }
    }

    /**
     * @param Request $request
     * @param Artikel $realisasi_rbb
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function detail_kategori(request $request, $id)
    {
        $data = RealisasiRBBDetail::FindOrFail($id);
        // dd($data->kategori_keuangan);exit;

        if ($data->kategori_keuangan === '1') {
            $datas = DB::table('v_realisasi_perkembangan_volume')->where('id_realisasi_detail', $id)->first();
            $datas_2 = DB::table('v_realisasi_perkembangan_volume')->select('total_aset', 'total_aba', 'total_kredit', 'dana_pihaktiga', 'simpanan_banklain', 'pinjaman_diterima', 'laba_rugi')->whereBetween('tahun', [($datas->tahun - 1), $datas->tahun])->get()->toArray();
            $last = DB::table('v_realisasi_perkembangan_volume')->where('tahun', $datas->tahun - 1)->where('bulan', $datas->bulan)->first();
            $target = DB::table('v_target_perkembangan_volume')->where('periode', $datas->bulan)->where('id_comprof', $datas->id_comprof)->where('tahun', $datas->tahun)->first();

            $p_aset = (is_null($last)) ? 0 : $datas->total_aset - $last->total_aset;
            $p_persen_aset = (is_null($last)) ? 0 : round((float)$p_aset / $last->total_aset * 100);
            $p_aset_penc = (is_null($target)) ? 0 : round((float)$datas->total_aset / ($target->total_aset * 1000000) * 100);
            $p_aba = (is_null($last)) ? 0 : $datas->total_aba - $last->total_aba;
            $p_persen_aba = (is_null($last)) ? 0 : round((float)$p_aba / $last->total_aba * 100);
            $p_aba_penc = (is_null($target)) ? 0 : round((float)$datas->total_aba / ($target->total_aba * 1000000) * 100);
            $p_kredit = (is_null($last)) ? 0 : $datas->total_kredit - $last->total_kredit;
            $p_persen_kredit = (is_null($last)) ? 0 : round((float)$p_kredit / $last->total_kredit * 100);
            $p_kredit_penc = (is_null($target)) ? 0 : round((float)$datas->total_kredit / ($target->total_kredit * 1000000) * 100);
            $p_dana_pihaktiga = (is_null($last)) ? 0 : $datas->dana_pihaktiga - $last->dana_pihaktiga;
            $p_persen_dana_pihaktiga = (is_null($last)) ? 0 : round((float)$p_dana_pihaktiga / $last->dana_pihaktiga * 100);
            $p_dpk_penc = (is_null($target)) ? 0 : round((float)$datas->dana_pihaktiga / ($target->dana_pihak_ketiga * 1000000) * 100);

            $p_simpanan_banklain = (is_null($last)) ? 0 : $datas->simpanan_banklain - $last->simpanan_banklain;
            $p_persen_simpananbanklain = (is_null($last)) ? 0 : round((float)$p_simpanan_banklain / $last->simpanan_banklain * 100);
            $p_simpananbanklain_penc = (is_null($target)) ? 0 : round((float)$datas->simpanan_banklain / ($target->simpanan_bank_lain * 1000000) * 100);

            $p_pinjaman_diterima = (is_null($last)) ? 0 : $datas->pinjaman_diterima - $last->pinjaman_diterima;
            $p_persen_pinjaman_diterima = (is_null($last)) ? 0 : round((float)$p_pinjaman_diterima / $last->pinjaman_diterima * 100);
            $p_pindit_penc = (is_null($target)) ? 0 : round((float)$datas->pinjaman_diterima / ($target->pinjaman_yang_diterima * 1000000) * 100);
            $p_modal = (is_null($last)) ? 0 : $datas->modal - $last->modal;
            $p_persen_modal = (is_null($last)) ? 0 : round((float)$p_modal / $last->modal * 100);
            $p_modal_penc = (is_null($target)) ? 0 : round((float)$datas->modal / ($target->modal * 1000000) * 100);
            $p_laba_rugi = (is_null($last)) ? 0 : $datas->laba_rugi - $last->laba_rugi;
            $p_persen_laba_rugi = (is_null($last)) ? 0 : round((float)$p_laba_rugi / $last->laba_rugi * 100);
            $p_laba_rugi_penc = (is_null($target)) ? 0 : round((float)$datas->laba_rugi / ($target->laba_rugi * 1000000) * 100);

            // Declare two dates 
            $Date1 = ('01-' . $datas->bulan . '-' . ($datas->tahun - 1));
            $Date2 = ('01-' . ($datas->bulan + 1) . '-' . $datas->tahun);

            // Declare an empty array 
            $array = array();

            // Use strtotime function 
            $Variable1 = strtotime($Date1);
            $Variable2 = strtotime($Date2);

            // Use for loop to store dates into array 
            // 86400 sec = 24 hrs = 60*60*24 = 1 day * 31 = 1 Month 
            for (
                $currentDate = $Variable1;
                $currentDate <= $Variable2;
                $currentDate += (86400 * 31)
            ) {

                $Store = date('M-Y', $currentDate);
                $array[] = $Store;
            }

            // Display the dates in array format 
            $periode_bulan = $array;

            $jml_bln = count($periode_bulan);
            for ($x = 0; $x <= $jml_bln; $x++) {
                $tot_aset[] = $datas_2[$x]->total_aset;
                $tot_aba[] = $datas_2[$x]->total_aba;
                $tot_kredit[] = $datas_2[$x]->total_kredit;
                $dana_pihak_ketiga[] = $datas_2[$x]->dana_pihaktiga;
                $simpanan_bank_lain[] = $datas_2[$x]->simpanan_banklain;
                $pinjaman_diterima[] = $datas_2[$x]->pinjaman_diterima;
                $laba_rugi[] = $datas_2[$x]->laba_rugi;
            }

            return view('KinerjaKeuangan::realisasirbb.kategorikeuangan.perkembanganvolume', compact('periode_bulan', 'datas', 'last', 'target', 'p_aset', 'p_persen_aset', 'p_aset_penc', 'p_aba', 'p_persen_aba', 'p_kredit', 'p_persen_kredit', 'p_dana_pihaktiga', 'p_persen_dana_pihaktiga', 'p_simpanan_banklain', 'p_persen_simpananbanklain', 'p_simpananbanklain_penc', 'p_pinjaman_diterima', 'p_persen_pinjaman_diterima', 'p_modal', 'p_persen_modal', 'p_laba_rugi', 'p_persen_laba_rugi', 'p_aba_penc', 'p_kredit_penc', 'p_dpk_penc', 'p_pindit_penc', 'p_modal_penc', 'p_laba_rugi_penc', 'tot_aset', 'tot_aba', 'tot_kredit', 'dana_pihak_ketiga', 'simpanan_bank_lain', 'pinjaman_diterima', 'laba_rugi'));
        }

        if ($data->kategori_keuangan === '2') {
            $datas = DB::table('v_realisasi_labarugi')->where('id_realisasi_detail', $id)->first();
            $last = DB::table('v_realisasi_labarugi')->where('tahun', $datas->tahun - 1)->where('bulan', $datas->bulan)->first();
            $target = DB::table('v_target_labarugi')->where('periode', $datas->bulan)->where('id_comprof', $datas->id_comprof)->where('tahun', $datas->tahun)->first();

            // dd($target);exit;
            $pendops_realisasi = $datas->bunga_kredit + $datas->bunga_ppbl + $datas->pend_provisi + $datas->pend_lainya;
            $pendops_realisasi_last = (is_null($last)) ? 0 : $last->bunga_kredit + $last->bunga_ppbl + $last->pend_provisi + $last->pend_lainya;
            $pendops_realisasi_target = (is_null($target)) ? 0 : round((float)($target->bunga_kredit + $target->bunga_ppbl + $target->pendapatan_provinsi + $target->pendapatan_lainnya) * 1000000);

            $p_pendops = $pendops_realisasi - $pendops_realisasi_last;
            $p_persen_pendops = (is_null($last)) ? 0 : round((float)$p_pendops / $pendops_realisasi_last * 100);
            $p_pendops_penc = (is_null($target)) ? 0 : round((float)$pendops_realisasi / $pendops_realisasi_target * 100);

            $p_bungakredit = (is_null($last)) ? 0 : $datas->bunga_kredit - $last->bunga_kredit;
            $p_persen_bungakredit = (is_null($last)) ? 0 : round((float)$p_bungakredit / $last->bunga_kredit * 100);
            $p_bungakredit_penc = (is_null($target)) ? 0 : round((float)$datas->bunga_kredit / ($target->bunga_kredit * 1000000) * 100);

            $p_bungappbl = (is_null($last)) ? 0 : $datas->bunga_ppbl - $last->bunga_ppbl;
            $p_persen_bungappbl = (is_null($last)) ? 0 : round((float)$p_bungappbl / $last->bunga_ppbl * 100);
            $p_bungappbl_penc = (is_null($target)) ? 0 : round((float)$datas->bunga_ppbl / ($target->bunga_ppbl * 1000000) * 100);

            $p_pendprov = (is_null($last)) ? 0 : $datas->pend_provisi - $last->pend_provisi;
            $p_persen_pendprov = (is_null($last)) ? 0 : round((float)$p_pendprov / $last->pend_provisi * 100);
            $p_pendprov_penc = (is_null($target)) ? 0 : round((float)$datas->pend_provisi / ($target->pendapatan_provinsi * 1000000) * 100);

            $p_pendlainya = (is_null($last)) ? 0 : $datas->pend_lainya - $last->pend_lainya;
            $p_persen_pendlainya = (is_null($last)) ? 0 : round((float)$p_pendlainya / $last->pend_lainya * 100);
            $p_pendlainya_penc = (is_null($target)) ? 0 : round((float)$datas->pend_lainya / ($target->pendapatan_lainnya * 1000000) * 100);

            $bunga_realisasi = $datas->tabungan + $datas->deposito + $datas->pin_diterima + $datas->sbl;
            $bunga_realisasi_last = (is_null($last)) ? 0 : $last->tabungan + $last->deposito + $last->pin_diterima + $last->sbl;
            $bunga_realisasi_target = (is_null($target)) ? 0 : round((float)($target->tabungan + $target->deposito + $target->pinjaman_diterima + $target->simpanan_banklain) * 1000000);

            $bebanops_realisasi = $bunga_realisasi + $datas->peny_kerugian + $datas->peny_ATI + $datas->beban_restruk + $datas->beban_pemasaran + $datas->tenaga_kerja + $datas->pendidikan + $datas->premi_asuransi + $datas->sewa + $datas->barangjasa + $datas->pemeliharaan_perbaikan + $datas->pajak + $datas->bebanlainya;

            $bebanops_realisasi_last = (is_null($last)) ? 0 : $bunga_realisasi_last + $last->peny_kerugian + $last->peny_ATI + $last->beban_restruk + $last->beban_pemasaran + $last->tenaga_kerja + $last->pendidikan + $last->premi_asuransi + $last->sewa + $last->barangjasa + $last->pemeliharaan_perbaikan + $last->pajak + $last->bebanlainya;

            $bebanops_realisasi_target = (is_null($target)) ? 0 : $bunga_realisasi_target + round((float)($target->penyisihan_kerugian + $target->penyusutan_ati + $target->beban_restrukturisasi + $target->beban_pemasaran + $target->tenaga_kerja + $target->pendidikan + $target->premi_asuransi + $target->sewa + $target->barang_dan_jasa + $target->pemeliharaan_perbaikan + $target->pajak + $target->beban_lainnya) * 1000000);

            $p_bebanops = $bebanops_realisasi - $bebanops_realisasi_last;
            $p_persen_bebanops = (is_null($last)) ? 0 : round((float)$p_bebanops / $bebanops_realisasi_last * 100);
            $p_bebanops_penc = (is_null($target)) ? 0 : round((float)$bebanops_realisasi / $bebanops_realisasi_target * 100);

            $p_bunga = $bunga_realisasi - $bunga_realisasi_last;
            $p_persen_bunga = (is_null($last)) ? 0 : round((float)$p_bunga / $bunga_realisasi_last * 100);
            $p_bunga_penc = (is_null($target)) ? 0 : round((float)$bunga_realisasi / $bunga_realisasi_target * 100);

            $p_tabungan = (is_null($last)) ? 0 : $datas->tabungan - $last->tabungan;
            $p_persen_tabungan = (is_null($last)) ? 0 : round((float)$p_tabungan / $last->tabungan * 100);
            $p_tabungan_penc = (is_null($target)) ? 0 : round((float)$datas->tabungan / ($target->tabungan * 1000000) * 100);

            $p_deposito = (is_null($last)) ? 0 : $datas->deposito - $last->deposito;
            $p_persen_deposito = (is_null($last)) ? 0 : round((float)$p_deposito / $last->deposito * 100);
            $p_deposito_penc = (is_null($target)) ? 0 : round((float)$datas->deposito / ($target->deposito * 1000000) * 100);

            $p_sbl = (is_null($last)) ? 0 : $datas->sbl - $last->sbl;
            $p_persen_sbl = (is_null($last)) ? 0 : round((float)$p_sbl / $last->sbl * 100);
            $p_sbl_penc = (is_null($target)) ? 0 : round((float)$datas->sbl / ($target->simpanan_banklain * 1000000) * 100);

            $p_pin_diterima = (is_null($last)) ? 0 : $datas->pin_diterima - $last->pin_diterima;
            $p_persen_pin_diterima = (is_null($last)) ? 0 : round((float)$p_pin_diterima / $last->pin_diterima * 100);
            $p_pin_diterima_penc = (is_null($target)) ? 0 : round((float)$datas->pin_diterima / ($target->pinjaman_diterima * 1000000) * 100);

            $p_peny_kerugian = (is_null($last)) ? 0 : $datas->peny_kerugian - $last->peny_kerugian;
            $p_persen_peny_kerugian = (is_null($last)) ? 0 : round((float)$p_peny_kerugian / $last->peny_kerugian * 100);
            $p_peny_kerugian_penc = (is_null($target)) ? 0 : round((float)$datas->peny_kerugian / ($target->penyisihan_kerugian * 1000000) * 100);

            $p_peny_ATI = (is_null($last)) ? 0 : $datas->peny_ATI - $last->peny_ATI;
            $p_persen_peny_ATI = (is_null($last)) ? 0 : round((float)$p_peny_ATI / $last->peny_ATI * 100);
            $p_peny_ATI_penc = (is_null($target)) ? 0 : round((float)$datas->peny_ATI / ($target->penyusutan_ati * 1000000) * 100);

            $p_tenaga_kerja = (is_null($last)) ? 0 : $datas->tenaga_kerja - $last->tenaga_kerja;
            $p_persen_tenaga_kerja = (is_null($last)) ? 0 : round((float)$p_tenaga_kerja / $last->tenaga_kerja * 100);
            $p_tenaga_kerja_penc = (is_null($target)) ? 0 : round((float)$datas->tenaga_kerja / ($target->tenaga_kerja * 1000000) * 100);

            $p_pendidikan = (is_null($last)) ? 0 : $datas->pendidikan - $last->pendidikan;
            $p_persen_pendidikan = (is_null($last)) ? 0 : round((float)$p_pendidikan / $last->pendidikan * 100);
            $p_pendidikan_penc = (is_null($target)) ? 0 : round((float)$datas->pendidikan / ($target->pendidikan * 1000000) * 100);

            $p_premi_asuransi = (is_null($last)) ? 0 : $datas->premi_asuransi - $last->premi_asuransi;
            $p_persen_premi_asuransi = (is_null($last)) ? 0 : round((float)$p_premi_asuransi / $last->premi_asuransi * 100);
            $p_premi_asuransi_penc = (is_null($target)) ? 0 : round((float)$datas->premi_asuransi / ($target->premi_asuransi * 1000000) * 100);

            $p_sewa = (is_null($last)) ? 0 : $datas->sewa - $last->sewa;
            $p_persen_sewa = (is_null($last)) ? 0 : round((float)$p_sewa / $last->sewa * 100);
            $p_sewa_penc = (is_null($target)) ? 0 : round((float)$datas->sewa / ($target->sewa * 1000000) * 100);

            $p_pemeliharaan_perbaikan = (is_null($last)) ? 0 : $datas->pemeliharaan_perbaikan - $last->pemeliharaan_perbaikan;
            $p_persen_pemeliharaan_perbaikan = (is_null($last)) ? 0 : round((float)$p_pemeliharaan_perbaikan / $last->pemeliharaan_perbaikan * 100);
            $p_pemeliharaan_perbaikan_penc = (is_null($target)) ? 0 : round((float)$datas->pemeliharaan_perbaikan / ($target->pemeliharaan_perbaikan * 1000000) * 100);

            $p_barangjasa = (is_null($last)) ? 0 : $datas->barangjasa - $last->barangjasa;
            $p_persen_barangjasa = (is_null($last)) ? 0 : round((float)$p_barangjasa / $last->barangjasa * 100);
            $p_barangjasa_penc = (is_null($target)) ? 0 : round((float)$datas->barangjasa / ($target->barang_dan_jasa * 1000000) * 100);

            $p_bebanlainya = (is_null($last)) ? 0 : $datas->bebanlainya - $last->bebanlainya;
            $p_persen_bebanlainya = (is_null($last)) ? 0 : round((float)$p_bebanlainya / $last->bebanlainya * 100);
            $p_bebanlainya_penc = (is_null($target)) ? 0 : round((float)$datas->bebanlainya / ($target->beban_lainnya * 1000000) * 100);

            $p_labarugi = (is_null($last)) ? 0 : $datas->labarugi - $last->labarugi;
            $p_persen_labarugi = (is_null($last)) ? 0 : round((float)$p_labarugi / $last->labarugi * 100);
            $p_labarugi_penc = (is_null($target)) ? 0 : round((float)$datas->labarugi / ($target->laba_rugi * 1000000) * 100);

            return view('KinerjaKeuangan::realisasirbb.kategorikeuangan.labarugi', compact('datas', 'last', 'target', 'pendops_realisasi', 'pendops_realisasi_last', 'pendops_realisasi_target', 'p_pendops', 'p_persen_pendops', 'p_pendops_penc', 'p_bungakredit', 'p_persen_bungakredit', 'p_bungakredit_penc', 'p_bungappbl', 'p_persen_bungappbl', 'p_bungappbl_penc', 'p_pendprov', 'p_persen_pendprov', 'p_pendprov_penc', 'p_pendlainya', 'p_persen_pendlainya', 'p_pendlainya_penc', 'bunga_realisasi', 'bunga_realisasi_last', 'bunga_realisasi_target', 'bebanops_realisasi', 'bebanops_realisasi_last', 'bebanops_realisasi_target', 'p_bebanops', 'p_persen_bebanops', 'p_bebanops_penc', 'p_bunga', 'p_persen_bunga', 'p_bunga_penc', 'p_tabungan', 'p_persen_tabungan', 'p_tabungan_penc', 'p_deposito', 'p_persen_deposito', 'p_deposito_penc', 'p_sbl', 'p_persen_sbl', 'p_sbl_penc', 'p_pin_diterima', 'p_persen_pin_diterima', 'p_pin_diterima_penc', 'p_peny_kerugian', 'p_persen_peny_kerugian', 'p_peny_kerugian_penc', 'p_peny_ATI', 'p_persen_peny_ATI', 'p_peny_ATI_penc', 'p_tenaga_kerja', 'p_persen_tenaga_kerja', 'p_tenaga_kerja_penc', 'p_pendidikan', 'p_persen_pendidikan', 'p_pendidikan_penc', 'p_premi_asuransi', 'p_persen_premi_asuransi', 'p_premi_asuransi_penc', 'p_sewa', 'p_persen_sewa', 'p_sewa_penc', 'p_pemeliharaan_perbaikan', 'p_persen_pemeliharaan_perbaikan', 'p_pemeliharaan_perbaikan_penc', 'p_barangjasa', 'p_persen_barangjasa', 'p_barangjasa_penc', 'p_bebanlainya', 'p_persen_bebanlainya', 'p_bebanlainya_penc', 'p_labarugi', 'p_persen_labarugi', 'p_labarugi_penc'));
        }

        if ($data->kategori_keuangan === '3') {
            $now = DB::table('v_realisasi_rasiokeuangan')->where('id_realisasi_detail', $id)->first();
            $last = DB::table('v_realisasi_rasiokeuangan')->where('tahun', $now->tahun - 1)->where('bulan', $now->bulan)->first();

            $p_car = (is_null($last)) ? 0 : $now->car - $last->car;
            $p_npl = (is_null($last)) ? 0 : $now->npl - $last->npl;
            $p_cr = (is_null($last)) ? 0 : $now->cr - $last->cr;
            $p_ldr = (is_null($last)) ? 0 : $now->ldr - $last->ldr;
            $p_roa = (is_null($last)) ? 0 : $now->roa - $last->roa;
            $p_bopo = (is_null($last)) ? 0 : $now->bopo - $last->bopo;

            return view('KinerjaKeuangan::realisasirbb.kategorikeuangan.rasiokeuangan', compact('now', 'last', 'p_car', 'p_npl', 'p_cr', 'p_ldr', 'p_roa', 'p_bopo'));
        }

        if ($data->kategori_keuangan === '4') {
            $now = DB::table('v_realisasi_rasiopermodalan')->where('id_realisasi_detail', $id)->first();
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

            return view('KinerjaKeuangan::realisasirbb.kategorikeuangan.car', compact('now', 'last', 'p_atmr', 'p_antarbank_aktiva', 'p_kredit_diberikan', 'p_ati', 'p_rupa_aktiva', 'p_modal', 'p_modal_disetor', 'p_cadangan_umum', 'p_cadangan_tujuan', 'p_laba_rugi_thnberjalan', 'p_laba_rugi_thnlalu', 'p_modal_pelengkap', 'p_godwill', 'p_car', 'p_persen_atmr', 'p_persen_antarbank_aktiva', 'p_persen_kredit_diberikan', 'p_persen_ati', 'p_persen_rupa_aktiva', 'p_persen_modal', 'p_persen_modal_disetor', 'p_persen_cadangan_umum', 'p_persen_cadangan_tujuan', 'p_persen_laba_rugi_thnberjalan', 'p_persen_laba_rugi_thnlalu', 'p_persen_modal_pelengkap', 'p_persen_godwill', 'p_persen_car'));
        }


        if ($data->kategori_keuangan === '5') {
            $datas = DB::table('v_realisasi_rasionpl')->where('id_realisasi_detail', $id)->first();
            $datas_2 = DB::table('v_realisasi_rasionpl')->select('rasio_npl_gross')->whereBetween('tahun', [($datas->tahun - 1), $datas->tahun])->get()->toArray();
            
            $lastyear = DB::table('v_realisasi_rasionpl')->where('tahun', $datas->tahun - 1)->where('bulan', $datas->bulan)->first();
            $lastmonth = DB::table('v_realisasi_rasionpl')->where('tahun', $datas->tahun)->where('bulan', $datas->bulan - 1)->where('id_comprof', $datas->id_comprof)->first();

            $p_lancar_month = (is_null($lastmonth)) ? 0 : $datas->lancar - $lastmonth->lancar;
            $p_lancar_year = (is_null($lastyear)) ? 0 : $datas->lancar - $lastyear->lancar;
            $p_persen_lancarmonth = (is_null($lastmonth)) ? 0 : (($datas->lancar - $lastmonth->lancar) / $lastmonth->lancar) * 100;
            $p_persen_lancaryear = (is_null($lastyear)) ? 0 : (($datas->lancar - $lastyear->lancar) / $lastyear->lancar) * 100;

            $p_dalamperhatian_month = (is_null($lastmonth)) ? 0 : $datas->dalam_perhatian - $lastmonth->dalam_perhatian;
            $p_dalamperhatian_year = (is_null($lastyear)) ? 0 : $datas->dalam_perhatian - $lastyear->dalam_perhatian;
            // // $p_persen_dalamperhatianmonth = (($datas->dalam_perhatian - $lastmonth->dalam_perhatian)/$lastmonth->dalam_perhatian)*100;
            // // $p_persen_dalamperhatianyear = (($datas->dalam_perhatian - $lastyear->dalam_perhatian)/$lastyear->dalam_perhatian)*100;

            $p_kuranglancar_month = (is_null($lastmonth)) ? 0 : $datas->kurang_lancar - $lastmonth->kurang_lancar;
            $p_kuranglancar_year = (is_null($lastyear)) ? 0 : $datas->kurang_lancar - $lastyear->kurang_lancar;
            $p_persen_kuranglancarmonth = (is_null($lastmonth)) ? 0 : (($datas->kurang_lancar - $lastmonth->kurang_lancar) / $lastmonth->kurang_lancar) * 100;
            $p_persen_kuranglancaryear =  (is_null($lastyear)) ? 0 : (($datas->kurang_lancar - $lastyear->kurang_lancar) / $lastyear->kurang_lancar) * 100;

            $p_diragukan_month = (is_null($lastmonth)) ? 0 : $datas->diragukan - $lastmonth->diragukan;
            $p_diragukan_year = (is_null($lastyear)) ? 0 : $datas->diragukan - $lastyear->diragukan;
            $p_persen_diragukanmonth = (is_null($lastmonth)) ? 0 : (($datas->diragukan - $lastmonth->diragukan) / $lastmonth->diragukan) * 100;
            $p_persen_diragukanyear = (is_null($lastyear)) ? 0 : (($datas->diragukan - $lastyear->diragukan) / $lastyear->diragukan) * 100;

            $p_macet_month = (is_null($lastmonth)) ? 0 : $datas->macet - $lastmonth->macet;
            $p_macet_year = (is_null($lastyear)) ? 0 : $datas->macet - $lastyear->macet;
            $p_persen_macetmonth = (is_null($lastmonth)) ? 0 : (($datas->macet - $lastmonth->macet) / $lastmonth->macet) * 100;
            $p_persen_macetyear = (is_null($lastyear)) ? 0 : (($datas->macet - $lastyear->macet) / $lastyear->macet) * 100;

            $total = $datas->lancar + $datas->dalam_perhatian + $datas->kurang_lancar + $datas->diragukan + $datas->macet;
            $totalastyear = (is_null($lastyear)) ? 0 : $lastyear->lancar + $lastyear->dalam_perhatian + $lastyear->kurang_lancar + $lastyear->diragukan + $lastyear->macet;
            $totalastmonth = (is_null($lastmonth)) ? 0 : $lastmonth->lancar + $lastmonth->dalam_perhatian + $lastmonth->kurang_lancar + $lastmonth->diragukan + $lastmonth->macet;
            $totalnonlancar = $datas->kurang_lancar + $datas->diragukan + $datas->macet;
            $totalnonlancar_lastyear = (is_null($lastyear)) ? 0 : $lastyear->kurang_lancar + $lastyear->diragukan + $lastyear->macet;
            $totalnonlancar_lastmonth = (is_null($lastmonth)) ? 0 : $lastmonth->kurang_lancar + $lastmonth->diragukan + $lastmonth->macet;
            $total_pertumbuhan_month = $p_lancar_month + $p_dalamperhatian_month + $p_kuranglancar_month + $p_diragukan_month + $p_macet_month;
            $total_pertumbuhan_year = $p_lancar_year + $p_dalamperhatian_year + $p_kuranglancar_year + $p_diragukan_year + $p_macet_year;
            $p_persen_totalmonth = (is_null($lastmonth)) ? 0 : (($total - $totalastmonth) / $totalastmonth) * 100;
            $p_persen_totalyear = (is_null($lastyear)) ? 0 : (($total - $totalastyear) / $totalastyear) * 100;
            $total_nonlancarmonth = $p_kuranglancar_month + $p_diragukan_month + $p_macet_month;
            $total_nonlancaryear = $p_kuranglancar_year + $p_diragukan_year + $p_macet_year;

            // Declare two dates 
            $Date1 = ('01-' . $datas->bulan . '-' . ($datas->tahun - 1));
            $Date2 = ('01-' . ($datas->bulan + 1) . '-' . $datas->tahun);

            // Declare an empty array 
            $array = array();

            // Use strtotime function 
            $Variable1 = strtotime($Date1);
            $Variable2 = strtotime($Date2);

            // Use for loop to store dates into array 
            // 86400 sec = 24 hrs = 60*60*24 = 1 day * 31 = 1 Month 
            for (
                $currentDate = $Variable1;
                $currentDate <= $Variable2;
                $currentDate += (86400 * 31)
            ) {

                $Store = date('M-Y', $currentDate);
                $array[] = $Store;
            }

            // Display the dates in array format 
            $periode_bulan = $array;

            $jml_bln = count($periode_bulan);
            dd($jml_bln);
            for ($x = 0; $x <= $jml_bln; $x++) {
                $tot_npl[] = $datas_2[$x]->rasio_npl_gross;
            }


            return view('KinerjaKeuangan::realisasirbb.kategorikeuangan.rasionpl', compact('datas', 'lastyear', 'lastmonth', 'total', 'totalastyear', 'totalastmonth', 'totalnonlancar', 'totalnonlancar_lastyear', 'totalnonlancar_lastmonth', 'p_lancar_month', 'p_lancar_year', 'p_dalamperhatian_month', 'p_dalamperhatian_year', 'p_kuranglancar_month', 'p_kuranglancar_year', 'p_diragukan_month', 'p_diragukan_year', 'p_macet_month', 'p_macet_year', 'total_pertumbuhan_month', 'total_pertumbuhan_year', 'p_persen_lancarmonth', 'p_persen_kuranglancarmonth', 'p_persen_diragukanmonth', 'p_persen_totalmonth', 'p_persen_totalyear', 'p_persen_macetmonth', 'p_persen_lancaryear', 'p_persen_kuranglancaryear', 'p_persen_diragukanyear', 'p_persen_macetyear', 'total_nonlancarmonth', 'total_nonlancaryear'));
        }

        if ($data->kategori_keuangan === '6') {
            $datas = DB::table('v_realisasi_kolekpersektor')->where('id_realisasi_detail', $id)->first();

            $jumlah = $datas->produktif + $datas->konsumtif;
            $p_produktif = ($datas->produktif / $jumlah) * 100;
            $p_konsumtif = ($datas->konsumtif / $jumlah) * 100;

            return view('KinerjaKeuangan::realisasirbb.kategorikeuangan.kolekpersektor', compact('datas', 'jumlah', 'p_produktif', 'p_konsumtif'));
        }

        if ($data->kategori_keuangan === '7') {
            $datas = DB::table('v_realisasi_cashrasio')->where('id_realisasi_detail', $id)->first();
            $lastyear = DB::table('v_realisasi_cashrasio')->where('tahun', $datas->tahun - 1)->where('bulan', $datas->bulan)->first();
            // dd($datas->hutang_bungapajak, $lastyear->hutang_bungapajak);exit;

            $p_persen_cashrasio = (is_null($lastyear)) ? 0 : $datas->cash_rasio - $lastyear->cash_rasio;
            $p_alatliquid = (is_null($lastyear)) ? 0 : $datas->alat_liquid - $lastyear->alat_liquid;
            $p_persen_alatliquid = (is_null($lastyear)) ? 0 : (($datas->alat_liquid - $lastyear->alat_liquid) / $lastyear->alat_liquid) * 100;
            $p_kas = (is_null($lastyear)) ? 0 : $datas->kas - $lastyear->kas;
            $p_persen_kas = (is_null($lastyear)) ? 0 : (($datas->kas - $lastyear->kas) / $lastyear->kas) * 100;
            $p_giro = (is_null($lastyear)) ? 0 : $datas->giro - $lastyear->giro;
            $p_persen_giro = (is_null($lastyear)) ? 0 : (($datas->giro - $lastyear->giro) / $lastyear->giro) * 100;
            $p_tabungan = (is_null($lastyear)) ? 0 : $datas->tabungan - $lastyear->tabungan;
            $p_persen_tabungan = (is_null($lastyear)) ? 0 : (($datas->tabungan - $lastyear->tabungan) / $lastyear->tabungan) * 100;
            $p_hutanglancar = (is_null($lastyear)) ? 0 : $datas->hutang_lancar - $lastyear->hutang_lancar;
            $p_persen_hutanglancar = (is_null($lastyear)) ? 0 : (($datas->hutang_lancar - $lastyear->hutang_lancar) / $lastyear->hutang_lancar) * 100;
            $p_kewajibansegera = (is_null($lastyear)) ? 0 : $datas->kewajiban_segera - $lastyear->kewajiban_segera;
            $p_persen_kewajibansegera = (is_null($lastyear)) ? 0 : (($datas->kewajiban_segera - $lastyear->kewajiban_segera) / $lastyear->kewajiban_segera) * 100;
            $p_hutang_bungapajak = (is_null($lastyear)) ? 0 : $datas->hutang_bungapajak - $lastyear->hutang_bungapajak;
            $p_persen_hutangbungapajak = ((is_null($lastyear)) || (is_null($datas->hutang_bungapajak))) ? 0 : (($datas->hutang_bungapajak - $lastyear->hutang_bungapajak) / $lastyear->hutang_bungapajak) * 100;
            $p_deposito = (is_null($lastyear)) ? 0 : $datas->deposito - $lastyear->deposito;
            $p_persen_deposito = (is_null($lastyear)) ? 0 : (($datas->deposito - $lastyear->deposito) / $lastyear->deposito) * 100;
            $p_Tabungan = (is_null($lastyear)) ? 0 : $datas->Tabungan - $lastyear->Tabungan;
            $p_persen_Tabungan = (is_null($lastyear)) ? 0 : (($datas->Tabungan - $lastyear->Tabungan) / $lastyear->Tabungan) * 100;

            return view('KinerjaKeuangan::realisasirbb.kategorikeuangan.cashrasio', compact('datas', 'lastyear', 'p_persen_cashrasio', 'p_alatliquid', 'p_kas', 'p_giro', 'p_tabungan', 'p_hutanglancar', 'p_kewajibansegera', 'p_hutang_bungapajak', 'p_deposito', 'p_Tabungan', 'p_persen_alatliquid', 'p_persen_kas', 'p_persen_giro', 'p_persen_tabungan', 'p_persen_hutanglancar', 'p_persen_kewajibansegera', 'p_persen_hutangbungapajak', 'p_persen_deposito', 'p_persen_Tabungan'));
        }

        if ($data->kategori_keuangan === '8') {
            $datas = DB::table('v_realisasi_ldr')->where('id_realisasi_detail', $id)->first();
            $lastyear = DB::table('v_realisasi_ldr')->where('tahun', $datas->tahun - 1)->where('bulan', $datas->bulan)->first();

            $p_persen_ldr = (is_null($lastyear)) ? 0 : $datas->ldr - $lastyear->ldr;
            $p_kreditdiberikan = (is_null($lastyear)) ? 0 : $datas->kredit_diberikan - $lastyear->kredit_diberikan;
            $p_persen_kreditdiberikan = (is_null($lastyear)) ? 0 : (($datas->kredit_diberikan - $lastyear->kredit_diberikan) / $lastyear->kredit_diberikan) * 100;
            $p_simpananpihaktiga = (is_null($lastyear)) ? 0 : $datas->simpanan_pihaktiga - $lastyear->simpanan_pihaktiga;
            $p_persen_simpananpihaktiga = (is_null($lastyear)) ? 0 : (($datas->simpanan_pihaktiga - $lastyear->simpanan_pihaktiga) / $lastyear->simpanan_pihaktiga) * 100;
            $p_deposito = (is_null($lastyear)) ? 0 : $datas->deposito - $lastyear->deposito;
            $p_persen_deposito = (is_null($lastyear)) ? 0 : (($datas->deposito - $lastyear->deposito) / $lastyear->deposito) * 100;
            $p_tabungan = (is_null($lastyear)) ? 0 : $datas->tabungan - $lastyear->tabungan;
            $p_persen_tabungan = (is_null($lastyear)) ? 0 : (($datas->tabungan - $lastyear->tabungan) / $lastyear->tabungan) * 100;
            $p_pinjamanditerima = (is_null($lastyear)) ? 0 : $datas->pinjaman_diterima - $lastyear->pinjaman_diterima;
            $p_persen_pinjamanditerima = (is_null($lastyear)) ? 0 : (($datas->pinjaman_diterima - $lastyear->pinjaman_diterima) / $lastyear->pinjaman_diterima) * 100;
            $p_antarbankpasiva = (is_null($lastyear)) ? 0 : $datas->antarbank_pasiva - $lastyear->antarbank_pasiva;
            $p_persen_antarbankpasiva = (is_null($lastyear)) ? 0 : (($datas->antarbank_pasiva - $lastyear->antarbank_pasiva) / $lastyear->antarbank_pasiva) * 100;
            $p_modalinti = (is_null($lastyear)) ? 0 : $datas->modal_inti - $lastyear->modal_inti;
            $p_persen_modalinti = (is_null($lastyear)) ? 0 : (($datas->modal_inti - $lastyear->modal_inti) / $lastyear->modal_inti) * 100;

            return view('KinerjaKeuangan::realisasirbb.kategorikeuangan.ldr', compact('datas', 'lastyear', 'p_persen_ldr', 'p_kreditdiberikan', 'p_simpananpihaktiga', 'p_deposito', 'p_tabungan', 'p_pinjamanditerima', 'p_antarbankpasiva', 'p_modalinti', 'p_persen_kreditdiberikan', 'p_persen_simpananpihaktiga', 'p_persen_deposito', 'p_persen_tabungan', 'p_persen_pinjamanditerima', 'p_persen_antarbankpasiva', 'p_persen_modalinti'));
        }
        if ($data->kategori_keuangan === '9') {
            $datas = DB::table('v_realisasi_roa')->where('id_realisasi_detail', $id)->first();
            $lastyear = DB::table('v_realisasi_roa')->where('tahun', $datas->tahun - 1)->where('bulan', $datas->bulan)->first();

            $p_persen_roa = (is_null($lastyear)) ? 0 : $datas->roa - $lastyear->roa;
            $p_aset = (is_null($lastyear)) ? 0 : $datas->aset - $lastyear->aset;
            $p_persen_aset = (is_null($lastyear)) ? 0 : (($datas->aset - $lastyear->aset) / $lastyear->aset) * 100;
            $p_labasebelumpajak = (is_null($lastyear)) ? 0 : $datas->laba_sebelum_pajak - $lastyear->laba_sebelum_pajak;
            $p_persen_labasebelumpajak = (is_null($lastyear)) ? 0 : (($datas->laba_sebelum_pajak - $lastyear->laba_sebelum_pajak) / $lastyear->laba_sebelum_pajak) * 100;

            return view('KinerjaKeuangan::realisasirbb.kategorikeuangan.roa', compact('datas', 'lastyear', 'p_persen_roa', 'p_aset', 'p_labasebelumpajak', 'p_persen_aset', 'p_persen_labasebelumpajak'));
        }
        if ($data->kategori_keuangan === '10') {
            $datas = DB::table('v_realisasi_bopo')->where('id_realisasi_detail', $id)->first();
            $lastyear = DB::table('v_realisasi_bopo')->where('tahun', $datas->tahun - 1)->where('bulan', $datas->bulan)->first();

            $p_persen_bopo = (is_null($lastyear)) ? 0 :  $datas->bopo - $lastyear->bopo;
            $p_bebanoperasional = (is_null($lastyear)) ? 0 : $datas->beban_operasional - $lastyear->beban_operasional;
            $p_persen_bebanoperasional = (is_null($lastyear)) ? 0 : (($datas->beban_operasional - $lastyear->beban_operasional) / $lastyear->beban_operasional) * 100;
            $p_pendapatanoperasional = (is_null($lastyear)) ? 0 : $datas->pendapatan_operasional - $lastyear->pendapatan_operasional;
            $p_persen_pendapatanoperasional = (is_null($lastyear)) ? 0 : (($datas->pendapatan_operasional - $lastyear->pendapatan_operasional) / $lastyear->pendapatan_operasional) * 100;

            return view('KinerjaKeuangan::realisasirbb.kategorikeuangan.bopo', compact('datas', 'lastyear', 'p_persen_bopo', 'p_bebanoperasional', 'p_pendapatanoperasional', 'p_persen_bebanoperasional', 'p_persen_pendapatanoperasional'));
        }
        if ($data->kategori_keuangan === '11') {
            $datas = DB::table('v_realisasi_tingkatkesehatan')->where('id_realisasi_detail', $id)->first();
            $lastyear = DB::table('v_realisasi_tingkatkesehatan')->where('tahun', $datas->tahun - 1)->where('bulan', $datas->bulan)->first();

            $total_reward_last = (is_null($lastyear)) ? 0 : $lastyear->bobot_car + $lastyear->bobot_kap + $lastyear->bobot_ppap + $lastyear->bobot_cr + $lastyear->bobot_ldr + $lastyear->bobot_roa + $lastyear->bobot_bopo + $lastyear->manajemen_umum;
            $total_reward_current = $datas->bobot_car + $datas->bobot_kap + $datas->bobot_ppap + $datas->bobot_cr + $datas->bobot_ldr + $datas->bobot_roa + $datas->bobot_bopo + $datas->manajemen_umum;
            // $total_reward_current = 66;

            return view('KinerjaKeuangan::realisasirbb.kategorikeuangan.tingkatkesehatan', compact('datas', 'lastyear', 'total_reward_current', 'total_reward_last'));
        }
        if ($data->kategori_keuangan === '12') {
            $datas = DB::table('v_realisasi_nsfr')->where('id_realisasi_detail', $id)->first();
            $lastyear = DB::table('v_realisasi_nsfr')->where('tahun', $datas->tahun - 1)->where('bulan', $datas->bulan)->first();

            return view('KinerjaKeuangan::realisasirbb.kategorikeuangan.nsfr', compact('datas', 'lastyear'));
        }
        if ($data->kategori_keuangan === '13') {
            $datas = DB::table('v_realisasi_lcr')->where('id_realisasi_detail', $id)->first();
            $lastyear = DB::table('v_realisasi_lcr')->where('tahun', $datas->tahun - 1)->where('bulan', $datas->bulan)->first();

            return view('KinerjaKeuangan::realisasirbb.kategorikeuangan.lcr', compact('datas', 'lastyear'));
        }
    }

    /**
     * @param Request $request
     * @param RealisasiRBB $realisasi_rbb
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, RealisasiRBB $realisasi_rbb) //Hapus Realisasi RBB
    {
        // dd($realisasi_rbb);exit;
        $company_name = to_dropdown(Comprof::where('status', 1)->where('id', $realisasi_rbb->id_comprof)->get(), 'id', 'company_name');
        foreach ($company_name as $key => $value) {
            $company_name = $value;
        }

        $message = ['key' => 'Rkat Audit', 'value' => $company_name . ' Periode ' . $realisasi_rbb->bulan . ' Tahun ' . $realisasi_rbb->tahun];
        $status = 'error';
        $response = trans('message.delete_failed', $message);
        $det = RealisasiRBBDetail::where('id_realisasirbb', $realisasi_rbb->id)->get();

        // dd($realisasi_rbb->id, $det);exit;
        if ($realisasi_rbb->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);

            DB::table('app_realisasirbb_detail')->where('id_realisasirbb', $realisasi_rbb->id)->delete();
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('realisasi-rbb')->with($status, $response);
    }

    /**
     * @param Request $request
     * @param RealisasiRBB $realisasi_rbb
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function hapusKategori(Request $request, $id) //Hapus Realisasi RBB Detail
    {
        $data = RealisasiRBBDetail::findOrFail($id);
        $kategori_keuangan = to_dropdown(OptionValue::where('option_group_id', '3d29d1de-6eb9-473e-a78c-1b2ae38cc55d')->where('key', $data->kategori_keuangan)->get(), 'key', 'value');

        foreach ($kategori_keuangan as $key => $value) {
            $kategori_keuangan = $value;
        }

        $message = ['key' => 'Kategori Keuangan', 'value' => $kategori_keuangan];
        // dd($data);exit;
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($data->kategori_keuangan === '1') {
            if ($data->delete()) {
                $status = 'success';
                $response = trans('message.delete_success', $message);
                PerkembanganVolumeUsaha::where('id_realisasi_detail', $id)->delete();
                Temp100::where('id_realisasi_detail', $id)->delete();
            }
        }
        if ($data->kategori_keuangan === '2') {
            if ($data->delete()) {
                $status = 'success';
                $response = trans('message.delete_success', $message);
                LabaRugi::where('id_realisasi_detail', $id)->delete();
                Temp008::where('id_realisasi_detail', $id)->delete();
            }
        }
        if ($data->kategori_keuangan === '3') {
            if ($data->delete()) {
                $status = 'success';
                $response = trans('message.delete_success', $message);
                RasioKeuangan::where('id_realisasi_detail', $id)->delete();
            }
        }
        if ($data->kategori_keuangan === '4') {
            if ($data->delete()) {
                $status = 'success';
                $response = trans('message.delete_success', $message);
                RasioPermodalan::where('id_realisasi_detail', $id)->delete();
            }
        }
        if ($data->kategori_keuangan === '5') {
            if ($data->delete()) {
                $status = 'success';
                $response = trans('message.delete_success', $message);
                RasioNpl::where('id_realisasi_detail', $id)->delete();
                Temp600::where('id_realisasi_detail', $id)->delete();
            }
        }
        if ($data->kategori_keuangan === '6') {
            if ($data->delete()) {
                $status = 'success';
                $response = trans('message.delete_success', $message);
                KolekPersektor::where('id_realisasi_detail', $id)->delete();
            }
        }
        if ($data->kategori_keuangan === '7') {
            if ($data->delete()) {
                $status = 'success';
                $response = trans('message.delete_success', $message);
                CashRasio::where('id_realisasi_detail', $id)->delete();
            }
        }
        if ($data->kategori_keuangan === '8') {
            if ($data->delete()) {
                $status = 'success';
                $response = trans('message.delete_success', $message);
                LDR::where('id_realisasi_detail', $id)->delete();
            }
        }
        if ($data->kategori_keuangan === '9') {
            if ($data->delete()) {
                $status = 'success';
                $response = trans('message.delete_success', $message);
                ROA::where('id_realisasi_detail', $id)->delete();
            }
        }
        if ($data->kategori_keuangan === '10') {
            if ($data->delete()) {
                $status = 'success';
                $response = trans('message.delete_success', $message);
                BOPO::where('id_realisasi_detail', $id)->delete();
            }
        }
        if ($data->kategori_keuangan === '11') {
            if ($data->delete()) {
                $status = 'success';
                $response = trans('message.delete_success', $message);
                TingkatKesehatan::where('id_realisasi_detail', $id)->delete();
            }
        }
        if ($data->kategori_keuangan === '12') {
            if ($data->delete()) {
                $status = 'success';
                $response = trans('message.delete_success', $message);
                NSFR::where('id_realisasi_detail', $id)->delete();
            }
        }
        if ($data->kategori_keuangan === '13') {
            if ($data->delete()) {
                $status = 'success';
                $response = trans('message.delete_success', $message);
                LCR::where('id_realisasi_detail', $id)->delete();
            }
        }
        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        // return redirect('realisasi-rbb')->with($status, $response);
        return redirect()->back()->with($status, $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Throwable
     */
    public function export(Request $request, $id)
    {

        $data = RealisasiRBBDetail::findOrFail($id);
        $datas = RealisasiRBB::where('id', $data->id_realisasirbb)->first();
        $company_name = to_dropdown(Comprof::where('status', 1)->where('id', $datas->id_comprof)->get(), 'id', 'company_name');
        foreach ($company_name as $key => $value) {
            $company_name = $value;
        }
        $name = str_replace(' ', '_', $company_name);
        if ($data->kategori_keuangan == 1) {
            $filename = 'PERKEMBANGAN_VOLUME_USAHA_' . $name . '_' . now()->format('YmdHis');
        }
        if ($data->kategori_keuangan == 2) {
            $filename = 'LABA_RUGI_' . $name . '_' . now()->format('YmdHis');
        }
        if ($data->kategori_keuangan == 3) {
            $filename = 'RASIO_KEUANGAN_' . $name . '_' . now()->format('YmdHis');
        }
        if ($data->kategori_keuangan == 4) {
            $filename = 'RASIO_PERMODALAN_' . $name . '_' . now()->format('YmdHis');
        }
        if ($data->kategori_keuangan == 5) {
            $filename = 'RASIO_NPL_' . $name . '_' . now()->format('YmdHis');
        }
        if ($data->kategori_keuangan == 6) {
            $filename = 'KOLEK_PERSEKTOR_' . $name . '_' . now()->format('YmdHis');
        }
        if ($data->kategori_keuangan == 7) {
            $filename = 'CASH_RASIO_' . $name . '_' . now()->format('YmdHis');
        }
        if ($data->kategori_keuangan == 8) {
            $filename = 'LDR_' . $name . '_' . now()->format('YmdHis');
        }
        if ($data->kategori_keuangan == 9) {
            $filename = 'ROA_' . $name . '_' . now()->format('YmdHis');
        }
        if ($data->kategori_keuangan == 10) {
            $filename = 'BOPO_' . $name . '_' . now()->format('YmdHis');
        }
        if ($data->kategori_keuangan == 11) {
            $filename = 'TINGKAT_KESEHATAN_BANK_' . $name . '_' . now()->format('YmdHis');
        }
        if ($data->kategori_keuangan == 12) {
            $filename = 'NSFR_' . $name . '_' . now()->format('YmdHis');
        }
        if ($data->kategori_keuangan == 13) {
            $filename = 'LCR_' . $name . '_' . now()->format('YmdHis');
        }

        return (new \Modules\KinerjaKeuangan\Exports\KategoriKeuanganExport($id))
            ->download($filename . '.xls', \Maatwebsite\Excel\Excel::XLS);
    }
}
