<?php

namespace Modules\HakAkses\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HakAkses\Entities\Role;
use Modules\HakAkses\Http\Requests\HakAksesRequest;

class HakAksesController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = Role::fetch($request);

        return view('hakakses::default', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $hak_akse = new Role;
        $permissions = forPermissions();

        return view('hakakses::form', array_merge(['permission' => $hak_akse], $permissions));
    }

    /**
     * @param HakAksesRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(HakAksesRequest $request)
    {
        $role = new Role;
        $values = $request->only(['name']);
        $values['id'] = Role::getNewId();

        foreach ($values as $key => $value) {
            $role->$key = $value;
        }

        $message = ['key' => 'Hak Akses', 'value' => $values['name']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($role->save()) {
            $status = 'success';
            $response = trans('message.create_success', $message);
            Role::syncModules($role->id, $request->only('modules')['modules']);
            $role->givePermissionTo($request->only('permissions')['permissions']);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('hak-akses.create')->with($status, $response);
        }

        return redirect('hak-akses')->with($status, $response);
    }

    /**
     * @param Role $hak_akse
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $hak_akse)
    {
        $permissions = forPermissions();

        return view('hakakses::form', array_merge(['permission' => $hak_akse], $permissions));
    }

    /**
     * @param HakAksesRequest $request
     * @param Role $hak_akse
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(HakAksesRequest $request, Role $hak_akse)
    {
        $values = $request->only(['name']);

        foreach ($values as $key => $value) {
            $hak_akse->$key = $value;
        }

        $message = ['key' => 'Hak Akses', 'value' => $hak_akse->name];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        if ($hak_akse->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
            Role::syncModules($hak_akse->id, $request->only('modules')['modules']);
            $hak_akse->syncPermissions($request->only('permissions')['permissions']);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('hak-akses')->with($status, $response);
    }

    /**
     * @param Request $request
     * @param Role $hak_akse
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, Role $hak_akse)
    {
        $message = ['key' => 'Hak Akses', 'value' => $hak_akse->name];
        $status = 'error';
        $response = trans('message.delete_failed', $message);
        $roleTemp = $hak_akse;
        $permissions = $hak_akse->permissions->pluck('name')->toArray();

        if ($hak_akse->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
            $roleTemp->revokePermissionTo($permissions);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('hak-akses')->with($status, $response);
    }
}