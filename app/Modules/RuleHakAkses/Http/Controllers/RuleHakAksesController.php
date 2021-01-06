<?php

namespace Modules\RuleHakAkses\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HCS\Entities\Grade;
use Modules\RuleHakAkses\Entities\RuleHakAkses;
use Modules\RuleHakAkses\Http\Requests\RuleHakAksesRequest;

class RuleHakAksesController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = RuleHakAkses::fetch($request);
        $grade = to_dropdown(Grade::where('status', 1)->orderBy('kode')->get(), 'kode', 'nama');

        return view('rule-hak-akses::default', compact('data', 'grade'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $rule_hak_akse = new RuleHakAkses;
        $grade = to_dropdown(Grade::where('status', 1)->orderBy('kode')->get(), 'kode', 'nama');

        return view('rule-hak-akses::form', compact('rule_hak_akse', 'grade'));
    }

    /**
     * @param RuleHakAksesRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(RuleHakAksesRequest $request)
    {
        $ruleHakAkses = new RuleHakAkses;
        $values = $request->except(['_token', 'save']);

        foreach ($values as $key => $value) {
            $ruleHakAkses->$key = $value;
        }

        $message = ['key' => 'Rule Hak Akses', 'value' => 'Grade ' . implode(', ', $values['grade']) . ' untuk Level Hak Akses ' . config('options.level_hakakses')[$values['primary_level']]];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($ruleHakAkses->save()) {
            $status = 'success';
            $response = trans('message.create_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('rule-hak-akses.create')->with($status, $response);
        }

        return redirect('rule-hak-akses')->with($status, $response);
    }

    /**
     * @param RuleHakAkses $rule_hak_akse
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(RuleHakAkses $rule_hak_akse)
    {
        $grade = to_dropdown(Grade::where('status', 1)->orderBy('kode')->get(), 'kode', 'nama');

        return view('rule-hak-akses::form', compact('rule_hak_akse', 'grade'));
    }

    /**
     * @param RuleHakAksesRequest $request
     * @param RuleHakAkses $rule_hak_akse
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(RuleHakAksesRequest $request, RuleHakAkses $rule_hak_akse)
    {
        $values = $request->except(['_token', '_method']);

        foreach ($values as $key => $value) {
            $rule_hak_akse->$key = $value;
        }

        $message = ['key' => 'Rule Hak Akses', 'value' => 'Grade ' . implode(', ', $values['grade']) . ' untuk Level Hak Akses ' . config('options.level_hakakses')[$rule_hak_akse->primary_level]];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        if ($rule_hak_akse->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('rule-hak-akses')->with($status, $response);
    }

    /**
     * @param Request $request
     * @param RuleHakAkses $rule_hak_akse
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, RuleHakAkses $rule_hak_akse)
    {
        $message = ['key' => 'Rule Hak Akses', 'value' => 'Grade ' . implode(', ', $rule_hak_akse->grade) . ' untuk Level Hak Akses ' . config('options.level_hakakses')[$rule_hak_akse->primary_level]];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($rule_hak_akse->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('rule-hak-akses')->with($status, $response);
    }
}