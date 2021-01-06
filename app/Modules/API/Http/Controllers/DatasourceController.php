<?php

namespace Modules\API\Http\Controllers;

use Illuminate\Http\Request;
use Modules\API\Entities\Datasource;
use Modules\API\Http\Requests\DatasourceRequest;

class DatasourceController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = Datasource::fetch($request);

        return view('api::datasource.default', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $datasource = new Datasource;

        return view('api::datasource.form', compact('datasource'));
    }

    /**
     * @param DatasourceRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(DatasourceRequest $request)
    {
        $datasource = new Datasource;
        $values = $request->except(['_token', 'save']);
        $values['properties'] = collect($values['key'])->combine($values['value'])->toJson();
        unset($values['key'], $values['value']);

        foreach ($values as $key => $value) {
            $datasource->$key = $value;
        }

        $message = ['key' => 'Datasource', 'value' => $values['nama']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($datasource->save()) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('datasource.create')->with($status, $response);
        }

        return redirect('datasource')->with($status, $response);
    }

    /**
     * @param Datasource $datasource
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Datasource $datasource)
    {
        return view('api::datasource.form', compact('datasource'));
    }

    /**
     * @param DatasourceRequest $request
     * @param Datasource $datasource
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(DatasourceRequest $request, Datasource $datasource)
    {
        $values = $request->except(['_token', '_method']);
        $values['properties'] = collect($values['key'])->combine($values['value'])->toJson();
        unset($values['key'], $values['value']);

        foreach ($values as $key => $value) {
            $datasource->$key = $value;
        }

        $message = ['key' => 'Datasource', 'value' => $datasource->nama];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        if ($datasource->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('datasource')->with($status, $response);
    }

    /**
     * @param Request $request
     * @param Datasource $datasource
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, Datasource $datasource)
    {
        $message = ['key' => 'Datasource', 'value' => $datasource->nama];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($datasource->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('datasource')->with($status, $response);
    }
}