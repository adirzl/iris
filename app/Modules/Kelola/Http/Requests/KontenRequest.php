<?php

namespace Modules\Kelola\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KontenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('kelola-konten'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'title' => 'string',
            // 'description' => 'string',
            // 'image' => 'max:5000|image|mimes:jpeg,jpg,png',
            // 'status' => ['required', Rule::in(option_values('status_profil')->pluck('key')->toArray())],
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
            // 'title.string' => __('validation.string', ['attribute' => 'Title']),
            // 'description.string' => __('validation.string', ['attribute' => 'Desription']),
            // 'image.string' => __('validation.string', ['attribute' => 'Image']),
            // 'status.in' => __('validation.in', ['attribute' => 'Status']),
        ];
    }
}
