<?php
namespace Modules\Registrasi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Knp\Snappy\Pdf;
use Modules\Registrasi\Entities\Aplikasi;
use Modules\Registrasi\Http\Requests\AplikasiRequest;

class AplikasiController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = Aplikasi::fetch($request);

        return view('registrasi::aplikasi.default', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $registrasi_aplikasi = new Aplikasi;
        $registrasi_aplikasi->idaplikasi = Aplikasi::sequenceIdAplikasi();

        return view('registrasi::aplikasi.form', compact('registrasi_aplikasi'));
    }

    /**
     * @param AplikasiRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(AplikasiRequest $request)
    {
        $values = $request->except(['_token', 'save']);
        $aplikasi = Aplikasi::create($values);
        $message = ['key' => 'Register Aplikasi', 'value' => $values['nama']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($aplikasi) {
            $status = 'success';
            $response = trans('message.create_success', $message);
            Http::post('http://'. config('parameter.app_server') . ':5100/api/aplikasi', [
                'id' => $aplikasi->id
            ]);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('registrasi-aplikasi.create')->with($status, $response);
        }

        return redirect('registrasi-aplikasi')->with($status, $response);
    }

    /**
     * @param Aplikasi $registrasi_aplikasi
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Aplikasi $registrasi_aplikasi)
    {
        return view('registrasi::aplikasi.form', compact('registrasi_aplikasi'));
    }

    /**
     * @param AplikasiRequest $request
     * @param Aplikasi $registrasi_aplikasi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(AplikasiRequest $request, Aplikasi $registrasi_aplikasi)
    {
        $values = $request->except(['_token', '_method']);

        foreach ($values as $key => $value) {
            $registrasi_aplikasi->$key = $value;
        }

        $message = ['key' => 'Register Aplikasi', 'value' => $registrasi_aplikasi->nama];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        if ($registrasi_aplikasi->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
            Http::put('http://' . config('parameter.app_server') . ':5100/api/aplikasi', [
                'id' => $registrasi_aplikasi->id
            ]);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('registrasi-aplikasi')->with($status, $response);
    }

    /**
     * @param Request $request
     * @param Aplikasi $registrasi_aplikasi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sinkronisasi(Request $request, Aplikasi $registrasi_aplikasi)
    {
        $client = Http::post('http://' . config('parameter.app_server') . ':5100/api/aplikasi', ['id' => $registrasi_aplikasi->id]);
        $status = $client->ok() ? 'success' : 'error';
        $message = $client->json()['message'];

        if ($request->ajax()) {
            return response()->json(['message' => $message, 'status' => $status]);
        }

        return redirect('registrasi-aplikasi')->with($status, $message);
    }

    /**
     * @param Request $request
     * @param Aplikasi $registrasi_aplikasi
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Throwable
     */
    public function matriks(Request $request, Aplikasi $registrasi_aplikasi)
    {
        ini_set('memory_limit', -1);
        $filename = 'MATRIKS_' . to_upper($registrasi_aplikasi->nama);
        $pdf = new Pdf(config('misc.wkhtmltopdf'));
        $html = view('registrasi::aplikasi.matriks', compact('registrasi_aplikasi'))->render();
        header('Content-Type: application.pdf');
        header('Content-Disposition: attachment; filename=' . $filename . '.pdf');
        echo $pdf->getOutputFromHtml($html, ['orientation' => 'Landscape']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Throwable
     */
    public function export(Request $request)
    {
        ini_set('memory_limit', -1);
        $filename = 'REG_APLIKASI_' . now()->format('YmdHis');

        if ($request->type === 'xls') {
            return (new \Modules\Registrasi\Exports\AplikasiExport($request))
                ->download($filename . '.xls', \Maatwebsite\Excel\Excel::XLS);
        } else {
            $data = Aplikasi::fetch($request, true);
            $pdf = new Pdf(config('misc.wkhtmltopdf'));
            $html = view('registrasi::aplikasi.pdf', compact('data'))->render();
            header('Content-Type: application.pdf');
            header('Content-Disposition: attachment; filename=' . $filename . '.pdf');
            echo $pdf->getOutputFromHtml($html, ['orientation' => 'Landscape']);
        }
    }
}