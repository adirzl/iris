<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('user'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role_id' => 'required|integer',
            'nama' => 'required|string',
            'nip' => 'required|string|max:20',
            'email' => 'required|email',
            'hp' => 'required|string|max:16',
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
            'role_id.required' => __('validation.required', ['attribute' => 'Hak Akses']),
            'role_id.integer' => __('validation.integer', ['attribute' => 'Hak Akses']),
            'nama.required' => __('validation.required', ['attribute' => 'Nama']),
            'nama.string' => __('validation.string', ['attribute' => 'Nama']),
            'nip.required' => __('validation.required', ['attribute' => 'NIP']),
            'nip.string' => __('validation.string', ['attribute' => 'NIP']),
            'nip.max' => __('validation.max', ['attribute' => 'NIP', 'max' => 20]),
            'email.required' => __('validation.required', ['attribute' => 'Email']),
            'email.email' => __('validation.string', ['attribute' => 'Email']),
            'hp.required' => __('validation.required', ['attribute' => 'No. HP']),
            'hp.string' => __('validation.string', ['attribute' => 'No. HP']),
            'hp.max' => __('validation.max', ['attribute' => 'No. HP', 'max' => 16]),
        ];
    }
}
