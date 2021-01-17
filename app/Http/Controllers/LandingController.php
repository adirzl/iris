<?php

namespace App\Http\Controllers;

use App\Entities\UserLocal;
use Illuminate\Http\Request;
use Modules\Kelola\Entities\Banner;
use Modules\Kelola\Entities\Artikel;
use Modules\Kelola\Entities\Laporan;
use Modules\Kelola\Entities\Profil;
use Modules\Kelola\Entities\Comprof;
use Modules\Kelola\Entities\Regulasi;
use Modules\Kelola\Entities\Struktur;
use Modules\Kelola\Entities\TugasWewenang;
use Illuminate\Support\Facades\Auth;
use Modules\IsiKuisioner\Entities\IsiKuisioner;
use Modules\IsiKuisioner\Entities\IsiKuisionerDetail;
use Modules\Kuisioner\Entities\Penilaian;
use Modules\Kuisioner\Entities\Pertanyaan;
use Knp\Snappy\Pdf;
use Modules\FileType\Entities\FileArchive;
use Modules\FileType\Entities\FileType;
use Modules\HCS\Entities\UnitKerja;
use Validator;

class LandingController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = Banner::get();
        $data_artikel = Artikel::where('status', 1)->orderBy('created_at', 'DESC')->get();
        return view('landing.index', compact('data', 'data_artikel'));
    }


    public function detail($id){
        $unitkerja = UnitKerja::findOrFail($id);
        dd($unitkerja);
        $fileType = FileType::where('unitkerja_kode', $id)->get();
        $data = FileArchive::join('app_filetype as ft', 'ft.id', 'app_filearchive.fileType')->where('ft.unitkerja_kode', $id)->get();
        return view('landing.detail', compact('data', 'unitkerja', 'fileType'));
    }

    public function login_iris()
    {
        return view('auth.login');
    }

    public function tentang_kk()
    {
        $data = Profil::get()->where('status', 1);
        foreach ($data as $v)
            return view('landing.tentang_kk', compact('v'));
    }

    public function sekilas_kk()
    {
        $data = Profil::get()->where('status', 2);
        foreach ($data as $v)
            return view('landing.sekilas_kk', compact('v'));
    }

    public function struktur_kk()
    {
        $data = Profil::get()->where('status', 3);
        foreach ($data as $v)
            return view('landing.struktur_kk', compact('v'));
    }

    public function comp_prof_kk()
    {
        $data = Comprof::get()->where('status', 1);
        return view('landing.company_profile_kk', compact('data'));
    }

    public function comp_prof_kk_detail(Request $request, $id)
    {
        $data = Comprof::findOrFail($id);
        return view('landing.company_profile_kk_detail', compact('data'));
    }

    public function tugas_wew_kk()
    {
        $data = TugasWewenang::get()->where('status_data', 1);
        $data2 = TugasWewenang::get()->where('status_data', 2);
        $i = 0;
        $jml = $data->count();
        $j = 0;
        $jml2 = $data2->count();
        return view('landing.tugas_wewenang_kk', compact('data', 'data2', 'jml', 'jml2', 'i', 'j'));
    }

    public function tentang_kinke()
    {
        $data = Profil::get()->where('status', 4);
        foreach ($data as $v)
            return view('landing.tentang_kinke', compact('v'));
    }

    public function report_sumber()
    {
        return view('landing.report_sumber_data');
    }

    public function kajian_kinke()
    {
        $data = Laporan::orderBy('created_at','DESC')->where('status', 1)->get();
        return view('landing.kajian_kinke', compact('data'));
    }

    public function regulasi()
    {
        $data = Regulasi::where('status', 1)->orderBy('created_at', 'DESC')->paginate(5);
        return view('landing.regulasi', compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function regulasi_content(Request $request, $id)
    {
        $data = Regulasi::findOrFail($id);
        $data_regulasi = Regulasi::where('status', 1)->orderBy('created_at', 'DESC')->paginate(5);
        return view('landing.regulasi_content', compact('data', 'data_regulasi'));
    }

    public function berita()
    {
        $data = Artikel::where('status', 1)->orderBy('created_at', 'DESC')->paginate(5);
        return view('landing.berita', compact('data'));
    }

    public function berita_content(Request $request, $id)
    {
        $data = Artikel::findOrFail($id);
        $data_artikel = Artikel::where('status', 1)->orderBy('created_at', 'DESC')->paginate(5);
        return view('landing.berita_content', compact('data', 'data_artikel'));
    }

    public function tentang_tatakelola()
    {
        $data = Profil::get()->where('status', 5);
        foreach ($data as $v)
            return view('landing.tentang_tatakelola', compact('v'));
    }

    public function tentang_manrisk()
    {
        $data = Profil::get()->where('status', 6);
        foreach ($data as $v)
            return view('landing.tentang_manrisk', compact('v'));
    }

    public function tentang_kepatuhan()
    {
        $data = Profil::get()->where('status', 8);
        foreach ($data as $v)
            return view('landing.tentang_kepatuhan', compact('v'));
    }

    public function tentang_audit()
    {
        $data = Profil::get()->where('status', 10);
        foreach ($data as $v)
            return view('landing.tentang_audit_internal', compact('v'));
    }

    public function rencana_kerja_manrisk()
    {
        $data = Profil::get()->where('status', 7);
        foreach ($data as $v)
            return view('landing.rencana_kerja_tahunan_manrisk', compact('v'));
    }

    public function rencana_kerja_kepatuhan()
    {
        $data = Profil::get()->where('status', 9);
        foreach ($data as $v)
            return view('landing.rencana_kerja_tahunan_kepatuhan', compact('v'));
    }

    public function rencana_kerja_audit()
    {
        $data = Profil::get()->where('status', 11);
        foreach ($data as $v)
            return view('landing.rencana_kerja_tahunan_audit', compact('v'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function report_kuisioner_manrisk(Request $request)
    {
        $data = Penilaian::where('status_kuisioner', 1)->where('status', 2)->fetch($request);
        $i = 1;
        return view('landing.laporan_kuisioner_manrisk', compact('data','i'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Throwable
     */
    public function export(Request $request, $id)
    {
        $kuisioner = IsiKuisioner::findOrFail($id);
        $periode = $kuisioner->periode;
        $nama_perusahaan = Comprof::where('status', 1)->where('id', $kuisioner->nama_perusahaan)->get();
        foreach ($nama_perusahaan as $item);
        $nama_perusahaan = $item->company_name;
        if ($kuisioner->status_kuisioner == 1) {
            $filename = str_replace(" ", '_', $nama_perusahaan) . '_' . 'KUISIONER_MANRISK_' . 'Periode-' . $periode . '_' . now()->format('YmdHis');
        } else {
            $filename = str_replace(" ", '_', $nama_perusahaan) . '_' . 'KUISIONER_KEPATUHAN_' . 'Periode-' . $periode . '_' . now()->format('YmdHis');
        }

        if ($request->type == 'xls') {
            // dd('A');
            return (new \Modules\Kuisioner\Exports\KuisionerExport($id, $nama_perusahaan))
                ->download($filename . '.xls', \Maatwebsite\Excel\Excel::XLS);
        } else {
            $kuisioner = IsiKuisioner::findOrFail($id);
            $data_penilaian = IsiKuisionerDetail::where('id_induk', $id)->get();
            if ($kuisioner->status_kuisioner == 1) {
                $data_pertanyaan = Pertanyaan::with('detail_pertanyaan')->where('status_user', 1)->where('status', 1)->get();
            } else {
                $data_pertanyaan = Pertanyaan::with('detail_pertanyaan')->where('status_user', 2)->where('status', 1)->get();
            }
            $file_jawaban = 'file';
            $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
            $pdf = new Pdf(config('misc.wkhtmltopdf'));
            $html = view('kuisioner::penilaian.pdf', compact('kuisioner', 'data_penilaian', 'data_pertanyaan', 'file_jawaban', 'company_name'))->render();
            header('Content-Type: application.pdf');
            header('Content-Disposition: attachment; filename=' . $filename . '.pdf');
            echo $pdf->getOutputFromHtml($html, ['orientation' => 'Landscape']);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function report_kuisioner_kepatuhan(Request $request)
    {
        $data = Penilaian::where('status_kuisioner', 2)->where('status', 2)->fetch($request);
        $i = 1;
        return view('landing.laporan_kuisioner_kepatuhan',compact('data','i'));
    }

    public function report_kuisioner_audit()
    {
        return view('landing.laporan_kuisioner_audit');
    }

    public function login()
    {
        return view('landing.login');
    }

    public function ceklogin(REQUEST $request)
    {
        $rules = [
            'username'              => 'required',
            'password'              => 'required|string'
        ];

        $messages = [
            'username.required'     => 'Email wajib diisi',
            'password.required'     => 'Password wajib diisi',
            'password.string'       => 'Password harus berupa string'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
            'username'  => $request->input('username'),
            'password'  => $request->input('password'),
        ];


        $a = UserLocal::attempt($data);
        dd($a);
        if (Auth::check()) {
            return redirect()->route('home');
        } else {
            return redirect()->route('landing');
        }
    }
}
