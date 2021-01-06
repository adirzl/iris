<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
            'nama' => 'required|string',
            'nip' => 'required|numeric|max:20',
            'email' => 'required|email',
            'hp' => 'required|numeric|max:16',
            'wilayah_kode' => 'required|numeric|max:10',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => __('validation.required', ['attribute' => 'Username']),
            'username.string' => __('validation.string', ['attribute' => 'Username']),
            'password.required' => __('validation.required', ['attribute' => 'Password']),
            'password.string' => __('validation.string', ['attribute' => 'Password']),
            'password.confirmed' => __('validation.confirmed', ['attribute' => 'Password']),
            'password.min' => __('validation.min', ['attribute' => 'Password', 'min' => 8]),
            'nama.required' => __('validation.required', ['attribute' => 'Nama']),
            'nama.string' => __('validation.string', ['attribute' => 'Nama']),
            'nip.required' => __('validation.required', ['attribute' => 'NIP']),
            'nip.numeric' => __('validation.numeric', ['attribute' => 'NIP']),
            'nip.max' => __('validation.max', ['attribute' => 'NIP', 'max' => 20]),
            'email.required' => __('validation.required', ['attribute' => 'Email']),
            'email.email' => __('validation.string', ['attribute' => 'Email']),
            'hp.required' => __('validation.required', ['attribute' => 'No. HP']),
            'hp.numeric' => __('validation.numeric', ['attribute' => 'No. HP']),
            'hp.max' => __('validation.max', ['attribute' => 'No. HP', 'max' => 16]),
            'wilayah_kode.required' => __('validation.required', ['attribute' => 'Wilayah']),
            'wilayah_kode.numeric' => __('validation.numeric', ['attribute' => 'Wilayah']),
            'wilayah_kode.max' => __('validation.max', ['attribute' => 'Wilayah', 'max' => 10]),
        ];
    }
}
