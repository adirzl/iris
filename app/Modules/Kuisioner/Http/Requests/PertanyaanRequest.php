<?php

namespace Modules\Kuisioner\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PertanyaanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('kuisioner-pertanyaan'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'title' => 'required|string',
            'description' => 'required|string',
            // 'status' => ['required', Rule::in(option_values('status_kuisioner')->pluck('key')->toArray())],
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
            // 'title.required' => __('validation.required', ['attribute' => 'Title']),
            // 'title.string' => __('validation.string', ['attribute' => 'Title']),
            'description.required' => __('validation.required', ['attribute' => 'Description']),
            'description.string' => __('validation.string', ['attribute' => 'Desription']),
            // 'status.required' => __('validation.required', ['attribute' => 'Status']),
            // 'status.in' => __('validation.in', ['attribute' => 'Status']),
        ];
    }
}
