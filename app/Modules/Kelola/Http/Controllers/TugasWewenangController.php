<?php
namespace Modules\Kelola\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Kelola\Entities\TugasWewenang;
use Modules\Kelola\Http\Requests\TugasWewenangRequest;

class TugasWewenangController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = TugasWewenang::fetch($request);
        return view('kelola::tugaswewenang.default', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $kelola_tugaswewenang = new TugasWewenang;
        return view('kelola::tugaswewenang.form', compact('kelola_tugaswewenang'));
    }

    /**
     * @param TugasWewenangRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(TugasWewenangRequest $request)
    {
        $values = $request->except(['_token', 'save']);

        $tugaswewenang = TugasWewenang::create($values);
        
        $message = ['key' => 'Kelola Tugas Wewenang', 'value' => $values['title']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($tugaswewenang) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('kelola-tugaswewenang.create')->with($status, $response);
        }

        return redirect('kelola-tugaswewenang')->with($status, $response);
    }

    /**
     * @param TugasWewenang $kelola_tugaswewenang
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(TugasWewenang $kelola_tugaswewenang)
    {
        $image = 'image';
        return view('kelola::tugaswewenang.form', compact('kelola_tugaswewenang','image'));
    }

    /**
     * @param TugasWewenangRequest $request
     * @param TugasWewenang $kelola_tugaswewenang
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(TugasWewenangRequest $request, TugasWewenang $kelola_tugaswewenang)
    {
        $values = $request->except(['_token', '_method']);

        foreach ($values as $key => $value) {
            $kelola_tugaswewenang->$key = $value;
        }

        $message = ['key' => 'Kelola Tugas Wewenang', 'value' => $kelola_tugaswewenang->title];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        if ($kelola_tugaswewenang->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-tugaswewenang')->with($status, $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        // dd('a');exit();
        $kelola_tugaswewenang = TugasWewenang::findOrFail($id);
        return view('kelola::tugaswewenang.show', compact('kelola_tugaswewenang'));
    }

    /**
     * @param Request $request
     * @param TugasWewenang $kelola_tugaswewenang
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, TugasWewenang $kelola_tugaswewenang)
    {
        $message = ['key' => 'Kelola TugasWewenang', 'value' => $kelola_tugaswewenang->title];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($kelola_tugaswewenang->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-tugaswewenang')->with($status, $response);
    }
}