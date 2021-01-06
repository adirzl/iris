<?php

namespace Modules\Kuisioner\Http\Controllers;

use Illuminate\Http\Request;
use Modules\IsiKuisioner\Entities\IsiKuisioner;
use Modules\IsiKuisioner\Entities\IsiKuisionerDetail;
use Modules\Kelola\Entities\Comprof;
use Modules\Kuisioner\Entities\Penilaian;
use Modules\Kuisioner\Entities\Pertanyaan;
use Knp\Snappy\Pdf;
use Modules\Kuisioner\Entities\PenilaianDetail;
use Modules\Kuisioner\Http\Requests\PenilaianRequest;

class PenilaianController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = Penilaian::fetch($request);
        return view('kuisioner::penilaian.default', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $kuisioner_penilaian = new Penilaian;
        return view('kuisioner::penilaian.form', compact('kuisioner_penilaian'));
    }

    /**
     * @param PenilaianRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PenilaianRequest $request)
    {
        $values = $request->except(['_token', 'save']);

        $artikel = Penilaian::create($values);

        $message = ['key' => 'Kuisioner Penilaian', 'value' => $values['title']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($artikel) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('kuisioner-penilaian.create')->with($status, $response);
        }

        return redirect('kuisioner-penilaian')->with($status, $response);
    }

    /**
     * @param Penilaian $kuisioner_penilaian
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Penilaian $kuisioner_penilaian)
    {
        return view('kuisioner::penilaian.form', compact('kuisioner_penilaian'));
    }

    /**
     * @param PenilaianRequest $request
     * @param Penilaian $kuisioner_penilaian
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PenilaianRequest $request, Penilaian $kuisioner_penilaian)
    {
        $values = $request->except(['_token', '_method']);

        foreach ($values as $key => $value) {
            $kuisioner_penilaian->$key = $value;
        }

        $message = ['key' => 'Kuisioner Penilaian', 'value' => $kuisioner_penilaian->title];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        if ($kuisioner_penilaian->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kuisioner-penilaian')->with($status, $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $kuisioner = IsiKuisioner::findOrFail($id);
        $data_penilaian = IsiKuisionerDetail::where('id_induk', $id)->get();
        if ($kuisioner->status_kuisioner == 1) {
            $data_pertanyaan = Pertanyaan::with('detail_pertanyaan')->where('status_user', 1)->where('status', 1)->get();
        } else {
            $data_pertanyaan = Pertanyaan::with('detail_pertanyaan')->where('status_user', 2)->where('status', 1)->get();
        }
        $file_jawaban = 'file';
        $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
        return view('kuisioner::penilaian.show', compact('kuisioner', 'data_penilaian', 'data_pertanyaan', 'file_jawaban', 'company_name'));
    }

    /**
     * @param Request $request
     * @param Penilaian $kuisioner_penilaian
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, Penilaian $kuisioner_penilaian)
    {
        $message = ['key' => 'Kuisioner Penilaian', 'value' => $kuisioner_penilaian->title];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($kuisioner_penilaian->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kuisioner-penilaian')->with($status, $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Throwable
     */
    public function export(Request $request, $id)
    {
        $kuisioner = IsiKuisioner::findOrFail($id);
        $periode = $kuisioner->periode;
        $nama_perusahaan = Comprof::where('status', 1)->where('id', $kuisioner->nama_perusahaan)->get();
        foreach ($nama_perusahaan as $item);
        $nama_perusahaan = $item->company_name;
        if ($kuisioner->status_kuisioner == 1) {
            $filename = str_replace(" ", '_', $nama_perusahaan) . '_' . 'KUISIONER_MANRISK_' . 'Periode-' . $periode . '_' . now()->format('YmdHis');
        } else {
            $filename = str_replace(" ", '_', $nama_perusahaan) . '_' . 'KUISIONER_KEPATUHAN_' . 'Periode-' . $periode . '_' . now()->format('YmdHis');
        }

        if ($request->type == 'xls') {
            // dd('A');
            return (new \Modules\Kuisioner\Exports\KuisionerExport($id, $nama_perusahaan))
                ->download($filename . '.xls', \Maatwebsite\Excel\Excel::XLS);
        } else {
            $kuisioner = IsiKuisioner::findOrFail($id);
            $data_penilaian = IsiKuisionerDetail::where('id_induk', $id)->get();
            if ($kuisioner->status_kuisioner == 1) {
                $data_pertanyaan = Pertanyaan::with('detail_pertanyaan')->where('status_user', 1)->where('status', 1)->get();
            } else {
                $data_pertanyaan = Pertanyaan::with('detail_pertanyaan')->where('status_user', 2)->where('status', 1)->get();
            }
            $file_jawaban = 'file';
            $company_name = to_dropdown(Comprof::where('status', 1)->get(), 'id', 'company_name');
            $pdf = new Pdf(config('misc.wkhtmltopdf'));
            $html = view('kuisioner::penilaian.pdf', compact('kuisioner', 'data_penilaian', 'data_pertanyaan', 'file_jawaban', 'company_name'))->render();
            header('Content-Type: application.pdf');
            header('Content-Disposition: attachment; filename=' . $filename . '.pdf');
            echo $pdf->getOutputFromHtml($html, ['orientation' => 'Landscape']);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function approve(Request $request, $id)
    {
        $data = Penilaian::findOrFail($id);
        if ($data->status === 1) {
            $data->status = 2;
            if ($data->update()) {
                $message = ['value' => $data->title];
                $status = 'success';
                $response = trans('message.aprove_success', $message);
            }

            return redirect('kuisioner-penilaian')->with($status, $response);
        } else {
            $message = ['value' => $data->title];
            $status = 'error';
            $response = trans('message.aprove_failed', $message);

            return redirect('kuisioner-penilaian')->with($status, $response);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reject(Request $request, $id)
    {
        $data = Penilaian::findOrFail($id);
        // dd($data);exit;
        if ($data->status === 1) {
            $data->status = 3;
            if ($data->update()) {
                $message = ['value' => $data->title];
                $status = 'success';
                $response = trans('message.aprove_success', $message);
            }

            return redirect('kuisioner-penilaian')->with($status, $response);
        } else {
            $message = ['value' => $data->title];
            $status = 'error';
            $response = trans('message.aprove_failed', $message);

            return redirect('kuisioner-penilaian')->with($status, $response);
        }
    }
}
