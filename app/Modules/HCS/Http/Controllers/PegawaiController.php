<?php

namespace Modules\HCS\Http\Controllers;

use Illuminate\Http\Request;
use Knp\Snappy\Pdf;
use Modules\HCS\Entities\Pegawai;

class PegawaiController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $data = Pegawai::fetch($request);
        $unitKerja = to_dropdown(\Modules\HCS\Entities\UnitKerja::where('status', 1)->get(), 'kode', 'nama');
        $statusKaryawan = to_dropdown(Pegawai::distinct()->select('status_karyawan')->get(), 'status_karyawan', 'status_karyawan');

        return view('hcs::pegawai.default', compact('data', 'unitKerja', 'statusKaryawan'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Throwable
     */
    public function export(Request $request)
    {
        ini_set('memory_limit', -1);
        $filename = 'HCS_PEGAWAI_' . now()->format('YmdHis');
        
        if ($request->type === 'xls') {
            return (new \Modules\HCS\Exports\PegawaiExport($request))
                ->download($filename . '.xls', \Maatwebsite\Excel\Excel::XLS);
        } else {
            ini_set('max_execution_time', -1);
            $data = Pegawai::fetch($request, true);
            $pdf = new Pdf(config('misc.wkhtmltopdf'));
            $pdf->setTimeout(600);
            $html = view('hcs::pegawai.pdf', compact('data'))->render();
            header('Content-Type: application.pdf');
            header('Content-Disposition: attachment; filename=' . $filename . '.pdf');
            echo $pdf->getOutputFromHtml($html, ['orientation' => 'Landscape']);
        }
    }
}
