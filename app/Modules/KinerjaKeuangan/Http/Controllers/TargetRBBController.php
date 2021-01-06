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

class TargetRBBController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
        $data = TargetRBB::fetch($request);
        return view('KinerjaKeuangan::targetrbb.default', compact('company_name', 'data'));
    }

    public function create()
    {
        $company_name = Comprof::where('status', 1)->get();
        $data = TargetRBB::all();
        return view('KinerjaKeuangan::targetrbb.form', compact('company_name', 'data'));
    }

    public function upload_excel(Request $request)
    {
        // dd($request);exit;
        $tahun = $request->tahun;
        $kategoris = $request->kategori;
        $status_progres = 1;

        $non = TargetRBB::where('id_comprof', $request->company_name)->where('kategori_keuangan', $request->kategori)->where('tahun', $request->tahun)->get();
        foreach($non as $n =>$value){
            $non = $value;
        }
        // dd($non);exit;
        $non->status_progres = 2;
        $non->save();

        foreach ($kategoris as $kategori)
            $comprofs = $request->company_name;
        foreach ($comprofs as $comprof)

            // validasi
            $this->validate($request, [
                'file' => 'required|mimes:csv,xls,xlsx'
            ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand() . $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_upload', $nama_file);

        // import data
        Excel::import(new Upload($tahun, $kategori, $comprof, $status_progres), public_path('/file_upload/' . $nama_file));

        // notifikasi dengan session
        Session::flash('sukses', 'Data Target RBB Berhasil Diupload!');

        // alihkan halaman kembali
        return redirect('target-rbb');
    }

    /**
     * @param Artikel $kelola_artikel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Artikel $dmtl_audit)
    {
        return view('kelola::artikel.form', compact('dmtl_audit'));
    }

    /**
     * @param ArtikelRequest $request
     * @param Artikel $kelola_artikel
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ArtikelRequest $request, Artikel $kelola_artikel)
    {
        $values = $request->except(['_token', '_method']);

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
        $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
        $targetrbb = TargetRBB::findOrFail($id);
        
        if($targetrbb->kategori_keuangan == 1){
            $targetrbb_detail = $targetrbb->detail1()->orderby('periode', 'asc')->get();
        } else {
            $targetrbb_detail = $targetrbb->detail2()->orderby('periode', 'asc')->get();
            // dd($targetrbb_detail);exit;
        }

        return view('KinerjaKeuangan::targetrbb.show', compact('company_name','targetrbb','targetrbb_detail'));
    }

    /**
     * @param Request $request
     * @param Artikel $kelola_artikel
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, Artikel $kelola_artikel)
    {
        $message = ['key' => 'Kelola Artikel', 'value' => $kelola_artikel->title];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($kelola_artikel->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-artikel')->with($status, $response);
    }
}
