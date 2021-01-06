<?php

namespace Modules\KinerjaKeuangan\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RealisasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('realisasi-rbb'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'kategori_keuangan' => 'required',
            'file' => 'required_if:kategori_keuangan,==,[1,2,3,5,7]|file|mimes:txt|max:5000',
            'kredit_diberikan' => 'required_if:kategori_keuangan,==,4|nullable',
            'rupa_aktiva' => 'required_if:kategori_keuangan,==,4|nullable',
            'modal_pelengkap' => 'required_if:kategori_keuangan,==,4|nullable',
            'godwill' => 'required_if:kategori_keuangan,==,4|nullable',
            'bobot_car' => 'required_if:kategori_keuangan,==,11|nullable',
            'bobot_kap' => 'required_if:kategori_keuangan,==,11|nullable',
            'bobot_ppap' => 'required_if:kategori_keuangan,==,11|nullable',
            'bobot_cr' => 'required_if:kategori_keuangan,==,11|nullable',
            'bobot_ldr' => 'required_if:kategori_keuangan,==,11|nullable',
            'bobot_roa' => 'required_if:kategori_keuangan,==,11|nullable',
            'bobot_bopo' => 'required_if:kategori_keuangan,==,11|nullable',
            'manajemen_umum' => 'required_if:kategori_keuangan,==,11|nullable',
            'manajemen_resiko' => 'required_if:kategori_keuangan,==,11|nullable',
            'nsfr' => 'required_if:kategori_keuangan,==,12|nullable',
            'lcr' => 'required_if:kategori_keuangan,==,13|nullable',
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
            'kategori_keuangan.required' => __('validation.required', ['attribute' => 'Kategori Keuangan']),
            'kategori_keuangan.string' => __('validation.string', ['attribute' => 'Kategori Keuangan']),
            'file.string' => __('validation.string', ['attribute' => 'File']),
            // 'nsfr.required' => __('validation.required', ['attribute' => 'Wajib Isi']),
            // 'lcr.required' => __('validation.required', ['attribute' => 'Wajib Isi']),
        ];
    }
}
