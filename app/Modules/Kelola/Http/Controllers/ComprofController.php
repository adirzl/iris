<?php

namespace Modules\Kelola\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Kelola\Entities\Comprof;
use Modules\Kelola\Http\Requests\ComprofRequest;
use Carbon\Carbon;

class ComprofController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = Comprof::fetch($request);
        return view('kelola::comprof.default', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $kelola_comprof = new Comprof;
        $image = 'image';
        return view('kelola::comprof.form', compact('kelola_comprof', 'image'));
    }

    /**
     * @param ComprofRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ComprofRequest $request)
    {
        $values = $request->except(['_token', 'save']);

        if (isset($values['image'])) {
            $current_time = Carbon::now();
            $date = $current_time->toDateString();
            $time = $current_time->toTimeString();
            $ext = $values['image']->getClientOriginalExtension();
            $file = $values['image']->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $values['company_name']) . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '.' . $ext, 'public_asset_comprof');
            $values['image'] = $file;
        }

        $comprof = Comprof::create($values);

        $message = ['key' => 'Kelola Company Profile', 'value' => $values['company_name']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($comprof) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('kelola-comprof.create')->with($status, $response);
        }

        return redirect('kelola-comprof')->with($status, $response);
    }

    /**
     * @param Comprof $kelola_comprof
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Comprof $kelola_comprof)
    {
        $image = 'image';
        return view('kelola::comprof.form', compact('kelola_comprof', 'image'));
    }

    /**
     * @param ComprofRequest $request
     * @param Comprof $kelola_comprof
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ComprofRequest $request, Comprof $kelola_comprof)
    {
        $values = $request->except(['_token', '_method']);

        if (isset($values['image'])) {
            $current_time = Carbon::now();
            $date = $current_time->toDateString();
            $time = $current_time->toTimeString();
            $ext = $values['image']->getClientOriginalExtension();
            $file = $values['image']->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $values['company_name']) . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '.' . $ext, 'public_asset_comprof');
            $values['image'] = $file;
        }

        foreach ($values as $key => $value) {
            $kelola_comprof->$key = $value;
        }

        $message = ['key' => 'Kelola Company Profile', 'value' => $kelola_comprof->company_name];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        if ($kelola_comprof->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-comprof')->with($status, $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        // dd('a');exit();
        $kelola_comprof = Comprof::findOrFail($id);
        $image = 'image';
        return view('kelola::comprof.show', compact('kelola_comprof', 'image'));
    }

    /**
     * @param Request $request
     * @param Comprof $kelola_comprof
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, Comprof $kelola_comprof)
    {
        $message = ['key' => 'Kelola Comprof', 'value' => $kelola_comprof->company_name];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($kelola_comprof->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-comprof')->with($status, $response);
    }
}
