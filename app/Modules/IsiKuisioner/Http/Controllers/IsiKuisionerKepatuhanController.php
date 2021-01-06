<?php

namespace Modules\IsiKuisioner\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Kuisioner\Entities\Penilaian;
use Modules\Kuisioner\Entities\PenilaianDetail;
use Modules\IsiKuisioner\Entities\IsiKuisioner;
use Modules\IsiKuisioner\Entities\IsiKuisionerDetail;
use Modules\IsiKuisioner\Http\Requests\IsiKuisionerRequestKepatuhan;
use Modules\Kelola\Entities\Comprof;
use Modules\Kuisioner\Entities\Pertanyaan;
use Modules\Kuisioner\Entities\PertanyaanDetail;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class IsiKuisionerKepatuhanController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = IsiKuisioner::where('status_kuisioner', '=', '2')->fetch($request);
        $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
        return view('isikuisioner::kepatuhan.default', compact('data', 'company_name'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $isikuisioner = new IsiKuisioner();
        $data_pertanyaan = Pertanyaan::with('detail_pertanyaan')->where('status_user', 2)->where('status', 1)->get();
        $file_jawaban = 'file';
        $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
        return view('isikuisioner::kepatuhan.form', compact('isikuisioner', 'data_pertanyaan', 'file_jawaban', 'company_name'));
    }

    /**
     * @param IsiKuisionerRequestKepatuhan $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(IsiKuisionerRequestKepatuhan $request)
    {
        $isikuisioner = new IsiKuisioner();
        $values = $request->only(['periode', 'nama_perusahaan', 'modal_inti', 'user', 'status_kuisioner', 'status']);
        $id_pertanyaan = $request->only('id_pertanyaan', 'id_pertanyaan_detail', 'jawaban', 'description');
        $a = count($id_pertanyaan['jawaban']);
        $b = count($id_pertanyaan['id_pertanyaan_detail']);

        if ($a != $b) {
            array_splice($id_pertanyaan['jawaban'], 0, 1);
        }

        $date = Carbon::now();
        $date_format_year = Carbon::createFromFormat('Y-m-d H:i:s', $date)->year;

        foreach ($values as $key => $value) {
            $isikuisioner->$key = $value;
        }

        $isikuisioner['id'] = uuid::uuid4();

        $message = ['key' => 'Isi Kuisioner', 'value' => 'Periode ' . $values['periode'] . ' - ' . $date_format_year];
        $status = 'error';
        $response = trans('message.create_failed', $message);
        if ($isikuisioner->save()) {
            $status = 'success';
            $response = trans('message.create_success', $message);

            for ($x = 0; $x < count($id_pertanyaan['id_pertanyaan']); $x++) {
                $isikuisioner->detail_penilaian()
                    ->create([
                        'id_induk' => '',
                        'id_pertanyaan' => $id_pertanyaan['id_pertanyaan'][$x],
                        'id_pertanyaan_detail' => $id_pertanyaan['id_pertanyaan_detail'][$x],
                        'jawaban' => $id_pertanyaan['jawaban'][$x],
                        'description' =>  $id_pertanyaan['description'][$x]
                    ]);
            }
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('isikuisioner-kepatuhan.create')->with($status, $response);
        }

        return redirect('isikuisioner-kepatuhan')->with($status, $response);
    }

    /**
     * @param IsiKuisioner $isikuisioner
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $isikuisioner = IsiKuisioner::findOrFail($id);
        $data_penilaian = IsiKuisionerDetail::where('id_induk', $id)->get();
        $data_pertanyaan = Pertanyaan::with('detail_pertanyaan')->where('status_user', 2)->where('status', 1)->get();
        $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
        return view('isikuisioner::kepatuhan.form', compact('isikuisioner', 'data_penilaian', 'company_name', 'data_pertanyaan'));
    }

    /**
     * @param IsiKuisionerRequestKepatuhan $request
     * @param IsiKuisioner $isikuisioner
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(IsiKuisionerRequestKepatuhan $request, IsiKuisioner $isikuisioner, $id)
    {
        $isikuisioners = new IsiKuisioner();
        $values = $request->only(['periode', 'nama_perusahaan', 'modal_inti', 'user', 'status_kuisioner', 'status']);
        $id_pertanyaan = $request->only('id_pertanyaan', 'id_pertanyaan_detail', 'jawaban', 'description');
        $a = count($id_pertanyaan['jawaban']);
        $b = count($id_pertanyaan['id_pertanyaan_detail']);
        // $id = $isikuisioner->select('id')->get();

        if ($a != $b) {
            array_splice($id_pertanyaan['jawaban'], 0, 1);
        }

        $date = Carbon::now();
        $date_format_year = Carbon::createFromFormat('Y-m-d H:i:s', $date)->year;

        foreach ($values as $key => $value) {
            $isikuisioners->$key = $value;
        }
        
        $isikuisioners['id'] = uuid::uuid4();
        
        $message = ['key' => 'Isi Kuisioner', 'value' => 'Periode ' . $values['periode'] . ' - ' . $date_format_year];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        foreach ($isikuisioner->where('id', $id)->get() as $item) {
            foreach ($item->detail_penilaian()->where('id_induk', $id)->get() as $item2) {
                if ($item2->delete()) {
                }
            }
            $item->delete();
        }

        if ($isikuisioners->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);

            for ($x = 0; $x < count($id_pertanyaan['id_pertanyaan']); $x++) {
                $isikuisioners->detail_penilaian()
                    ->create([
                        'id_induk' => '',
                        'id_pertanyaan' => $id_pertanyaan['id_pertanyaan'][$x],
                        'id_pertanyaan_detail' => $id_pertanyaan['id_pertanyaan_detail'][$x],
                        'jawaban' => $id_pertanyaan['jawaban'][$x],
                        'description' =>  $id_pertanyaan['description'][$x]
                    ]);
            }
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('isikuisioner-kepatuhan.edit')->with($status, $response);
        }

        return redirect('isikuisioner-kepatuhan')->with($status, $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $isikuisioner = IsiKuisioner::findOrFail($id);
        $data_penilaian = IsiKuisionerDetail::where('id_induk', $id)->get();
        $data_pertanyaan = Pertanyaan::with('detail_pertanyaan')->where('status_user', 2)->where('status', 1)->get();
        $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
        return view('isikuisioner::kepatuhan.show', compact('isikuisioner', 'data_penilaian', 'company_name', 'data_pertanyaan'));
    }

    /**
     * @param Request $request
     * @param IsiKuisioner $isikuisioner
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, IsiKuisioner $isikuisioner, $id)
    {
        $date = Carbon::now();
        $date_format_year = Carbon::createFromFormat('Y-m-d H:i:s', $date)->year;

        $message = ['key' => 'Hasil Kuisioner Kepatuhan', 'value' => 'Periode ' . $isikuisioner->get()[0]->periode . ' - ' . $date_format_year];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        foreach ($isikuisioner->where('id', $id)->get() as $item) {
            foreach ($item->detail_penilaian()->where('id_induk', $id)->get() as $item2) {
                if ($item2->delete()) {
                    $status = 'success';
                    $response = trans('message.delete_success', $message);
                }
            }
            $item->delete();
        }


        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('isikuisioner-kepatuhan')->with($status, $response);
    }
}
