<?php

namespace Modules\Dokumen\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FileArchiveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('dokumen-filetype'));
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'unitkerja_kode' => 'required',
            'version' => 'required',
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
            'unitkerja_kode.required' => __('validation.required', ['attribute' => 'Unit Kerja']),
            'version.required' => __('validation.version', ['attribute' => 'Versi'])
            
        ];
    }
}
