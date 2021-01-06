<?php

namespace Modules\LimitOtorisasi\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HCS\Entities\Jabatan;
use Modules\LimitOtorisasi\Entities\LimitOtorisasi;
use Modules\LimitOtorisasi\Http\Requests\LimitOtorisasiRequest;

class LimitOtorisasiController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = LimitOtorisasi::fetch($request);
        $jabatan = to_dropdown(Jabatan::where('status', 1)->get(), 'kode', 'nama');

        return view('limit-otorisasi::default', compact('data', 'jabatan'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $limit_otorisasi = new LimitOtorisasi;
        $jabatan = to_dropdown(Jabatan::where('status', 1)->get(), 'kode', 'nama');

        return view('limit-otorisasi::form', compact('limit_otorisasi', 'jabatan'));
    }

    /**
     * @param LimitOtorisasiRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(LimitOtorisasiRequest $request)
    {
        $limitOtorisasi = new LimitOtorisasi;
        $values = $request->except(['_token', 'save']);

        foreach ($values as $key => $value) {
            $limitOtorisasi->$key = $value;
        }

        $message = ['key' => 'Limit Otorisasi', 'value' => $values['kode']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($limitOtorisasi->save()) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('limit-otorisasi.create')->with($status, $response);
        }

        return redirect('limit-otorisasi')->with($status, $response);
    }

    /**
     * @param LimitOtorisasi $limit_otorisasi
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(LimitOtorisasi $limit_otorisasi)
    {
        $jabatan = to_dropdown(Jabatan::where('status', 1)->get(), 'kode', 'nama');

        return view('limit-otorisasi::form', compact('limit_otorisasi', 'jabatan'));
    }

    /**
     * @param LimitOtorisasiRequest $request
     * @param LimitOtorisasi $limit_otorisasi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(LimitOtorisasiRequest $request, LimitOtorisasi $limit_otorisasi)
    {
        $values = $request->except(['_token', '_method']);

        foreach ($values as $key => $value) {
            $limit_otorisasi->$key = $value;
        }

        $message = ['key' => 'Limit Otorisasi', 'value' => $limit_otorisasi->kode];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        if ($limit_otorisasi->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('limit-otorisasi')->with($status, $response);
    }

    /**
     * @param Request $request
     * @param LimitOtorisasi $limit_otorisasi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, LimitOtorisasi $limit_otorisasi)
    {
        $message = ['key' => 'Limit Otorisasi', 'value' => $limit_otorisasi->kode];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($limit_otorisasi->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('limit-otorisasi')->with($status, $response);
    }
}