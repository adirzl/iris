<?php

namespace Modules\Kelola\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Kelola\Entities\Struktur;
use Modules\Kelola\Http\Requests\StrukturRequest;
use Carbon\Carbon;

class StrukturController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $data = Struktur::select(['key', 'value', 'shortdesc'])->orderBy('key', 'desc')->get();
        return view('kelola::struktur.default', compact('data'));
    }

    /**
     * @param StrukturRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(StrukturRequest $request)
    {
        $values = $request->except('_token');

        if (isset($values['image'])) {
            $current_time = Carbon::now();
            $date = $current_time->toDateString();
            $time = $current_time->toTimeString();
            $ext = $values['image']->getClientOriginalExtension();
            $file = $values['image']->storeAs(null, preg_replace('/[^\w@,.;]/', '_', $values['company_name']) . '_' . $date . '_' . preg_replace('/[^\w@,.;]/', '_', $time) . '.' . $ext, 'public_asset_struktur');
            $values['image'] = $file;
        }

        foreach ($values as $key => $value) {
            Struktur::where('key', $key)->update(['value' => $value]);
        }

        $status = 'info';
        $response = trans('message.update_success');

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('kelola-struktur')->with($status, $response);
    }
}
