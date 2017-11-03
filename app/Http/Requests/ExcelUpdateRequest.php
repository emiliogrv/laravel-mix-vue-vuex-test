<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExcelUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'albaran' => 'digits_between:1,10',
            'destinatario' => 'max:28',
            'direccion' => 'max:250',
            'poblacion' => 'nullable|max:10',
            'cp' => 'size:5',
            'provincia' => 'max:20',
            'telefono' => 'digits_between:1,10',
            'observaciones' => 'nullable|max:500',
            'fecha' => 'date_format:d/m/Y h:i',
        ];
    }

    public function messages()
    {
        $messages = [];

        $messages['albaran.required'] = ucfirst(trim(str_replace(':attribute', '', __('validation.required'))));
        $messages['albaran.digits_between'] = ucfirst(trim(str_replace([':attribute', ':min', ':max'], ['', 1, 10], __('validation.digits_between'))));

        $messages['destinatario.required'] = ucfirst(trim(str_replace(':attribute', '', __('validation.required'))));
        $messages['destinatario.max'] = ucfirst(trim(str_replace(':attribute', '', __('validation.max.string'))));

        $messages['direccion.required'] = ucfirst(trim(str_replace(':attribute', '', __('validation.required'))));
        $messages['direccion.size'] = ucfirst(trim(str_replace(':attribute', '', __('validation.size.string'))));

        $messages['poblacion.max'] = ucfirst(trim(str_replace(':attribute', '', __('validation.max.string'))));

        $messages['cp.required'] = ucfirst(trim(str_replace(':attribute', '', __('validation.required'))));
        $messages['cp.size'] = ucfirst(trim(str_replace(':attribute', '', __('validation.size.string'))));

        $messages['provincia.required'] = ucfirst(trim(str_replace(':attribute', '', __('validation.required'))));
        $messages['provincia.max'] = ucfirst(trim(str_replace(':attribute', '', __('validation.max.string'))));

        $messages['telefono.required'] = ucfirst(trim(str_replace(':attribute', '', __('validation.required'))));
        $messages['telefono.digits_between'] = ucfirst(trim(str_replace([':attribute', ':min', ':max'], ['', 1, 10], __('validation.digits_between'))));

        $messages['observaciones.max'] = ucfirst(trim(str_replace(':attribute', '', __('validation.max.string'))));

        $messages['fecha.required'] = ucfirst(trim(str_replace(':attribute', '', __('validation.required'))));
        $messages['fecha.date_format'] = ucfirst(trim(str_replace([':attribute', ':format'], ['', 'dd/MM/yyyy hh:mm'], __('validation.date_format'))));

        return $messages;
    }
}
