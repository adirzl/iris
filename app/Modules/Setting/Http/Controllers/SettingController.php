<?php

namespace Modules\Setting\Http\Controllers;

use App\Entities\Configuration;
use Illuminate\Http\Request;
use Modules\Setting\Http\Requests\SettingRequest;

class SettingController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke(Request $request)
    {
        $data = Configuration::select(['key', 'value', 'shortdesc'])->where('user_config', '<>', 0)
            ->orderBy('user_config')
            ->orderBy('key')
            ->get();

        return view('setting::default', compact('data'));
    }

    /**
     * @param SettingRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(SettingRequest $request)
    {
        $values = $request->except('_token');

        if (isset($values['logo'])) {
            $ext = $values['logo']->getClientOriginalExtension();
            $file = $values['logo']->storeAs('img', 'logo.' . $ext, 'public_asset');
            $values['logo'] = $file;
        }

        foreach ($values as $key => $value) {
            Configuration::where('key', $key)->update(['value' => $value]);
        }

        $status = 'info';
        $response = trans('message.update_setting');

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('setting')->with($status, $response);
    }
}