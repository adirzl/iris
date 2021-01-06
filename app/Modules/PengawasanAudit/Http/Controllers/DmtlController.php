<?php
namespace Modules\PengawasanAudit\Http\Controllers;

use Illuminate\Http\Request;
use Modules\PengawasanAudit\Entities\DmtlAudit;
use Modules\PengawasanAudit\Http\Requests\DMTLRequest;

class DmtlController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = DmtlAudit::fetch($request);
        return view('PengawasanAudit::dmtl.default', compact('data'));
    }

    /** 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $dmtl_audit = new DmtlAudit;

        return view('PengawasanAudit::dmtl.form', compact('dmtl_audit'));
    }

    /**
     * @param ArtikelRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ArtikelRequest $request)
    {
        $values = $request->except(['_token', 'save']);

        if (isset($values['image'])) {
            $ext = $values['image']->getClientOriginalExtension();
            $file = $values['image']->storeAs(null, preg_replace('/\s+/', '_', $values['title']) . '.' . $ext, 'public_asset_artikel');
            $values['image'] = $file;
        }

        if (isset($values['file'])) {
            $ext = $values['file']->getClientOriginalExtension();
            $file = $values['file']->storeAs(null, preg_replace('/\s+/', '_', $values['title']) . '.' . $ext, 'public_asset_artikel_file');
            $values['file'] = $file;
        }

        $artikel = Artikel::create($values);
        
        $message = ['key' => 'Kelola Artikel', 'value' => $values['title']];
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
            return redirect()->route('kelola-artikel.create')->with($status, $response);
        }

        return redirect('kelola-artikel')->with($status, $response);
    }

    /**
     * @param Artikel $kelola_artikel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Artikel $dmtl_audit)
    {
        $image = 'image';
        $file = 'file';
        return view('kelola::artikel.form', compact('dmtl_audit'));
    }

    /**
     * @param ArtikelRequest $request
     * @param Artikel $kelola_artikel
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ArtikelRequest $request, Artikel $kelola_artikel)
    {
        $values = $request->except(['_token', '_method']);

        if (isset($values['image'])) {
            $ext = $values['image']->getClientOriginalExtension();
            $file = $values['image']->storeAs(null, preg_replace('/\s+/', '_', $values['title']) . '.' . $ext, 'public_asset_artikel');
            $values['image'] = $file;
        }

        if (isset($values['file'])) {
            $ext = $values['file']->getClientOriginalExtension();
            $file = $values['file']->storeAs(null, preg_replace('/\s+/', '_', $values['title']) . '.' . $ext, 'public_asset_artikel_file');
            $values['file'] = $file;
        }

        foreach ($values as $key => $value) {
            $kelola_artikel->$key = $value;
        }

        $message = ['key' => 'Kelola Artikel', 'value' => $kelola_artikel->title];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        if ($kelola_artikel->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-artikel')->with($status, $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        // dd('a');exit();
        $kelola_artikel = Artikel::findOrFail($id);
        $image = 'image';
        $file = 'file';
        return view('kelola::artikel.show', compact('kelola_artikel','image','file'));
    }

    /**
     * @param Request $request
     * @param Artikel $kelola_artikel
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, Artikel $kelola_artikel)
    {
        $message = ['key' => 'Kelola Artikel', 'value' => $kelola_artikel->title];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($kelola_artikel->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-artikel')->with($status, $response);
    }
}