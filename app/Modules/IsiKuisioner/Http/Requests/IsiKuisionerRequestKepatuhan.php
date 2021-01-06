<?php

namespace Modules\IsiKuisioner\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IsiKuisionerRequestKepatuhan extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('isikuisioner-kepatuhan'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'periode' => 'required',
            'nama_perusahaan' => 'required',
            'modal_inti' => 'required',
            'user' => 'required|string',
            // 'jawaban[]' => 'required',
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
            'periode.required' => __('validation.required', ['attribute' => 'Periode']),
            'nama_perusahaan.required' => __('validation.required', ['attribute' => 'Nama Anak Perusahaan']),
            'modal_inti.required' => __('validation.required', ['attribute' => 'Modal Inti']),
            'user.required' => __('validation.required', ['attribute' => 'Nama Pengisi Kuisioner']),
            'user.string' => __('validation.string', ['attribute' => 'Nama Pengisi Kuisioner']),
            // 'jawaban[].required' => __('validation.required', ['attribute' => 'Tandai Salah Satu']),
        ];
    }
}
