<?php

namespace Modules\UIM\Http\Controllers;

use Illuminate\Http\Request;
use Knp\Snappy\Pdf;
use Modules\UIM\Entities\Pegawai;

class PegawaiController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $data = Pegawai::fetch($request);
        $unitKerja = to_dropdown(\Modules\UIM\Entities\UnitKerja::where('status', 1)->get(), 'kode_cabang', 'nama_cabang');
        $statusKaryawan = to_dropdown(Pegawai::distinct()->select('status_karyawan')->get(), 'status_karyawan', 'status_karyawan');

        return view('uim::pegawai.default', compact('data', 'unitKerja', 'statusKaryawan'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Throwable
     */
    public function export(Request $request)
    {
        ini_set('memory_limit', -1);
        $filename = 'UIM_PEGAWAI_' . now()->format('YmdHis');

        ini_set('memory_limit', -1);
        if ($request->type === 'xls') {
            return (new \Modules\UIM\Exports\PegawaiExport($request))
                ->download($filename . '.xls', \Maatwebsite\Excel\Excel::XLS);
        } else {
            $data = Pegawai::fetch($request, true);
            $pdf = new Pdf(config('misc.wkhtmltopdf'));
            $pdf->setTimeout(600);
            $html = view('uim::pegawai.pdf', compact('data'))->render();
            header('Content-Type: application.pdf');
            header('Content-Disposition: attachment; filename=' . $filename . '.pdf');
            echo $pdf->getOutputFromHtml($html, ['orientation' => 'Landscape']);
        }
    }
}
