<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExcelStoreRequest extends FormRequest
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
            'data' => 'required|array|max:200',
            'data.*' => 'required|array',
            'data.*.albaran' => 'required|digits_between:1,10',
            'data.*.destinatario' => 'required|max:28',
            'data.*.direccion' => 'required|max:250',
            'data.*.poblacion' => 'nullable|max:10',
            'data.*.cp' => 'required|size:5',
            'data.*.provincia' => 'required|max:20',
            'data.*.telefono' => 'required|digits_between:1,10',
            'data.*.observaciones' => 'nullable|max:500',
            'data.*.fecha' => 'required|date_format:d/m/Y h:i',
        ];
    }

    public function messages()
    {
        $messages = [];

        if ($this->has('data')) {
            foreach ($this->get('data') as $key => $val) {

                $messages['data.' . $key . '.albaran.required'] = ucfirst(trim(str_replace(':attribute', '', __('validation.required'))));
                $messages['data.' . $key . '.albaran.digits_between'] = ucfirst(trim(str_replace([':attribute', ':min', ':max'], ['', 1, 10], __('validation.digits_between'))));

                $messages['data.' . $key . '.destinatario.required'] = ucfirst(trim(str_replace(':attribute', '', __('validation.required'))));
                $messages['data.' . $key . '.destinatario.max'] = ucfirst(trim(str_replace(':attribute', '', __('validation.max.string'))));

                $messages['data.' . $key . '.direccion.required'] = ucfirst(trim(str_replace(':attribute', '', __('validation.required'))));
                $messages['data.' . $key . '.direccion.size'] = ucfirst(trim(str_replace(':attribute', '', __('validation.size.string'))));

                $messages['data.' . $key . '.poblacion.max'] = ucfirst(trim(str_replace(':attribute', '', __('validation.max.string'))));

                $messages['data.' . $key . '.cp.required'] = ucfirst(trim(str_replace(':attribute', '', __('validation.required'))));
                $messages['data.' . $key . '.cp.size'] = ucfirst(trim(str_replace(':attribute', '', __('validation.size.string'))));

                $messages['data.' . $key . '.provincia.required'] = ucfirst(trim(str_replace(':attribute', '', __('validation.required'))));
                $messages['data.' . $key . '.provincia.max'] = ucfirst(trim(str_replace(':attribute', '', __('validation.max.string'))));

                $messages['data.' . $key . '.telefono.required'] = ucfirst(trim(str_replace(':attribute', '', __('validation.required'))));
                $messages['data.' . $key . '.telefono.digits_between'] = ucfirst(trim(str_replace([':attribute', ':min', ':max'], ['', 1, 10], __('validation.digits_between'))));

                $messages['data.' . $key . '.observaciones.max'] = ucfirst(trim(str_replace(':attribute', '', __('validation.max.string'))));

                $messages['data.' . $key . '.fecha.required'] = ucfirst(trim(str_replace(':attribute', '', __('validation.required'))));
                $messages['data.' . $key . '.fecha.date_format'] = ucfirst(trim(str_replace([':attribute', ':format'], ['', 'dd/MM/yyyy hh:mm'], __('validation.date_format'))));
            }
        }

        return $messages;
    }
}
