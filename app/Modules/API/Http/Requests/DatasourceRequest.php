<?php

namespace Modules\API\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DatasourceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() && auth()->user()->hasAnyRole(permitRolesByUri('datasource'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama' => 'required|string',
            'environment' => ['required', Rule::in(option_values('environment')->pluck('key')->toArray())],
            'dialect' => ['required', Rule::in(option_values('dialect')->pluck('key')->toArray())],
            'key.*' => 'required',
            'value.*' => 'required',
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
            'nama.required' => __('validation.required', ['attribute' => 'Nama Datasource']),
            'nama.string' => __('validation.string', ['attribute' => 'Nama Datasource']),
            'environment.required' => __('validation.required', ['attribute' => 'Environment']),
            'environment.in' => __('validation.in', ['attribute' => 'Environment']),
            'dialect.required' => __('validation.required', ['attribute' => 'Dialect']),
            'dialect.in' => __('validation.in', ['attribute' => 'Dialect']),
        ];

        foreach ($this->get('key') as $index => $value) {
            $i = $index + 1;
            $messages['key.' . $index . '.required'] = __('validation.required', ['attribute' => 'Key Property ke-' . $i]);
        }

        foreach ($this->get('value') as $index => $value) {
            $i = $index + 1;
            $messages['value.' . $index . '.required'] = __('validation.required', ['attribute' => 'Value Property ke-' . $i]);
        }

        return $messages;
    }
}
