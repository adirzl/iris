<?php

namespace Modules\Kelola\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Kelola\Entities\Banner;
use Modules\Kelola\Http\Requests\BannerRequest;
use Carbon\Carbon;

class BannerController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = Banner::fetch($request);
        return view('kelola::banner.default', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $kelola_banner = new Banner;
        $image = 'image';
        return view('kelola::banner.form', compact('kelola_banner', 'image'));
    }

    /**
     * @param BannerRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(BannerRequest $request)
    {
        $values = $request->except(['_token', 'save']);

        if (isset($values['image'])) {
            $current_time = Carbon::now();
            $date = $current_time->toDateString();
            $time = $current_time->toTimeString();
            $ext = $values['image']->getClientOriginalExtension();
            $file = $values['image']->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $values['title']) . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '.' . $ext, 'public_asset');
            $values['image'] = $file;
        }

        $banner = Banner::create($values);

        $message = ['key' => 'Kelola Banner', 'value' => $values['title']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($banner) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('kelola-banner.create')->with($status, $response);
        }

        return redirect('kelola-banner')->with($status, $response);
    }

    /**
     * @param Banner $kelola_banner
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Banner $kelola_banner)
    {
        $image = 'image';
        return view('kelola::banner.form', compact('kelola_banner', 'image'));
    }

    /**
     * @param BannerRequest $request
     * @param Banner $kelola_banner
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(BannerRequest $request, Banner $kelola_banner)
    {
        $values = $request->except(['_token', '_method']);

        if (isset($values['image'])) {
            $current_time = Carbon::now();
            $date = $current_time->toDateString();
            $time = $current_time->toTimeString();
            $ext = $values['image']->getClientOriginalExtension();
            $file = $values['image']->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $values['title']) . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '.' . $ext, 'public_asset');
            $values['image'] = $file;
        }

        foreach ($values as $key => $value) {
            $kelola_banner->$key = $value;
        }

        $message = ['key' => 'Kelola Banner', 'value' => $kelola_banner->title];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        if ($kelola_banner->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-banner')->with($status, $response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        // dd('a');exit();
        $kelola_banner = Banner::findOrFail($id);
        $image = 'image';
        return view('kelola::banner.show', compact('kelola_banner', 'image'));
    }

    /**
     * @param Request $request
     * @param Banner $kelola_banner
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, Banner $kelola_banner)
    {
        $message = ['key' => 'Kelola Banner', 'value' => $kelola_banner->title];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($kelola_banner->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-banner')->with($status, $response);
    }
}
