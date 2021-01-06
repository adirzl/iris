<?php

namespace Modules\Registrasi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFungsiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('registrasi-aplikasi-fungsi'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reg_aplikasi_id' => ['required', Rule::in((\Modules\Registrasi\Entities\Aplikasi::select('id')->get())->pluck('id')->toArray())],
            'nama' => 'required|string',
            'menu' => 'nullable|string',
            'akses1' => 'required',
            'akses2' => 'nullable|string',
            'limit_debit' => ['required', 'regex' => 'regex:/^[\d.,]+$/'],
            'limit_kredit' => ['required', 'regex' => 'regex:/^[\d.,]+$/'],
            'spv' => ['required', Rule::in(option_values('char_decision')->pluck('key')->toArray())],
            'status' => ['required', Rule::in(option_values('status')->pluck('key')->toArray())],
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
            'reg_aplikasi_id.required' => __('validation.required', ['attribute' => 'Aplikasi']),
            'reg_aplikasi_id.in' => __('validation.in', ['attribute' => 'Aplikasi']),
            'nama.required' => __('validation.required', ['attribute' => 'Nama Fungsi']),
            'nama.string' => __('validation.string', ['attribute' => 'Nama Fungsi']),
            'menu.string' => __('validation.string', ['attribute' => 'Menu Fungsi']),
            'akses1.required' => __('validation.required', ['attribute' => 'Fungsi Akses 1']),
            'akses1.in' => __('validation.in', ['attribute' => 'Fungsi Akses 1']),
            'akses2.string' => __('validation.string', ['attribute' => 'Fungsi Akses 2']),
            'limit_debit.required' => __('validation.required', ['attribute' => 'Limit Debit']),
            'limit_debit.regex' => __('validation.regex', ['attribute' => 'Limit Debit']),
            'limit_kredit.required' => __('validation.required', ['attribute' => 'Limit Kredit']),
            'limit_kredit.regex' => __('validation.regex', ['attribute' => 'Limit Kredit']),
            'spv.required' => __('validation.required', ['attribute' => 'SPV']),
            'spv.in' => __('validation.in', ['attribute' => 'SPV']),
            'status.required' => __('validation.required', ['attribute' => 'Status']),
            'status.in' => __('validation.in', ['attribute' => 'Status']),
        ];
    }
}
