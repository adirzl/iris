<?php

namespace Modules\Registrasi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFungsiRequest extends FormRequest
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
            'nama.*' => 'required|string',
            'menu.*' => 'nullable|string',
            'akses1.*' => 'required',
            'akses2.*' => 'nullable|string',
            'limit_debit.*' => ['required', 'regex' => 'regex:/^[\d.,]+$/'],
            'limit_kredit.*' => ['required', 'regex' => 'regex:/^[\d.,]+$/'],
            'spv.*' => ['required', Rule::in(option_values('char_decision')->pluck('key')->toArray())],
            'status.*' => ['required', Rule::in(option_values('status')->pluck('key')->toArray())],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        $messages = [
            'reg_aplikasi_id.required' => __('validation.required', ['attribute' => 'Aplikasi']),
            'reg_aplikasi_id.in' => __('validation.in', ['attribute' => 'Aplikasi']),
        ];

        foreach ($this->get('nama') as $index => $value) {
            $i = $index + 1;
            $messages['nama.' . $index . '.required'] = __('validation.required', ['attribute' => 'Nama Fungsi ke-' . $i]);
            $messages['nama.' . $index . '.string'] = __('validation.string', ['attribute' => 'Nama Fungsi ke-' . $i]);
        }

        foreach ($this->get('menu') as $index => $value) {
            $i = $index + 1;
            $messages['menu.' . $index . '.string'] = __('validation.string', ['attribute' => 'Menu Fungsi ke-' . $i]);
        }

        foreach ($this->get('akses1') as $index => $value) {
            $i = $index + 1;
            $messages['akses1.' . $index . '.required'] = __('validation.required', ['attribute' => 'Fungsi Akses 1 ke-' . $i]);
            $messages['akses1.' . $index . '.in'] = __('validation.in', ['attribute' => 'Fungsi Akses 1 ke-' . $i]);
        }

        foreach ($this->get('akses2') as $index => $value) {
            $i = $index + 1;
            $messages['akses2.' . $index . '.string'] = __('validation.string', ['attribute' => 'Fungsi Akses 2 ke-' . $i]);
        }

        foreach ($this->get('limit_debit') as $index => $value) {
            $i = $index + 1;
            $messages['limit_debit.' . $index . '.required'] = __('validation.required', ['attribute' => 'Limit Debit ke-' . $i]);
            $messages['limit_debit.' . $index . '.regex'] = __('validation.regex', ['attribute' => 'Limit Debit ke-' . $i]);
        }

        foreach ($this->get('limit_kredit') as $index => $value) {
            $i = $index + 1;
            $messages['limit_kredit.' . $index . '.required'] = __('validation.required', ['attribute' => 'Limit Kredit ke-' . $i]);
            $messages['limit_kredit.' . $index . '.regex'] = __('validation.regex', ['attribute' => 'Limit Kredit ke-' . $i]);
        }

        foreach ($this->get('spv') as $index => $value) {
            $i = $index + 1;
            $messages['spv.' . $index . '.required'] = __('validation.required', ['attribute' => 'SPV ke-' . $i]);
            $messages['spv.' . $index . '.in'] = __('validation.in', ['attribute' => 'SPV ke-' . $i]);
        }

        foreach ($this->get('status') as $index => $value) {
            $i = $index + 1;
            $messages['status.' . $index . '.required'] = __('validation.required', ['attribute' => 'Status ke-' . $i]);
            $messages['status.' . $index . '.in'] = __('validation.in', ['attribute' => 'Status ke-' . $i]);
        }

        return $messages;
    }
}
