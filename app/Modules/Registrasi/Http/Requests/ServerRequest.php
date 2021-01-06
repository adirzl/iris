<?php

namespace Modules\Registrasi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('registrasi-server'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ip_address' => 'required|ip',
            'nama' => 'required|string',
            'environment' => ['required', Rule::in(option_values('environment')->pluck('key')->toArray())],
            'blacklist' => ['required', Rule::in(option_values('bool_decision')->pluck('key')->toArray())],
            'koneksi' => ['required', Rule::in(option_values('environment')->pluck('key')->toArray())],
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
            'ip_address.required' => __('validation.required', ['attribute' => 'IP Address Aplikasi']),
            'ip_address.ip' => __('validation.integer', ['attribute' => 'IP Address Aplikasi']),
            'nama.required' => __('validation.required', ['attribute' => 'Nama Aplikasi']),
            'nama.string' => __('validation.string', ['attribute' => 'Nama Aplikasi']),
            'environment.required' => __('validation.required', ['attribute' => 'Environment Aplikasi']),
            'environment.in' => __('validation.in', ['attribute' => 'Environment Aplikasi']),
            'blacklist.required' => __('validation.required', ['attribute' => 'Blacklist']),
            'blacklist.in' => __('validation.in', ['attribute' => 'Blacklist']),
            'koneksi.required' => __('validation.required', ['attribute' => 'Koneksi']),
            'koneksi.in' => __('validation.in', ['attribute' => 'Koneksi']),
        ];
    }
}
