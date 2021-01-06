<?php

namespace Modules\HCS\Http\Controllers;

use Illuminate\Http\Request;
use Knp\Snappy\Pdf;
use Modules\HCS\Entities\UnitKerja;

class UnitKerjaController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $data = UnitKerja::fetch($request);

        return view('hcs::unit-kerja.default', compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Throwable
     */
    public function export(Request $request)
    {
        ini_set('memory_limit', -1);
        $filename = 'HCS_UNITKERJA_' . now()->format('YmdHis');

        if ($request->type === 'xls') {
            return (new \Modules\HCS\Exports\UnitKerjaExport($request))
                ->download($filename . '.xls', \Maatwebsite\Excel\Excel::XLS);
        } else {
            $data = UnitKerja::fetch($request, true);
            $pdf = new Pdf(config('misc.wkhtmltopdf'));
            $html = view('hcs::unit-kerja.pdf', compact('data'))->render();
            header('Content-Type: application.pdf');
            header('Content-Disposition: attachment; filename=' . $filename . '.pdf');
            echo $pdf->getOutputFromHtml($html, ['orientation' => 'Landscape']);
        }
    }
}
