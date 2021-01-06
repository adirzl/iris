<?php

namespace Modules\Kelola\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Kelola\Entities\Regulasi;
use Modules\Kelola\Http\Requests\RegulasiRequest;
use Carbon\Carbon;

class RegulasiController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = Regulasi::fetch($request);
        return view('kelola::regulasi.default', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $kelola_regulasi = new Regulasi;
        $image = 'image';
        $file = 'file';
        return view('kelola::regulasi.form', compact('kelola_regulasi', 'file', 'image'));
    }

    /**
     * @param RegulasiRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(RegulasiRequest $request)
    {
        $values = $request->except(['_token', 'save']);

        if (isset($values['image'])) {
            $current_time = Carbon::now();
            $date = $current_time->toDateString();
            $time = $current_time->toTimeString();
            $ext = $values['image']->getClientOriginalExtension();
            $file = $values['image']->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $values['title']) . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '.' . $ext, 'public_asset_regulasi');
            $values['image'] = $file;
        }

        if (isset($values['file'])) {
            $current_time = Carbon::now();
            $date = $current_time->toDateString();
            $time = $current_time->toTimeString();
            $ext = $values['file']->getClientOriginalExtension();
            $file = $values['file']->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $values['title']) . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '.' . $ext, 'public_asset_regulasi_file');
            $values['file'] = $file;
        }

        $regulasi = Regulasi::create($values);

        $message = ['key' => 'Kelola Regulasi', 'value' => $values['title']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($regulasi) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('kelola-regulasi.create')->with($status, $response);
        }

        return redirect('kelola-regulasi')->with($status, $response);
    }

    /**
     * @param Regulasi $kelola_regulasi
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Regulasi $kelola_regulasi)
    {
        $image = 'image';
        $file = 'file';
        return view('kelola::regulasi.form', compact('kelola_regulasi', 'file', 'image'));
    }

    /**
     * @param RegulasiRequest $request
     * @param Regulasi $kelola_regulasi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(RegulasiRequest $request, Regulasi $kelola_regulasi)
    {
        $values = $request->except(['_token', '_method']);

        if (isset($values['image'])) {
            $current_time = Carbon::now();
            $date = $current_time->toDateString();
            $time = $current_time->toTimeString();
            $ext = $values['image']->getClientOriginalExtension();
            $file = $values['image']->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $values['title']) . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '.' . $ext, 'public_asset_regulasi');
            $values['image'] = $file;
        }

        if (isset($values['file'])) {
            $current_time = Carbon::now();
            $date = $current_time->toDateString();
            $time = $current_time->toTimeString();
            $ext = $values['file']->getClientOriginalExtension();
            $file = $values['file']->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $values['title']) . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '.' . $ext, 'public_asset_regulasi_file');
            $values['file'] = $file;
        }

        foreach ($values as $key => $value) {
            $kelola_regulasi->$key = $value;
        }

        $message = ['key' => 'Kelola Regulasi', 'value' => $kelola_regulasi->title];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        if ($kelola_regulasi->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-regulasi')->with($status, $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        // dd('a');exit();
        $kelola_regulasi = Regulasi::findOrFail($id);
        $file = 'file';
        return view('kelola::regulasi.show', compact('kelola_regulasi', 'file'));
    }

    /**
     * @param Request $request
     * @param Regulasi $kelola_regulasi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, Regulasi $kelola_regulasi)
    {
        $message = ['key' => 'Kelola Regulasi', 'value' => $kelola_regulasi->title];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($kelola_regulasi->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-regulasi')->with($status, $response);
    }
}
