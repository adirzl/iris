<?php

namespace Modules\PengawasanAudit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RkatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('rkat-audit'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [ 
            'ljk' => 'required|string',
            // 'description' => 'required|string',
            // 'image' => 'max:5000|image|mimes:jpeg,jpg,png',
            // 'file' => 'max:5000|file|mimes:pdf,docx,doc,xlsx',
            // 'status' => ['required', Rule::in(option_values('status_artikel')->pluck('key')->toArray())],
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
            'ljk.required' => __('validation.required', ['attribute' => 'LJK']),
            'ljk.string' => __('validation.string', ['attribute' => 'LJK']),
            // 'description.required' => __('validation.required', ['attribute' => 'Description']),
            // 'description.string' => __('validation.string', ['attribute' => 'Desription']),
            // 'image.string' => __('validation.string', ['attribute' => 'Image']),
            // 'file.string' => __('validation.string', ['attribute' => 'File']),
            // 'status.required' => __('validation.required', ['attribute' => 'Status']),
            // 'status.in' => __('validation.in', ['attribute' => 'Status']),
        ];
    }
}
