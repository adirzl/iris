<?php

namespace Modules\Kuisioner\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Kuisioner\Entities\Pertanyaan;
use Modules\Kuisioner\Entities\PertanyaanDetail;
use Modules\Kuisioner\Http\Requests\PertanyaanRequest;
use Ramsey\Uuid\Uuid;

class PertanyaanController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = Pertanyaan::fetch($request);
        return view('kuisioner::pertanyaan.default', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $kuisioner_pertanyaan = new Pertanyaan;
        return view('kuisioner::pertanyaan.form', compact('kuisioner_pertanyaan'));
    }

    /**
     * @param PertanyaanRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PertanyaanRequest $request)
    {
        $pertanyaan = new Pertanyaan;
        $values = $request->only(['description', 'status', 'status_user']);
        $detail = collect($request->only('pertanyaan')['pertanyaan']);
        $i = 1;

        foreach ($values as $key => $value) {
            $pertanyaan->$key = $value;
        }

        $message = ['key' => 'Pertanyaan', 'value' => $values['description']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($pertanyaan->save()) {
            $status = 'success';
            $response = trans('message.create_success', $message);

            foreach ($detail as $value) {
                $pertanyaan->detail_pertanyaan()->create(['pertanyaan' => $value, 'no_pertanyaan' => $i]);
                ++$i;
            }
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('kuisioner-pertanyaan.create')->with($status, $response);
        }

        return redirect('kuisioner-pertanyaan')->with($status, $response);
    }

    /**
     * @param Pertanyaan $kuisioner_pertanyaan
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Pertanyaan $kuisioner_pertanyaan)
    {
        return view('kuisioner::pertanyaan.form', compact('kuisioner_pertanyaan'));
    }

    /**
     * @param PertanyaanRequest $request
     * @param Pertanyaan $kuisioner_pertanyaan
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PertanyaanRequest $request, Pertanyaan $kuisioner_pertanyaan)
    {
        $pertanyaan = new Pertanyaan;
        $values = $request->only(['description', 'status', 'status_user']);
        $detail = collect($request->only('pertanyaan')['pertanyaan']);
        // $detail = $request->only(['pertanyaan']);
        // $id = $request->only(['id']);
        $id = $kuisioner_pertanyaan->id;
        $i = 1;
        $j = 0;

        foreach ($values as $key => $value) {
            $pertanyaan->$key = $value;
        }

        $message = ['key' => 'Pertanyaan', 'value' => $kuisioner_pertanyaan->description];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        $kuisioner_pertanyaan->where('id', $id)->delete();
        $kuisioner_pertanyaan->detail_pertanyaan()->where('id_induk', $id)->delete();

        if ($pertanyaan->save()) {

            foreach ($detail as $value) {
                $pertanyaan->detail_pertanyaan()->create(['pertanyaan' => $value, 'no_pertanyaan' => $i]);
                ++$i;
            }

            // foreach ($id as $ids) {
            //     for ($j; $j < count($detail['pertanyaan']); $j++) {
            //         $kuisioner_pertanyaan->detail_pertanyaan()->where('id', $ids[$j])->update(['pertanyaan' => $detail['pertanyaan'][$j], 'no_pertanyaan' => $j + 1]);
            //     }
            // }

            $status = 'success';
            $response = trans('message.update_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kuisioner-pertanyaan')->with($status, $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        // dd('a');exit();
        $kuisioner_pertanyaan = Pertanyaan::findOrFail($id);
        return view('kuisioner::pertanyaan.show', compact('kuisioner_pertanyaan'));
    }

    /**
     * @param Request $request
     * @param Pertanyaan $kuisioner_pertanyaan
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, Pertanyaan $kuisioner_pertanyaan)
    {
        $message = ['key' => 'Pertanyaan', 'value' => $kuisioner_pertanyaan->description];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($kuisioner_pertanyaan->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kuisioner-pertanyaan')->with($status, $response);
    }
}
