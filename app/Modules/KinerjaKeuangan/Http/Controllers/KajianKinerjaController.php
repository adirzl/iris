<?php
namespace Modules\PengawasanAudit\Http\Controllers;

use Illuminate\Http\Request;
use Modules\PengawasanAudit\Entities\RkatAudit;
use Modules\PengawasanAudit\Entities\RkatAuditUmum;
use Modules\PengawasanAudit\Entities\RkatAuditKhusus;
use Modules\PengawasanAudit\Http\Requests\RkatRequest;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class RkatController extends \App\Http\Controllers\Controller
{
    /**
    * @param Request $request
    * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    */
    public function index(Request $request)
    {
        $data = RkatAudit::fetch($request);
        return view('PengawasanAudit::rkat.default', compact('data'));
    }
    
    /**
    * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    */
    public function create()
    {
        $rkat_audit = new RkatAudit;
        
        return view('PengawasanAudit::rkat.form', compact('rkat_audit'));
    }
    
    /**
    * @param RkatRequest $request
    * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
    */
    public function store(RkatRequest $request)
    {
        $rkat = new RkatAudit;
        $rkat->id = Uuid::uuid4();
        $values = $request->only(['ljk']);
        // $options = collect($request->only('sequence_umum')['sequence_umum'])->combine($request->only('objek_judul_umum')['objek_judul_umum']);
        // $optionss = collect($request->only('sequence_khusus')['sequence_khusus'])->combine($request->only('objek_judul_khusus')['objek_judul_khusus']);

        // dd($values);exit;

        foreach ($values as $key => $value) {
            $rkat->$key = $value;
        }

        $message = ['key' => 'Rkat Audit ', 'value' => $values['ljk']];
        $status = 'error';
        $response = trans('message.create_failed', $message);
        
        if ($rkat->save()) {
            $status = 'success';
            $response = trans('message.create_success', $message);
            
            // foreach ($options as $key => $value) {
            //     dd($key, $value);exit;
            //     // $rkat->rkataudit_umum()->create(['sequence_umum' => $value, 'objek_judul_umum' => $value, 'tgl_mulai_umum' => $value]);
            // }
            for ($i=0; $i < count($request->input('sequence_umum')); ++$i){

                $umum = new RkatAuditUmum;
                $umum->rkat_audit_id = $rkat->id;
                $umum->sequence_umum = $request['sequence_umum'][$i];
                $umum->objek_judul_umum = $request['objek_judul_umum'][$i];
                $umum->tgl_mulai_umum = $request['tgl_mulai_umum'][$i];
                $umum->tgl_selesai_umum = $request['tgl_selesai_umum'][$i];
                $umum->jml_temuan_umum = $request['jml_temuan_umum'][$i];
                $umum->jml_tindak_lanjut_umum = $request['jml_tindak_lanjut_umum'][$i];
                $umum->save();
            }
            
            // foreach ($optionss as $key => $value) {
            //     $rkat->rkataudit_khusus()->create(['sequence_khusus' => $key, 'objek_judul_khusus' => $value]);
            // }
            for ($i=0; $i < count($request->input('sequence_khusus')); ++$i){
                $khusus = new RkatAuditKhusus;
                $khusus->rkat_audit_id = $rkat->id;
                $khusus->sequence_khusus = $request['sequence_khusus'][$i];
                $khusus->objek_judul_khusus = $request['objek_judul_khusus'][$i];
                $khusus->tgl_mulai_khusus = $request['tgl_mulai_khusus'][$i];
                $khusus->tgl_selesai_khusus = $request['tgl_selesai_khusus'][$i];
                $khusus->tindak_lanjut_khusus = $request['tindak_lanjut_khusus'][$i];
                $khusus->save();
            }
        } 
        
        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }
        
        if ($request->only('save')) {
            
            return redirect()->route('rkat-audit.create')->with($status, $response);
        }
        
        return redirect('rkat-audit')->with($status, $response);
    }
    
    /**
    * @param RkatAudit $rkat_audit
    * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    */
    public function edit(RkatAudit $rkat_audit)
    {
        return view('PengawasanAudit::rkat.form', compact('rkat_audit'));
    }
    
    /**
    * @param ArtikelRequest $request
    * @param Artikel $kelola_artikel
    * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
    */
    public function update(RkatRequest $request, RkatAudit $rkat_audit)
    {
        // dd($rkat_audit->id);
        $values = $request->only(['ljk']);
        
        foreach ($values as $key => $value) {
            $rkat_audit->$key = $value;
        }
        
        $message = ['key' => 'Rkat Audit', 'value' => $rkat_audit->ljk];
        $status = 'error';
        $response = trans('message.update_failed', $message);
        
        // delete child sebelum recreate child baru (cara barbar) :D
        DB::table('app_rkat_umum')->where('rkat_audit_id', $rkat_audit->id)->delete();
        DB::table('app_rkat_khusus')->where('rkat_audit_id', $rkat_audit->id)->delete();
        
        //recreate child
        if ($rkat_audit->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
            
            //RKAT UMUM
            for ($i=0; $i < count($request->input('sequence_umum')); ++$i){

                $umum = new RkatAuditUmum;
                $umum->rkat_audit_id = $rkat_audit->id;
                $umum->sequence_umum = $request['sequence_umum'][$i];
                $umum->objek_judul_umum = $request['objek_judul_umum'][$i];
                $umum->tgl_mulai_umum = $request['tgl_mulai_umum'][$i];
                $umum->tgl_selesai_umum = $request['tgl_selesai_umum'][$i];
                $umum->jml_temuan_umum = $request['jml_temuan_umum'][$i];
                $umum->jml_tindak_lanjut_umum = $request['jml_tindak_lanjut_umum'][$i];
                $umum->save();
            }
            
            //RKAT KHUSUS
            for ($i=0; $i < count($request->input('sequence_khusus')); ++$i){
                $khusus = new RkatAuditKhusus;
                $khusus->rkat_audit_id = $rkat_audit->id;
                $khusus->sequence_khusus = $request['sequence_khusus'][$i];
                $khusus->objek_judul_khusus = $request['objek_judul_khusus'][$i];
                $khusus->tgl_mulai_khusus = $request['tgl_mulai_khusus'][$i];
                $khusus->tgl_selesai_khusus = $request['tgl_selesai_khusus'][$i];
                $khusus->tindak_lanjut_khusus = $request['tindak_lanjut_khusus'][$i];
                $khusus->save();
            }
        }
        
        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }
        
        return redirect('rkat-audit')->with($status, $response);
    }
    
    public function show($id)
    {
        $data = RkatAudit::findOrFail($id);
        return view('PengawasanAudit::rkat.show', compact('data'));
    }
 
    /**
    * @param Request $request
    * @param Artikel $kelola_artikel
    * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
    * @throws \Exception
    */
    public function destroy(Request $request, RkatAudit $rkat_audit)
    {
        $message = ['key' => 'Rkat Audit', 'value' => $rkat_audit->ljk];
        $status = 'error';
        $response = trans('message.delete_failed', $message);
        
        if ($rkat_audit->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
            
            DB::table('app_rkat_umum')->where('rkat_audit_id', $rkat_audit->id)->delete();
            DB::table('app_rkat_khusus')->where('rkat_audit_id', $rkat_audit->id)->delete();
        }
        
        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }
        
        return redirect('rkat-audit')->with($status, $response);
    }
}