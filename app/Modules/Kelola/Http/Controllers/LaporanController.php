<?php

namespace Modules\Kelola\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Kelola\Entities\Comprof;
use Modules\Kelola\Entities\Laporan;
use Modules\Kelola\Http\Requests\LaporanRequest;
use Carbon\Carbon;

class LaporanController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = Laporan::fetch($request);
        $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
        return view('kelola::laporan.default', compact('data','company_name'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() 
    {
        // $nama_perusahaan = Comprof::select('company_name')->where('status', 1)->get();
        // foreach($nama_perusahaan as $a)
        $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
        // $c=0;
        // foreach($company_name as $ca)
        // {
        //     foreach($ca as $y)
        //     {
        //         dd($y);
        //     }
        // }
        // dd($company_name);

        $kelola_laporan = new Laporan;
        $image = 'image';
        $file = 'file';
        return view('kelola::laporan.form', compact('kelola_laporan', 'image', 'file', 'company_name'));
    }

    /**
     * @param LaporanRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(LaporanRequest $request)
    {
        $values = $request->except(['_token', 'save']);

        if (isset($values['file'])) {
            $current_time = Carbon::now();
            $date = $current_time->toDateString();
            $time = $current_time->toTimeString();
            $ext = $values['file']->getClientOriginalExtension();
            $file = $values['file']->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $values['title']) . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '.' . $ext, 'public_asset_laporan_file');
            $values['file'] = $file;
        }

        $laporan = Laporan::create($values);

        $message = ['key' => 'Kelola Laporan', 'value' => $values['title']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($laporan) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('kelola-laporan.create')->with($status, $response);
        }

        return redirect('kelola-laporan')->with($status, $response);
    }

    /**
     * @param Laporan $kelola_laporan
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Laporan $kelola_laporan)
    {
        $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
        $image = 'image';
        $file = 'file';
        return view('kelola::laporan.form', compact('kelola_laporan', 'image', 'file', 'company_name'));
    }

    /**
     * @param LaporanRequest $request
     * @param Laporan $kelola_laporan
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(LaporanRequest $request, Laporan $kelola_laporan)
    {
        // dd($kelola_laporan->status_progres, $request['status_progres']);exit;
        $message = ['key' => 'Kelola Laporan', 'value' => $kelola_laporan->title];
        $status = 'error';
        $response = trans('message.update_gagal', $message);

        if($kelola_laporan->status_progres === 1 || $kelola_laporan->status_progres === 3){
            $values = $request->except(['_token', '_method']);
            
            if (isset($values['file'])) {
                $current_time = Carbon::now();
                $date = $current_time->toDateString();
                $time = $current_time->toTimeString();
                $ext = $values['file']->getClientOriginalExtension();
                $file = $values['file']->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $values['title']) . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '.' . $ext, 'public_asset_laporan_file');
                $values['file'] = $file;
            }
            
            foreach ($values as $key => $value) {
                $kelola_laporan->$key = $value;
            }
            
            $message = ['key' => 'Kelola Laporan', 'value' => $kelola_laporan->title];
            $status = 'error';
            $response = trans('message.update_error', $message);
            
            if ($kelola_laporan->save()) {
                $status = 'success';
                $response = trans('message.update_success', $message);
            }
            
            if ($request->ajax()) {
                return response()->json(['message' => $response, 'status' => $status]);
            }
            
            return redirect('kelola-laporan')->with($status, $response);
        }
        return redirect('kelola-laporan')->with($status, $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        // dd('a');exit();
        $kelola_laporan = Laporan::findOrFail($id);
        $image = 'image';
        $file = 'file';
        return view('kelola::laporan.show', compact('kelola_laporan', 'image', 'file'));
    }

    /**
     * @param Request $request
     * @param Laporan $kelola_laporan
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, Laporan $kelola_laporan)
    {
        $message = ['key' => 'Kelola Laporan', 'value' => $kelola_laporan->title];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($kelola_laporan->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-laporan')->with($status, $response);
    }
}
