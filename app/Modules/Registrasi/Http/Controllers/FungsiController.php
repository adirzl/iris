<?php

namespace Modules\Registrasi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Knp\Snappy\Pdf;
use Modules\UIM\Entities\UnitKerja;
use Modules\Registrasi\Entities\Fungsi;
use Modules\Registrasi\Entities\Aplikasi;
use Modules\Registrasi\Http\Requests\StoreFungsiRequest;
use Modules\Registrasi\Http\Requests\UpdateFungsiRequest;

class FungsiController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = Fungsi::fetch($request);
        $aplikasi = to_dropdown(Aplikasi::all(), 'id', 'nama');

        return view('registrasi::fungsi.default', compact('data', 'aplikasi'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $aplikasi = to_dropdown(Aplikasi::all(), 'id', 'nama');
        $unitkerja = to_dropdown(UnitKerja::all(), 'kode_cabang', 'nama_cabang');

        return view('registrasi::fungsi.create', compact('aplikasi', 'unitkerja'));
    }

    /**
     * @param StoreFungsiRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreFungsiRequest $request)
    {
        $aplikasiId = $request->only('reg_aplikasi_id')['reg_aplikasi_id'];
        $fungsi = $request->only(['nama', 'menu', 'akses1', 'akses2', 'limit_debit', 'limit_kredit', 'spv', 'status']);
        $n = count($fungsi['nama']);
        $success = 0;

        for ($i = 0; $i < $n; $i++) {
            $registrasi_aplikasi_fungsi = Fungsi::create([
                'reg_aplikasi_id' => $aplikasiId,
                'nama' => $fungsi['nama'][$i],
                'menu' => $fungsi['menu'][$i],
                'akses1' => $fungsi['akses1'][$i],
                'akses2' => $fungsi['akses2'][$i],
                'limit_debit' => $fungsi['limit_debit'][$i],
                'limit_kredit' => $fungsi['limit_kredit'][$i],
                'spv' => $fungsi['spv'][$i],
                'status' => $fungsi['status'][$i]
            ]);
            
            if ($registrasi_aplikasi_fungsi) {
                ++$success;
                Http::post('http://'. config('parameter.app_server') . ':5100/api/aplikasi-fungsi', [
                    'id' => $registrasi_aplikasi_fungsi->id
                ]);
            }
        }

        $message = ['key' => 'Register Aplikasi Fungsi', 'value' => implode(', ', $fungsi['nama'])];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($success > 0) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('registrasi-aplikasi-fungsi.create')->with($status, $response);
        }

        return redirect('registrasi-aplikasi-fungsi')->with($status, $response);
    }

    /**
     * @param Aplikasi $registrasi_aplikasi_fungsi
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Fungsi $registrasi_aplikasi_fungsi)
    {
        $aplikasi = to_dropdown(Aplikasi::all(), 'id', 'nama');
        $unitkerja = to_dropdown(UnitKerja::all(), 'kode_cabang', 'nama_cabang');
        
        return view('registrasi::fungsi.edit', compact('registrasi_aplikasi_fungsi', 'aplikasi', 'unitkerja'));
    }

    /**
     * @param UpdateFungsiRequest $request
     * @param Fungsi $registrasi_aplikasi_fungsi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateFungsiRequest $request, Fungsi $registrasi_aplikasi_fungsi)
    {
        $values = $request->except(['_token', '_method']);

        foreach ($values as $key => $value) {
            $registrasi_aplikasi_fungsi->$key = $value;
        }

        $message = ['key' => 'Registrasi Aplikasi', 'value' => $registrasi_aplikasi_fungsi->nama];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        if ($registrasi_aplikasi_fungsi->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
            Http::put('http://'. config('parameter.app_server') . ':5100/api/aplikasi-fungsi', [
                'id' => $registrasi_aplikasi_fungsi->id
            ]);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('registrasi-aplikasi-fungsi')->with($status, $response);
    }

    /**
     * @param Request $request
     * @param Fungsi $registrasi_aplikasi_fungsi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sinkronisasi(Request $request, Fungsi $registrasi_aplikasi_fungsi)
    {
        $client = Http::post('http://'. config('parameter.app_server') . ':5100/api/aplikasi-fungsi', ['id' => $registrasi_aplikasi_fungsi->id]);
        $status = $client->ok() ? 'success' : 'error';
        $message = $client->json()['message'];

        if ($request->ajax()) {
            return response()->json(['message' => $message, 'status' => $status]);
        }

        return redirect('registrasi-aplikasi-fungsi')->with($status, $message);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Throwable
     */
    public function export(Request $request)
    {
        ini_set('memory_limit', -1);
        $filename = 'REG_APPFUNGSI_' . now()->format('YmdHis');

        if ($request->type === 'xls') {
            return (new \Modules\Registrasi\Exports\FungsiExport($request))
                ->download($filename . '.xls', \Maatwebsite\Excel\Excel::XLS);
        } else {
            $data = Fungsi::fetch($request, true);
            $pdf = new Pdf(config('misc.wkhtmltopdf'));
            $html = view('registrasi::fungsi.pdf', compact('data'))->render();
            header('Content-Type: application.pdf');
            header('Content-Disposition: attachment; filename=' . $filename . '.pdf');
            echo $pdf->getOutputFromHtml($html, ['orientation' => 'Landscape']);
        }
    }
}
