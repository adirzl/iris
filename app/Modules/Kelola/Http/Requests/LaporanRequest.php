<?php

namespace Modules\Kelola\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LaporanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('kelola-laporan'));
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
            'company_name' => 'required',
            'title' => 'required|string',
            'description' => 'required|string',
            'file' => 'max:5000|file|mimes:pdf,docx,doc,xlsx',
            'status' => ['required', Rule::in(option_values('status_laporan')->pluck('key')->toArray())],
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
            'periode.required' => __('validation.required', ['attribute' => 'Periode Bulan']),
            'company_name.required' => __('validation.required', ['attribute' => 'Nama Perusahaan']),
            'title.required' => __('validation.required', ['attribute' => 'Title']),
            'title.string' => __('validation.string', ['attribute' => 'Title']),
            'description.required' => __('validation.required', ['attribute' => 'Description']),
            'description.string' => __('validation.string', ['attribute' => 'Desription']),
            // 'image.string' => __('validation.string', ['attribute' => 'Image']),
            'file.string' => __('validation.string', ['attribute' => 'File']),
            'status.required' => __('validation.required', ['attribute' => 'Status']),
            'status.in' => __('validation.in', ['attribute' => 'Status']),
        ];
    }
}
