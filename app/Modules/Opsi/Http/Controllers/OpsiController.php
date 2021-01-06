<?php

namespace Modules\Opsi\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Opsi\Entities\OptionGroup;
use Modules\Opsi\Http\Requests\OpsiRequest;

class OpsiController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = OptionGroup::fetch($request);

        return view('opsi::default', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $opsi = new OptionGroup;

        return view('opsi::form', compact('opsi'));
    }

    /**
     * @param OpsiRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(OpsiRequest $request)
    {
        $opsi = new OptionGroup;
        $values = $request->only(['name']); 
        $options = collect($request->only('keys')['keys'])->combine($request->only('values')['values']);
        $i = 1;
        // dd($options);
        foreach ($values as $key => $value) {
            $opsi->$key = $value;
        }

        $message = ['key' => 'Option', 'value' => $values['name']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($opsi->save()) {
            $status = 'success';
            $response = trans('message.create_success', $message);

            foreach ($options as $key => $value) {
                $opsi->optionValues()->create(['key' => $key, 'value' => $value, 'sequence' => $i]);
                ++$i;
            }
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('opsi.create')->with($status, $response);
        }

        return redirect('opsi')->with($status, $response);
    }

    /**
     * @param OptionGroup $opsi
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(OptionGroup $opsi)
    {
        return view('opsi::form', compact('opsi'));
    }

    /**
     * @param OpsiRequest $request
     * @param OptionGroup $opsi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(OpsiRequest $request, OptionGroup $opsi)
    {
        $values = $request->only(['name']);

        foreach ($values as $key => $value) {
            $opsi->$key = $value;
        }

        $message = ['key' => 'Option', 'value' => $opsi->name];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        if ($opsi->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('opsi')->with($status, $response);
    }

    /**
     * @param Request $request
     * @param OptionGroup $opsi
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, OptionGroup $opsi)
    {
        $message = ['key' => 'Option', 'value' => $opsi->name];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($opsi->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('opsi')->with($status, $response);
    }
}