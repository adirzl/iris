<?php

namespace App\Concerns;

use Illuminate\Foundation\Auth\AuthenticatesUsers as BaseAuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

trait AuthenticatesUsers
{
    use BaseAuthenticatesUsers, AuthenticatesFrom;

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);
        if (strlen($credentials[$this->username()]) == 4 && config('auth.force_local') === false) {
            $authenticated = $this->uim($credentials);
        } else {
            $authenticated =  $this->guard()->attempt($credentials, $request->filled('remember'));
        }
        if ($authenticated) {
            $user = \Modules\User\Entities\User::findByUsername($credentials[$this->username()]);
            $this->guard()->login($user);

            if (!$user->hasAnyRole((\Modules\HakAkses\Entities\Role::all())->pluck('name')->toArray())) {
                $this->guard()->logout();
                $this->sendNotAllowedLoginResponse($request);

                return false;
            }

            if ($user->status == 9) {
                $this->guard()->logout();
                $this->sendBlockedCredentialsResponse($request);

                return false;
            }

            // if (!is_null($user->session_id) && $user->session_id !== Session::getId()) {
            //     $this->guard()->logout();
            //     $this->sendMultipleLoggedInNotAllowedResponse($request);

            //     return false;
            // }

            return true;
        }

        return false;
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // $user->session_id = Session::getId();
        $user->last_activity = now();
        $user->save();
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * @param Request $request
     */
    protected function sendNotAllowedLoginResponse(Request $request)
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            $this->username() => [trans('auth.not_allowed')],
        ]);
    }

    /**
     * @param Request $request
     */
    protected function sendBlockedCredentialsResponse(Request $request)
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            $this->username() => ['Identitas Anda diblokir.'],
        ]);
    }

    /**
     * @param Request $request
     */
    protected function sendMultipleLoggedInNotAllowedResponse(Request $request)
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            $this->username() => ['Identitas Anda sedang digunakan pada perangkat lain.'],
        ]);
    }

    /**
     *
     */
    protected function clearSessionId()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $user->session_id = null;
            $user->save();
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->clearSessionId();

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }
}
