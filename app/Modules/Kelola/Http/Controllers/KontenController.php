<?php

namespace Modules\Kelola\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Kelola\Entities\Konten;
use Modules\Kelola\Http\Requests\KontenRequest;
use Carbon\Carbon;

class KontenController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = Konten::orderBY('status', 'ASC')->fetch($request);
        return view('kelola::konten.default', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $kelola_konten = new Konten;
        $image = 'image';
        return view('kelola::konten.form', compact('kelola_konten', 'image'));
    }

    /**
     * @param KontenRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(KontenRequest $request)
    {
        $values = $request->except(['_token', 'save']);

        if (isset($values['image'])) {
            $current_time = Carbon::now();
            $date = $current_time->toDateString();
            $time = $current_time->toTimeString();
            $ext = $values['image']->getClientOriginalExtension();
            $file = $values['image']->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $values['title']) . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '.' . $ext, 'public_asset_konten');
            $values['image'] = $file;
        }

        $konten = Konten::create($values);

        $message = ['key' => 'Konten', 'value' => $values['title']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($konten) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('kelola-konten.create')->with($status, $response);
        }

        return redirect('kelola-konten')->with($status, $response);
    }

    /**
     * @param Konten $kelola_konten
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Konten $kelola_konten)
    {
        $image = 'image';
        return view('kelola::konten.form', compact('kelola_konten', 'image'));
    }

    /**
     * @param KontenRequest $request
     * @param Konten $kelola_konten
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(KontenRequest $request, Konten $kelola_konten)
    {
        $values = $request->except(['_token', '_method']);

        if (isset($values['image'])) {
            $current_time = Carbon::now();
            $date = $current_time->toDateString();
            $time = $current_time->toTimeString();
            $ext = $values['image']->getClientOriginalExtension();
            $file = $values['image']->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $values['title']) . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '.' . $ext, 'public_asset_konten');
            $values['image'] = $file;
        }

        foreach ($values as $key => $value) {
            $kelola_konten->$key = $value;
        }

        $message = ['key' => 'Konten', 'value' => $kelola_konten->title];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        if ($kelola_konten->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-konten')->with($status, $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $kelola_konten = Konten::findOrFail($id);
        $image = 'image';
        return view('kelola::konten.show', compact('kelola_konten', 'image'));
    }

    /**
     * @param Request $request
     * @param Konten $kelola_konten
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, Konten $kelola_konten)
    {
        $message = ['key' => 'Konten', 'value' => $kelola_konten->title];
        $status = 'error';
        $response = trans('message.delete_failed', $message);
        if ($kelola_konten->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-konten')->with($status, $response);
    }
}
