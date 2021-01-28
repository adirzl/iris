<?php

namespace Modules\Dokumen\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Dokumen\Entities\FileType;
use Modules\Dokumen\Http\Requests\FileTypeRequest;
use Modules\UnitKerja\Entities\UnitKerja;

use Carbon\Carbon;

class FileTypeController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $data = FileType::Fetch($request);
        $detail = FileType::where('status',1)->get();
        return view('Dokumen::FileType.default', compact('data','detail'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $kode = null;
        $filetype = [];

        $unitkerja = to_dropdown(UnitKerja::where('status',1)->get(),'kode','nama');
        
        return view('Dokumen::FileType.form', compact('kode','unitkerja','filetype'));
    }

    /**
     * @param ArtikelRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $values = $request->except(['_token', 'save']);
        $v['unitkerja_kode']= $values['unitkerja_kode'];     
        $v['status']=1; 
        foreach($values['name'] as $n)
        {
            $v['name']=$n;
            
            $filetype = FileType::create($v);            
        }
        $nama_unitkerja=UnitKerja::find($values['unitkerja_kode']);
        
        $message = ['key' => 'Unit Kerja', 'value' => $nama_unitkerja->nama];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($filetype) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('dokumen-filetype.create')->with($status, $response);
        }

        return redirect('dokumen-filetype')->with($status, $response);
    }

    /**
     * @param Artikel $kelola_artikel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(UnitKerja $dokumen_filetype)
    {
        $kode=$dokumen_filetype->kode;
        $filetype = Filetype::where(['unitkerja_kode'=>$dokumen_filetype->kode,'status'=>1])->get();
        $unitkerja = to_dropdown(UnitKerja::where('status',1)->get(),'kode','nama');
        
        return view('Dokumen::FileType.form', compact('kode','unitkerja','filetype'));
    }

    /**
     * @param ArtikelRequest $request
     * @param Artikel $kelola_artikel
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ArtikelRequest $request, Artikel $kelola_artikel)
    {
        $values = $request->except(['_token', '_method']);

        if (isset($values['image'])) {
            $current_time = Carbon::now();
            $date = $current_time->toDateString();
            $time = $current_time->toTimeString();
            $ext = $values['image']->getClientOriginalExtension();
            $file = $values['image']->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $values['title']) . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '.' . $ext, 'public_asset_artikel');
            $values['image'] = $file;
        }

        if (isset($values['file'])) {
            $current_time = Carbon::now();
            $date = $current_time->toDateString();
            $time = $current_time->toTimeString();
            $ext = $values['file']->getClientOriginalExtension();
            $file = $values['file']->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $values['title']) . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '.' . $ext, 'public_asset_artikel_file');
            $values['file'] = $file;
        }

        foreach ($values as $key => $value) {
            $kelola_artikel->$key = $value;
        }

        $message = ['key' => 'Kelola Artikel', 'value' => $kelola_artikel->title];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        if ($kelola_artikel->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-artikel')->with($status, $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $kelola_artikel = Artikel::findOrFail($id);
        $image = 'image';
        $file = 'file';
        return view('kelola::artikel.show', compact('kelola_artikel', 'image', 'file'));
    }

    /**
     * @param Request $request
     * @param Artikel $kelola_artikel
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, UnitKerja $dokumen_filetype)
    {
        $filetype = Filetype::where(['unitkerja_kode'=>$dokumen_filetype->kode,'status'=>1])->update(['status'=>0]);
        
        $message = ['key' => 'Dokumen Tipe dan Nama', 'value' => $dokumen_filetype->nama];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($filetype) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('dokumen-filetype')->with($status, $response);
    }


    public function list_filetype($unitkerja_kode)
    {
        $list_filetype=FileType::where(['unitkerja_kode'=>$unitkerja_kode,'status'=>1])->orderby('name')->get();
        return response()->json(['data'=>$list_filetype]);
    }
}
