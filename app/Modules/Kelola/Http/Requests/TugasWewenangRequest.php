<?php

namespace Modules\Kelola\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TugasWewenangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('kelola-tugaswewenang'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => ['required', Rule::in(option_values('status')->pluck('key')->toArray())],
            'status_data' => ['required', Rule::in(option_values('status_data')->pluck('key')->toArray())],
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
            'title.required' => __('validation.required', ['attribute' => 'Title']),
            'title.string' => __('validation.string', ['attribute' => 'Title']),
            'description.required' => __('validation.required', ['attribute' => 'Description']),
            'description.string' => __('validation.string', ['attribute' => 'Desription']),
            'status.required' => __('validation.required', ['attribute' => 'Status']),
            'status.in' => __('validation.in', ['attribute' => 'Status']),
            'status_data.required' => __('validation.required', ['attribute' => 'Status_data']),
            'status_data.in' => __('validation.in', ['attribute' => 'Status_data']),
        ];
    }
}
