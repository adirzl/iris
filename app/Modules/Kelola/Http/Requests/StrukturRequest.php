<?php

namespace Modules\Kelola\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StrukturRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('kelola-struktur'));
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
            'image' => 'required|max:5000|image|mimes:jpeg,jpg,png',
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
            'image.required' => __('validation.required', ['attribute' => 'Image']),
            'image.string' => __('validation.string', ['attribute' => 'Image']),
        ];
    }
}
