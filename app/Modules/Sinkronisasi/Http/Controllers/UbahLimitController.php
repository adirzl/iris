<?php

namespace Modules\Sinkronisasi\Http\Controllers;

use Illuminate\Http\Request;
use Knp\Snappy\Pdf;
use Modules\Sinkronisasi\Entities\UbahLimit;

class UbahLimitController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = UbahLimit::fetch($request);

        return view('sinkronisasi::ubah-limit.default', compact('data'));
    }

    /**
     * @param Request $request
     */
    public function send(Request $request)
    {
        $response = 'Tidak ada data yang dapat dikirim';
        $sinkronisasi = 'f';
        $rc = '99';
        $data = $request->only(['check', 'send_all', 'tanggal']);
        $tanggal = $data['tanggal'];
        $mpi = ['MC' => '010001', 'CC' => '0002', 'PCC' => '2', 'MT' => '2100'];

        if (isset($data['send_all'])) {
            $rows = UbahLimit::select(['id', 'userid', 'kode_cabang', 'grup_limit', 'limit_oto_kredit_default', 'limit_oto_debit_default'])
                ->where('tgl_sinkronisasi', $tanggal)
                ->get();
        }

        if (isset($data['check']) && count($data['check'])) {
            $rows = UbahLimit::select(['id', 'userid', 'kode_cabang', 'grup_limit', 'limit_oto_kredit_default', 'limit_oto_debit_default'])
                ->whereIn('id', $data['check'])
                ->get();
        }

        if ($rows) {
            foreach ($rows as $row) {
                $socket = (new \Modules\Sinkronisasi\Services\Socket)->connect('10.6.226.214', 21096);
                $res = $socket->writeThenSend($socket->setMPI($mpi, [
                    'USER' => $row->userid, 'BRANCH' => $row->kode_cabang, 'GROUP' => $row->grup_limit,
                    'IB' => 'N', 'OTODB' => str_replace(',', '', $row->limit_oto_debit_default), 
					'OTOCR' => str_replace(',', '', $row->limit_oto_kredit_default)
                ]))->getMPO();

                if ($res['RC']['RC'] === '0000') {
                    $responseArr[] = 'User ID ' . $row->userid . ' Cabang ' . $row->kode_cabang . ' berhasil diubah limit';
                    $sinkronisasi = 't';
                    $rc = '00';
                } else {
                    $responseArr[] = 'User ID ' . $row->userid . ' Cabang ' . $row->kode_cabang . ' |' . (isset($res['MPO']['ERRMSG']) ? ' KSM - '. $res['MPO']['ERRMSG'] . '' : '') . ' (' . $res['RC']['RC'] . ' - ' . $res['RC']['RCM'] . ')';
                }

                UbahLimit::where('id', $row->id)->update(['sinkronisasi' => $sinkronisasi, 'rc' => $rc]);
                $socket->disconnect();
            }

            $response = implode('<br>', $responseArr);
        }

        return redirect('sinkronisasi-limit?tanggal=' . $tanggal)->with('info', $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Throwable
     */
    public function export(Request $request)
    {
        ini_set('memory_limit', -1);
        $filename = 'SYNC_LIMIT_' . now()->format('YmdHis');

        if ($request->type === 'xls') {
            return (new \Modules\Sinkronisasi\Exports\UbahLimitExport($request))
                ->download($filename . '.xls', \Maatwebsite\Excel\Excel::XLS);
        } else {
            $data = UbahLimit::fetch($request, true);
            $pdf = new Pdf(config('misc.wkhtmltopdf'));
            $html = view('sinkronisasi::ubah-limit.pdf', compact('data'))->render();
            header('Content-Type: application.pdf');
            header('Content-Disposition: attachment; filename=' . $filename . '.pdf');
            echo $pdf->getOutputFromHtml($html, ['orientation' => 'Landscape']);
        }
    }
}