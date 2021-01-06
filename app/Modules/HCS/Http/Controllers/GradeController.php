<?php

namespace Modules\HCS\Http\Controllers;

use Illuminate\Http\Request;
use Knp\Snappy\Pdf;
use Modules\HCS\Entities\Grade;

class GradeController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $data = Grade::fetch($request);

        return view('hcs::grade.default', compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Throwable
     */
    public function export(Request $request)
    {
        ini_set('memory_limit', -1);
        $filename = 'HCS_GRADE_' . now()->format('YmdHis');

        if ($request->type === 'xls') {
            return (new \Modules\HCS\Exports\GradeExport($request))
                ->download($filename . '.xls', \Maatwebsite\Excel\Excel::XLS);
        } else {
            $data = Grade::fetch($request, true);
            $pdf = new Pdf(config('misc.wkhtmltopdf'));
            $html = view('hcs::grade.pdf', compact('data'))->render();
            header('Content-Type: application.pdf');
            header('Content-Disposition: attachment; filename=' . $filename . '.pdf');
            echo $pdf->getOutputFromHtml($html, ['orientation' => 'Landscape']);
        }
    }
}
