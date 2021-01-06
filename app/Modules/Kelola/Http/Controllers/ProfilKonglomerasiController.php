<?php

namespace Modules\Kelola\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Kelola\Entities\Profil;
use Modules\Kelola\Http\Requests\ProfilKonglomerasiRequest;
use Carbon\Carbon;

class ProfilKonglomerasiController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = Profil::orderBY('status', 'ASC')->fetch($request);
        return view('kelola::profilkonglomerasi.default', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $kelola_profilkonglomerasi = new Profil;
        $image = 'image';
        return view('kelola::profilkonglomerasi.form', compact('kelola_profilkonglomerasi', 'image'));
    }

    /**
     * @param ProfilKonglomerasiRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ProfilKonglomerasiRequest $request)
    {
        $values = $request->except(['_token', 'save']);

        if (isset($values['image'])) {
            $current_time = Carbon::now();
            $date = $current_time->toDateString();
            $time = $current_time->toTimeString();
            $ext = $values['image']->getClientOriginalExtension();
            $file = $values['image']->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $values['title']) . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '.' . $ext, 'public_asset_profil');
            $values['image'] = $file;
        }

        $profil = Profil::create($values);

        $message = ['key' => 'Profil Konglomerasi', 'value' => $values['title']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($profil) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('kelola-profilkonglomerasi.create')->with($status, $response);
        }

        return redirect('kelola-profilkonglomerasi')->with($status, $response);
    }

    /**
     * @param Profil $kelola_profilkonglomerasi
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Profil $kelola_profilkonglomerasi)
    {
        $image = 'image';
        return view('kelola::profilkonglomerasi.form', compact('kelola_profilkonglomerasi', 'image'));
    }

    /**
     * @param ProfilKonglomerasiRequest $request
     * @param Profil $kelola_profilkonglomerasi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ProfilKonglomerasiRequest $request, Profil $kelola_profilkonglomerasi)
    {
        $values = $request->except(['_token', '_method']);

        if (isset($values['image'])) {
            $current_time = Carbon::now();
            $date = $current_time->toDateString();
            $time = $current_time->toTimeString();
            $ext = $values['image']->getClientOriginalExtension();
            $file = $values['image']->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $values['title']) . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '.' . $ext, 'public_asset_profil');
            $values['image'] = $file;
        }

        foreach ($values as $key => $value) {
            $kelola_profilkonglomerasi->$key = $value;
        }

        $message = ['key' => 'Profil Konglomerasi', 'value' => $kelola_profilkonglomerasi->title];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        if ($kelola_profilkonglomerasi->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-profilkonglomerasi')->with($status, $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $kelola_profil = Profil::findOrFail($id);
        $image = 'image';
        return view('kelola::profilkonglomerasi.show', compact('kelola_profil', 'image'));
    }

    /**
     * @param Request $request
     * @param Profil $kelola_profilkonglomerasi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, Profil $kelola_profilkonglomerasi)
    {
        $message = ['key' => 'Profil Konglomerasi', 'value' => $kelola_profilkonglomerasi->title];
        $status = 'error';
        $response = trans('message.delete_failed', $message);
        if ($kelola_profilkonglomerasi->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-profilkonglomerasi')->with($status, $response);
    }
}
