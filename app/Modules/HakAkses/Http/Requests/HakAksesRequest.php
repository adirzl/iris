<?php

namespace Modules\HakAkses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HakAksesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('hak-akses'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => (
                $this->method() === 'PUT' ? [
                    'required', 'string', Rule::unique('mst_role', 'name')->ignore($this->segment(2))
                ] : 'required|string|unique:mst_role,name'
            ),
            'modules' => 'required|min:1',
            'permissions' => 'required|min:1',
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
            'name.required' => __('validation.required', ['attribute' => 'Hak Akses']),
            'name.string' => __('validation.string', ['attribute' => 'Hak Akses']),
            'name.unique' => __('validation.unique', ['attribute' => 'Hak Akses']),
            'modules.required' => __('validation.required', ['attribute' => 'Hak Akses Menu']),
            'modules.min' => __('validation.min', ['attribute' => 'Hak Akses Menu', 'min' => 1]),
            'permissions.required' => __('validation.required', ['attribute' => 'Hak Akses Pengelolaan']),
            'permissions.min' => __('validation.min', ['attribute' => 'Hak Akses Pengelolaan', 'min' => 1]),
        ];
    }
}
