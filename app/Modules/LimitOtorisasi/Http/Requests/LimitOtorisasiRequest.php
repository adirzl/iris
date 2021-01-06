<?php

namespace Modules\LimitOtorisasi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LimitOtorisasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('limit-otorisasi'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kode' => 'required|string',
            'jabatan.*' => ['required', Rule::in((\Modules\HCS\Entities\Jabatan::all())->pluck('kode')->toArray())],
            'limit_kredit' => ['required', 'regex' => 'regex:/^[\d.,]+$/'],
            'limit_debit' => ['required', 'regex' => 'regex:/^[\d.,]+$/'],
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
            'kode.required' => __('validation.required', ['attribute' => 'Kode Grup Limit']),
            'kode.string' => __('validation.string', ['attribute' => 'Kode Grup Limit']),
            'limit_kredit.required' => __('validation.required', ['attribute' => 'Kredit']),
            'limit_kredit.regex' => __('validation.regex', ['attribute' => 'Limit Kredit']),
            'limit_debit.required' => __('validation.required', ['attribute' => 'Limit Debit']),
            'limit_debit.regex' => __('validation.regex', ['attribute' => 'Limit Debit']),
        ];

        foreach ($this->get('jabatan') as $index => $value) {
            $i = $index + 1;
            $messages['jabatan.' . $index . '.required'] = __('validation.required', ['attribute' => 'Jabatan ke-' . $i]);
            $messages['jabatan.' . $index . '.in'] = __('validation.in', ['attribute' => 'Jabatan ke-' . $i]);
        }

        return $messages;
    }
}
