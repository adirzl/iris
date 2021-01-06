<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Entities\User;
use Modules\User\Http\Requests\ProfileRequest;

class ProfileController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        $data = auth()->user();

        return view('user::profile', compact('data'));
    }

    /**
     * @param ProfileRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ProfileRequest $request)
    {
        $user = User::findById(auth()->user()->id);
        $values = $request->only(['username', 'password', 'password_confirmation', 'email']);
        $profile = $request->only(['nama', 'nip', 'hp']);

        foreach ($values as $key => $value) {
            $user->$key = $value;
        }

        $message = ['key' => 'Profile', 'value' => $user->profile->nama];
        $status = 'error';
        $response = trans('message.update_failed', $message);

        if ($user->save()) {
            $status = 'success';
            $response = trans('message.update_success', $message);
            $user->profile()->update($profile);
        }

        if ($request->ajax()) {
            return response()->json(['message' => $response, 'status' => $status]);
        }

        return redirect('profile')->with($status, $response);
    }
}