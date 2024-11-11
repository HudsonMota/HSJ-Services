<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitacaoRequest extends FormRequest
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
            'namesolicitante'   => 'required',
            'nameramal'         => 'required|min:4',
            'origem'            => 'required',
            'destino'           => 'required',
            'namefinalidade'    => 'required',
            'datasaida'         => 'required',
            'horasaida'         => 'required',
            'dataretorno'       => 'required|date|after_or_equal:datasaida',
            'nameusuario'       => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'namesolicitante.required'   => 'Por favor informe o setor solicitante.',
            'nameramal.required'         => 'Por favor informe o ramal do seu setor.',
            'nameramal.min'              => 'O ramal deve conter no mínimo 4 dígitos',
            'origem.required'            => 'Por favor informe a origem da solicitação.',
            'destino.required'           => 'Por favor informe o destino da solicitação.',
            'namefinalidade.required'    => 'Por favor informe a finalidade desta solicitação.',
            'datasaida.required'         => 'Por favor informe a data de saída.',
            'horasaida.required'         => 'Por favor informe a hora de saída.',
            'dataretorno.required'       => 'Insira uma data de retorno mesmo que não necessite retornar.',
            'horaretorno.required'       => 'Insira uma hora de retorno mesmo que não necessite retornar.',
            'dataretorno.after_or_equal' => 'Desculpe! Não possuímos um DeLorean? A data retorno não podem ser anterior à data e hora de saída.',
            'nameusuario.required'       => 'Por favor informe o mome do solicitante ou paciente.',
        ];
    }
}
