<?php

namespace Modules\Opsi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OpsiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('opsi'));
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
                    'required', 'string', Rule::unique('mst_option_group', 'name')->ignore($this->segment(2))
                ] : 'required|string|unique:mst_option_group,name'
            ),
            'keys.*' => 'required|string',
            'values.*' => 'required|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        $messages = [
            'name.required' => __('validation.required', ['attribute' => 'Nama Opsi']),
            'name.string' => __('validation.string', ['attribute' => 'Nama Opsi']),
            'name.unique' => __('validation.unique', ['attribute' => 'Nama Opsi']),
        ];

        foreach ($this->get('keys') as $index => $value) {
            $i = $index + 1;
            $messages['keys.' . $index . '.required'] = __('validation.required', ['attribute' => 'Key Opsi ke-' . $i]);
            $messages['keys.' . $index . '.string'] = __('validation.string', ['attribute' => 'Key Opsi ke-' . $i]);
        }

        foreach ($this->get('values') as $index => $value) {
            $i = $index + 1;
            $messages['values.' . $index . '.required'] = __('validation.required', ['attribute' => 'Value Opsi ke-' . $i]);
            $messages['values.' . $index . '.string'] = __('validation.string', ['attribute' => 'Value Opsi ke-' . $i]);
        }

        return $messages;
    }
}
