<?php

namespace Modules\IsiKuisioner\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Kuisioner\Entities\Penilaian;
use Modules\Kuisioner\Entities\PenilaianDetail;
use Modules\IsiKuisioner\Entities\IsiKuisioner;
use Modules\IsiKuisioner\Entities\IsiKuisionerDetail;
use Modules\IsiKuisioner\Http\Requests\IsiKuisionerRequest;
use Modules\Kuisioner\Entities\Pertanyaan;
use Modules\Kelola\Entities\Comprof;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class IsiKuisionerManriskController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = IsiKuisioner::where('status_kuisioner', '1')->fetch($request);
        $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
        return view('isikuisioner::manrisk.default', compact('data', 'company_name'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $isikuisioner = new IsiKuisioner();
        $data_pertanyaan = Pertanyaan::with('detail_pertanyaan')->where('status_user', 1)->where('status', 1)->get();
        $file_jawaban = 'file';
        $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
        return view('isikuisioner::manrisk.form', compact('isikuisioner', 'data_pertanyaan', 'file_jawaban', 'company_name'));
    }

    /**
     * @param IsiKuisionerRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(IsiKuisionerRequest $request)
    {
        dd('SABAR DULU LAGI DI BENERIN');
        $isikuisioner = new IsiKuisioner();
        $values = $request->only(['periode', 'nama_perusahaan', 'modal_inti', 'user', 'status_kuisioner', 'status']);
        $company_name = Comprof::where('id', $values['nama_perusahaan'])->get();
        $id_pertanyaan = $request->only('id_pertanyaan', 'id_pertanyaan_detail', 'file', 'jawaban', 'description');

        foreach ($company_name as $items)
            $nama_perusahaan = $items->company_name;

        if (isset($id_pertanyaan['file'])) {
            foreach ($id_pertanyaan['file'] as $item) {
                if (isset($item)) {
                    $current_time = Carbon::now();
                    $date = $current_time->toDateString();
                    $time = $current_time->toTimeString();
                    $original_name = $item->getClientOriginalName();
                    $file = $item->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $nama_perusahaan) . '_' . $values['periode'] . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '_' . preg_replace('/[^\w@,.;]/', '_', $original_name), 'public_asset_penilaian_file');
                    $data[] = $file;
                }
            }
        }

        foreach ($values as $key => $value) {
            $isikuisioner->$key = $value;
        }

        $isikuisioner['id'] = uuid::uuid4();

        $message = ['key' => 'Isi Kuisioner', 'value' => $nama_perusahaan];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($isikuisioner->save()) {
            $status = 'success';
            $response = trans('message.create_success', $message);

            if (isset($id_pertanyaan['file'])) {
                for ($x = 0; $x < count($id_pertanyaan['id_pertanyaan']); $x++) {
                    $isikuisioner->detail_penilaian()
                        ->create([
                            'id_induk' => '',
                            'id_pertanyaan' => $id_pertanyaan['id_pertanyaan'][$x],
                            'id_pertanyaan_detail' => $id_pertanyaan['id_pertanyaan_detail'][$x],
                            'file' => $data[$x],
                            'jawaban' => $id_pertanyaan['jawaban'][$x],
                            'description' =>  $id_pertanyaan['description'][$x]
                        ]);
                }
            } else {
                for ($x = 0; $x < count($id_pertanyaan['id_pertanyaan']); $x++) {
                    $isikuisioner->detail_penilaian()
                        ->create([
                            'id_induk' => '',
                            'id_pertanyaan' => $id_pertanyaan['id_pertanyaan'][$x],
                            'id_pertanyaan_detail' => $id_pertanyaan['id_pertanyaan_detail'][$x],
                            'file' => null,
                            'jawaban' => $id_pertanyaan['jawaban'][$x],
                            'description' =>  $id_pertanyaan['description'][$x]
                        ]);
                }
            }
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('isikuisioner-manrisk.create')->with($status, $response);
        }

        return redirect('isikuisioner-manrisk')->with($status, $response);
    }

    /**
     * @param IsiKuisioner $isikuisioner
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, IsiKuisioner $isikuisioner)
    {
        $isikuisioner = IsiKuisioner::findOrFail($id);
        $data_penilaian = IsiKuisionerDetail::where('id_induk', $id)->get();
        $data_pertanyaan = Pertanyaan::with('detail_pertanyaan')->where('status_user', 1)->where('status', 1)->get();
        $file_jawaban = 'file[]';
        $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
        return view('isikuisioner::manrisk.form', compact('isikuisioner', 'data_penilaian', 'data_pertanyaan', 'file_jawaban', 'company_name'));
    }

    /**
     * @param IsiKuisionerRequest $request
     * @param IsiKuisioner $isikuisioner
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(IsiKuisionerRequest $request, IsiKuisioner $isikuisioner, $id)
    {
        $values = $request->only(['periode', 'nama_perusahaan', 'modal_inti', 'user', 'status_kuisioner', 'status']);
        $company_name = Comprof::where('id', $values['nama_perusahaan'])->get();
        $id_pertanyaan = $request->only('id_pertanyaan', 'id_pertanyaan_detail', 'file', 'jawaban', 'description');

        foreach ($company_name as $items)
            $nama_perusahaan = $items->company_name;

        if (isset($id_pertanyaan['file'])) {
            foreach ($id_pertanyaan['file'] as $item) {
                if (is_file($item)) {
                    $current_time = Carbon::now();
                    $date = $current_time->toDateString();
                    $time = $current_time->toTimeString();
                    $original_name = $item->getClientOriginalName();
                    $file = $item->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $nama_perusahaan) . '_' . $values['periode'] . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '_' . preg_replace('/[^\w@,.;]/', '_', $original_name), 'public_asset_penilaian_file');
                    $data[] = $file;
                } else {
                    $data[] = $item;
                }
            }
        }

        foreach ($values as $key => $value) {
            $isikuisioner->$key = $value;
        }

        $isikuisioner['id'] = uuid::uuid4();

        $message = ['key' => 'Isi Kuisioner', 'value' => $nama_perusahaan];
        $status = 'error';
        $response = trans('message.update_failed', $message);
        foreach ($isikuisioner->where('id', $id)->get() as $item) {
            foreach ($item->detail_penilaian()->where('id_induk', $id)->get() as $item2) {
                if ($item2->delete()) {
                }
            }
            $item->delete();
        }



        if ($isikuisioner->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);

            for ($x = 0; $x < count($id_pertanyaan['id_pertanyaan']); $x++) {
                $isikuisioner->detail_penilaian()
                    ->create([
                        'id_induk' => '',
                        'id_pertanyaan' => $id_pertanyaan['id_pertanyaan'][$x],
                        'id_pertanyaan_detail' => $id_pertanyaan['id_pertanyaan_detail'][$x],
                        'file' => $data[$x],
                        'jawaban' => $id_pertanyaan['jawaban'][$x],
                        'description' =>  $id_pertanyaan['description'][$x]
                    ]);
            }
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('isikuisioner-manrisk.edit')->with($status, $response);
        }

        return redirect('isikuisioner-manrisk')->with($status, $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $isikuisioner = IsiKuisioner::findOrFail($id);
        $data_penilaian = IsiKuisionerDetail::where('id_induk', $id)->get();
        $data_pertanyaan = Pertanyaan::with('detail_pertanyaan')->where('status_user', 1)->where('status', 1)->get();
        $file_jawaban = 'file';
        $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
        return view('isikuisioner::manrisk.show', compact('isikuisioner', 'data_penilaian', 'data_pertanyaan', 'file_jawaban', 'company_name'));
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

        $message = ['key' => 'Hasil Kuisioner Manrisk', 'value' => 'Periode ' . $isikuisioner->get()[0]->periode . ' - ' . $date_format_year];
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
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('isikuisioner-manrisk')->with($status, $response);
    }
}
