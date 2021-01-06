<?php

namespace Modules\RuleHakAkses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RuleHakAksesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('rule-hak-akses'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'grade.*' => ['required_if:level,3', Rule::in((\Modules\HCS\Entities\Grade::all())->pluck('kode')->toArray())],
            'grade.*' => 'required_if:level,3',
            'pegawai_ti' => 'required|boolean',
            'as_admin_spv' => 'required|boolean',
            'as_admin' => 'required|boolean',
            'primary_level' => ['required', Rule::in(option_values('level_hakakses')->pluck('key')->toArray())],
            'secondary_level' => ['nullable', Rule::in(option_values('level_hakakses')->pluck('key')->toArray())],
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
            'pegawai_ti.required' => __('validation.required', ['attribute' => 'Pegawai TI']),
            'pegawai_ti.boolean' => __('validation.boolean', ['attribute' => 'Pegawai TI']),
            'as_admin_spv.required' => __('validation.required', ['attribute' => 'Ditunjuk sebagai Admin SPV TI']),
            'as_admin_spv.boolean' => __('validation.boolean', ['attribute' => 'Ditunjuk sebagai Admin SPV TI']),
            'as_admin.required' => __('validation.required', ['attribute' => 'Ditunjuk sebagai Admin TI']),
            'as_admin.boolean' => __('validation.boolean', ['attribute' => 'Ditunjuk sebagai Admin TI']),
            'primary_level.required' => __('validation.required', ['attribute' => 'Level Hak Akses Primary']),
            'primary_level.in' => __('validation.in', ['attribute' => 'Level Hak Akses Primary']),
            'secondary_level.in' => __('validation.in', ['attribute' => 'Level Hak Akses Secondary']),
        ];

        foreach ($this->get('grade') as $index => $value) {
            $i = $index + 1;
            $messages['grade.' . $index . '.required_if'] = __('validation.required_if', ['attribute' => 'Grade ke-' . $i, 'other' => 'Level Hak Akses', 'value' => '3']);
            $messages['grade.' . $index . '.in'] = __('validation.in', ['attribute' => 'Grade ke-' . $i]);
        }

        return $messages;
    }
}
