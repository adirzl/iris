<?php

namespace Modules\KinerjaKeuangan\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Kelola\Entities\Comprof;
use Session;
use App\Imports\Upload;
use Maatwebsite\Excel\Facades\Excel;
use Modules\KinerjaKeuangan\Entities\TargetRBB;
use Modules\KinerjaKeuangan\Entities\TargetRBBDetail1;
use Modules\KinerjaKeuangan\Entities\TargetRBBDetail2;
use Illuminate\Support\Facades\DB;

class ActivasiTargetRBBController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */ 
    public function activated(Request $request, $id)
    {
        // dd($id);exit;
        // $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
        $data = TargetRBB::findOrfail($id);
        // dd($nonactivated);exit;
        if ($data->status_progres === 2) {
            $data->status_progres = 1;
            if ($data->update()) {
                $message = ['value' => $data->id_comprof];
                $status = 'success';
                $response = trans('message.activated_success', $message);

                $non = TargetRBB::where('id', '!=', $data->id)->where('id_comprof', $data->id_comprof)->where('kategori_keuangan', $data->kategori_keuangan)->where('tahun', $data->tahun)->get();
                foreach($non as $n =>$value){
                    $non = $value;
                }
                $non->status_progres = 2;
                $non->update();
            }

            return redirect('target-rbb')->with($status, $response);
        } else {
            $message = ['value' => $data->id_comprof];
            $status = 'error';
            $response = trans('message.activated_error', $message);

            return redirect('target-rbb')->with($status, $response);
        }
    }

    public function nonActivated()
    {
        $company_name = Comprof::where('status', 1)->get();
        $data = TargetRBB::all();
        return view('KinerjaKeuangan::targetrbb.form', compact('company_name', 'data'));
    }
}
