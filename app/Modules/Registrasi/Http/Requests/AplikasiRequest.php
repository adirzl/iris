<?php

namespace Modules\Registrasi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AplikasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('registrasi-aplikasi'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'idaplikasi' => 'required|integer',
            'nama' => 'required|string',
            'keterangan' => 'string',
            'alamat' => 'string',
            'ada_limit' => ['required', Rule::in(option_values('char_decision')->pluck('key')->toArray())],
            'akses' => ['required', Rule::in(option_values('akses_aplikasi')->pluck('key')->toArray())],
            'muncul_di_uim' => ['required', Rule::in(option_values('char_decision')->pluck('key')->toArray())],
            'otentikasi_user' => ['required', Rule::in(option_values('otentikasi_user')->pluck('key')->toArray())],
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
            'idaplikasi.required' => __('validation.required', ['attribute' => 'ID Aplikasi']),
            'idaplikasi.integer' => __('validation.integer', ['attribute' => 'ID Aplikasi']),
            'nama.required' => __('validation.required', ['attribute' => 'Nama Aplikasi']),
            'nama.string' => __('validation.string', ['attribute' => 'Nama Aplikasi']),
            'keterangan.string' => __('validation.string', ['attribute' => 'Keterangan Aplikasi']),
            'alamat.string' => __('validation.string', ['attribute' => 'Alamat Aplikasi']),
            'ada_limit.required' => __('validation.required', ['attribute' => 'Ada Limit Aplikasi']),
            'ada_limit.in' => __('validation.in', ['attribute' => 'Ada Limit Aplikasi']),
            'akses.required' => __('validation.required', ['attribute' => 'Akses Aplikasi']),
            'akses.in' => __('validation.in', ['attribute' => 'Akses Aplikasi']),
            'muncul_di_uim.required' => __('validation.required', ['attribute' => 'Muncul di UIM']),
            'muncul_di_uim.in' => __('validation.in', ['attribute' => 'Muncul di UIM']),
            'otentikasi_user.required' => __('validation.required', ['attribute' => 'Otentikasi User']),
            'otentikasi_user.in' => __('validation.in', ['attribute' => 'Otentikasi User']),
        ];
    }
}
