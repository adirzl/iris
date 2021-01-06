<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Modules\HakAkses\Entities\Role;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\UserRequest;

class UserController extends \App\Http\Controllers\Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = User::fetch($request, auth()->user()->roles->pluck('name')->first());
        $roles = to_dropdown(Role::all(), 'id', 'name');

        return view('user::default', compact('data', 'roles'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $user = new User;
        $roles = to_dropdown(Role::all(), 'id', 'name');

        return view('user::form', compact('user', 'roles'));
    }

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(UserRequest $request)
    {
        $user = new User;
        $values = $request->only('email');
        $profile = $request->only(['nama', 'nip', 'hp']);
        $role = Role::findById($request->only('role_id')['role_id']);
        $values['username'] = $profile['nip'];
        $values['password'] = \Illuminate\Support\Str::random(8);

        if (config('parameter.verified_email')) {
            $values['status'] = 0;
        } else {
            $values['email_verified_at'] = now();
            $values['status'] = 1;
        }

        foreach ($values as $key => $value) {
            $user->$key = $value;
        }

        $message = ['key' => 'User', 'value' => $values['username']];
        $status = 'error';
        $response = trans('message.create_failed', $message);

        if ($user->save()) {
            $status = 'success';
            $response = trans('message.create_success', $message);
            $user->profile()->create($profile);
            $user->assignRole($role->name);
            $user->givePermissionTo($role->permissions->pluck('name')->toArray());
            event(new \Illuminate\Auth\Events\Registered($user));
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        if ($request->only('save')) {
            return redirect()->route('create')->with($status, $response);
        }

        return redirect('user')->with($status, $response);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('user::show', compact('user'));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Request $request, User $user)
    {
        $message = ['key' => 'User', 'value' => $user->username];
        $status = 'error';
        $response = trans('message.delete_failed', $message);

        if ($user->delete()) {
            $status = 'success';
            $response = trans('message.delete_success', $message);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('user')->with($status, $response);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function block(Request $request, User $user)
    {
        $user->status = 9;
        $message = ['User', $user->profile->nama];
        $status = 'error';
        $response = str_replace(['key', 'value'], $message, 'Blokir `value` dari `key` gagal dilakukan.');

        if ($user->save()) {
            $status = 'success';
            $response = str_replace(['key', 'value'], $message, 'Blokir `value` dari `key` berhasil dilakukan.');
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('user')->with($status, $response);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function unblock(Request $request, User $user)
    {
        $user->status = 1;
        $message = ['User', $user->profile->nama];
        $status = 'error';
        $response = str_replace(['key', 'value'], $message, 'Blokir `value` dari `key` gagal dilakukan.');

        if ($user->save()) {
            $status = 'success';
            $response = str_replace(['key', 'value'], $message, 'Blokir `value` dari `key` berhasil dilakukan.');
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('user')->with($status, $response);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function release(Request $request, User $user)
    {
        $user->session_id = null;
        $message = ['User', $user->profile->nama];
        $status = 'error';
        $response = str_replace(['key', 'value'], $message, 'Release `value` dari `key` gagal dilakukan.');

        if ($user->save()) {
            $status = 'success';
            $response = str_replace(['key', 'value'], $message, 'Release `value` dari `key` berhasil dilakukan.');
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('user')->with($status, $response);
    }
}