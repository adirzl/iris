<?php

namespace Modules\Dokumen\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Dokumen\Entities\FileType;
use Modules\Dokumen\Entities\FileArchive;
use Modules\Dokumen\Http\Requests\FileArchiveRequest;
use Modules\UnitKerja\Entities\UnitKerja;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileArchiveController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = FileArchive::fetch($request);
        return view('Dokumen::FileArchive.default', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $d = new FileArchive;
        $unitkerja = to_dropdown(UnitKerja::where('status',1)->get(),'kode','nama');
        $filetype = [ '' => '-Pilih Satu-' ];
        return view('Dokumen::FileArchive.form', compact('d','unitkerja','filetype'));
    }

    /**
     * @param ArtikelRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(FileArchiveRequest $request)
    {
        $values = $request->except(['_token', 'save']);

        $filetype = FileType::find($values['filetype_id']);
        $values['fileext']  = $values['path']->getClientOriginalExtension();
        $values['filename'] = $values['unitkerja_kode']."_".$filetype->name."_".$values['version'].".".$values['fileext'];
        $values['label'] = $filetype->name.' | '.$filetype->unit_kerja->nama.' | versi '.$values['version'];

        $file = $request->file()['path'];
        // $values['path'] = "dokumen/" . $values['unitkerja_kode']."/".$filetype->id."/".$filename;
        // $values['path'] = "dokumen/" . $values['unitkerja_kode']."/".$filetype->id."/".$filename;
        // $filearchive = FileArchive::create($values);

        $message = ['key' => 'Dokumen', 'value' => $filetype->name];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        $saveResult = false;
        DB::transaction(function () use($values, $filetype, $file, &$saveResult) {
            FileArchive::create($values);

            if($values['version'] > 1){
                FileArchive::where([
                    'unitkerja_kode'=>$values['unitkerja_kode'],
                    'filetype_id'=>$values['filetype_id'],
                    'version'=>$values['version'] - 1
                    ])->update(['deleted_at'=>now()]);
            }

            $destination = 'public/dokumen/'. $values['unitkerja_kode']."/".$filetype->id;

            if(!File::exists($destination)){
                Storage::makeDirectory($destination);
            }

            $file->move(storage_path('app/'.$destination), $values['filename']);
            $saveResult = true;
        });

        if ($saveResult) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('dokumen-filearchive.create')->with($status, $response);
        }

        return redirect('dokumen-filearchive')->with($status, $response);
    }

    /**
     * @param Artikel $kelola_artikel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(FileArchive $dokumen_filearchive)
    {
        $d=$dokumen_filearchive;
        $d->version=$d->version+1;
        $unitkerja = UnitKerja::where(['kode'=>$d->unitkerja_kode,'status'=>1])->pluck('nama','kode');
        $filetype = FileType::where('id',$d->filetype)->pluck('name','id');
        return view('Dokumen::FileArchive.form', compact('d','unitkerja','filetype'));
    }

    /**
     * @param ArtikelRequest $request
     * @param Artikel $kelola_artikel
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ArtikelRequest $request, Artikel $kelola_artikel)
    {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(FileArchive $dokumen_filearchive)
    {
        $data=FileArchive::where(['unitkerja_kode'=>$dokumen_filearchive->unitkerja_kode,
        'filetype_id'=>$dokumen_filearchive->filetype_id,'status'=>1])->orderby('version','desc')->get();

        return view('Dokumen::fileArchive.show', compact('data'));
    }

    /**
     * @param Request $request
     * @param Artikel $kelola_artikel
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, FileArchive $dokumen_filearchive)
    {

        $old=$dokumen_filearchive->status;
        $new=$dokumen_filearchive->status ==1 ? 0 : 1;
        $message = ['key' => '', 'value' => ''];
        $status = 'error';
        $response = trans('message.ubahstatus_error', $message);

        if ($dokumen_filearchive->update(['status'=>$new])) {
            $status = 'success';
            $response = trans('message.ubahstatus_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('dokumen-filearchive')->with($status, $response);
    }

    public function filearchive_version($filetype, $unitkerja_kode)
    {
        $max = FileArchive::where([ 'filetype_id' => $filetype, 'unitkerja_kode' => $unitkerja_kode ])->max('version');
        $version= !$max ? 1 : $max + 1;
        return response()->json(['data'=>$version]);
    }

    public function searchdocument(Request $request){
        $request->status = 1;

        if(is_array($request->filetype_id)){
            $tempFileTypeId = [];
            foreach($request->filetype_id as $item){
                $tempFileTypeId[] = $item['value'];
            }
            $request->filetype_id = $tempFileTypeId;
        }

        $data = FileArchive::fetch($request, true);

        foreach($data as $item){
            $item->filetype_label = isset($item->file_type) ? $item->file_type->name : 'N/A';
            $item->tipe_dokumen_label = isset(config('options.tipe_dokumen')[$item->tipe_dokumen]) ? config('options.tipe_dokumen')[$item->tipe_dokumen] : 'N/A';
            $item->created_at_label = date_format(date_create($item->created_at), 'Y-M-d');
        }

        return response()->json($data);
    }

}
