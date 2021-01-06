<?php

namespace Modules\Sinkronisasi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Knp\Snappy\Pdf;
use Modules\Sinkronisasi\Entities\Pegawai;

class PegawaiController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = Pegawai::fetch($request);

        return view('sinkronisasi::pegawai.default', compact('data'));
    }

    /**
     * @param Request $request
     */
    public function send(Request $request)
    {
        ini_set('max_execution_time', -1);
        $status = 'warning';
        $response = 'Tidak ada data yang dapat dikirim';
        $iter = 0;
        $data = $request->only(['check', 'send_all', 'tanggal']);
        $tanggal = $data['tanggal'];

        if (isset($data['send_all'])) {
            $total = Pegawai::where(['tgl_sinkronisasi' => $data['tanggal'], 'sinkronisasi' => 0])->count();
            Pegawai::select('nip')->where('tgl_sinkronisasi', $data['tanggal'])->orderBy('nip')->chunk(100, function ($rows) use ($tanggal, $status, $response, $iter, $total) {
                $nip = $rows->pluck('nip')->toArray();
                $iter += count($nip);
                $res = Http::post('http://' . config('parameter.app_server') . ':5100/api/push-pegawai', ['nip' => $nip, 'tanggal' => $tanggal]);

                if ($res->ok()) {
                    $status = 'success';
                    $response = $iter . ' data dari ' . $total . ' jumlah data telah disinkronisasi';
                } else {
                    $response = $res->json()['message'];

                    return false;
                }
            });
        }

        if (count($data['check'])) {
            $nip = (Pegawai::select('nip')->whereIn('id', $data['check'])->get())->pluck('nip')->toArray();
            $res = Http::post('http://' . config('parameter.app_server') . ':5100/api/push-pegawai', ['nip' => $nip, 'tanggal' => $tanggal]);

            if ($res->ok()) {
                $status = 'success';
                $response = count($nip) . ' data telah disinkronisasi';
            } else {
                $response = $res->json()['message'];
            }
        }

        return redirect('sinkronisasi-pegawai?tanggal=' . $tanggal)->with($status, $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Throwable
     */
    public function export(Request $request)
    {
        ini_set('memory_limit', -1);
        $filename = 'SYNC_PEGAWAI_' . now()->format('YmdHis');

        if ($request->type === 'xls') {
            return (new \Modules\Sinkronisasi\Exports\PegawaiExport($request))
                ->download($filename . '.xls', \Maatwebsite\Excel\Excel::XLS);
        } else {
            $data = Pegawai::fetch($request, true);
            $pdf = new Pdf(config('misc.wkhtmltopdf'));
            $html = view('sinkronisasi::pegawai.pdf', compact('data'))->render();
            header('Content-Type: application.pdf');
            header('Content-Disposition: attachment; filename=' . $filename . '.pdf');
            echo $pdf->getOutputFromHtml($html, ['orientation' => 'Landscape']);
        }
    }
}