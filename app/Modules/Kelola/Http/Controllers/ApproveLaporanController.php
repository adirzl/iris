<?php

namespace Modules\Kelola\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Kelola\Entities\Comprof;
use Modules\Kelola\Entities\Laporan;
use Modules\Kelola\Http\Requests\LaporanRequest;
// use Carbon\Carbon;

class ApproveLaporanController extends \App\Http\Controllers\Controller
{

    public function __construct()
    {
        $this->middleware(['role:SUPER ADMIN|APPROVER']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function approveLaporan(Request $request, $id)
    {
        $data = Laporan::findOrFail($id);
        // dd($data);exit;
        if ($data->status_progres === 1) {
            $data->status_progres = 2;
            if ($data->update()) {
                $message = ['value' => $data->title];
                $status = 'success';
                $response = trans('message.aprove_success', $message);
            }

            return redirect('kelola-laporan')->with($status, $response);
        } else {
            $message = ['value' => $data->title];
            $status = 'error';
            $response = trans('message.aprove_error', $message);

            return redirect('kelola-laporan')->with($status, $response);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rejectLaporan(Request $request, $id)
    {
        $data = Laporan::findOrFail($id);
        // dd($data);exit;
        if ($data->status_progres === 1) {
            $data->status_progres = 3;
            if ($data->update()) {
                $message = ['value' => $data->title];
                $status = 'success';
                $response = trans('message.reject_success', $message);
            }

            return redirect('kelola-laporan')->with($status, $response);
        } else {
            $message = ['value' => $data->title];
            $status = 'error';
            $response = trans('message.reject_error', $message);

            return redirect('kelola-laporan')->with($status, $response);
        }
    }
}
