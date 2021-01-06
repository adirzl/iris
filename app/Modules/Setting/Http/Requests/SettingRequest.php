<?php

namespace Modules\Setting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('setting'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'display_name' => 'required|string',
            'logo' => 'max:500|image|mimes:jpeg,jpg,png',
            'display_per_page' => 'required|integer',
            'copyright' => 'required|string',
            'auto_logout' => 'required|integer',
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
            'name.required' => __('validation.required', ['attribute' => 'Name']),
            'name.string' => __('validation.string', ['attribute' => 'Name']),
            'display_name.required' => __('validation.required', ['attribute' => 'Display Name']),
            'display_name.string' => __('validation.string', ['attribute' => 'Display Name']),
            'logo.max' => __('validation.max', ['attribute' => 'Logo', 'max' => '500kb']),
            'logo.image' => __('validation.image', ['attribute' => 'Logo']),
            'logo.mimes' => __('validation.mimes', ['attribute' => 'Logo', 'values' => '.jpg, .jpeg atau .png']),
            'display_per_page.required' => __('validation.required', ['attribute' => 'Display Per Page']),
            'display_per_page.integer' => __('validation.integer', ['attribute' => 'Display Per Page']),
            'copyright.required' => __('validation.required', ['attribute' => 'Copyright']),
            'copyright.string' => __('validation.string', ['attribute' => 'Copyright']),
            'auto_logout.required' => __('validation.required', ['attribute' => 'Auto Logout']),
            'auto_logout.integer' => __('validation.integer', ['attribute' => 'Auto Logout']),
        ];
    }
}
