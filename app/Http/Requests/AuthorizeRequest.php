<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorizeRequest extends FormRequest
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
            'namesolicitante'           => 'sometimes|required',
            'nameramal'                 => 'sometimes|required|min:4',
            'nameroteiro'               => 'sometimes|required',
            'namefinalidade'            => 'sometimes|required',
            'datahorasaida'             => 'sometimes|required',
            'datahoraretorno'           => 'sometimes|required|date|after_or_equal:datahorasaida',
            'nameusuario'               => 'sometimes|required',
            'name_driver'               => 'required',
            'veiculo'                   => 'required',
            'datasaidaautorizada'       => 'required',
            'horasaidaautorizada'       => 'required',
            'horaretornoautorizada'     => 'required|date|after_or_equal:datasaidaautorizada',
            'horaretornoautorizada'     => 'required|date_format:H:i|after_or_equal:horaretornoautorizada',
            // 'kminicial'                 => 'required',
            // 'kmfinal'                   => 'required|min:kminicial',
            'statussolicitacao'         => 'required',
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
            'namesolicitante.required'                  => 'Por favor informe o setor solicitante.',
            'nameramal.required'                        => 'Por favor informe o ramal do seu setor.',
            'nameramal.min'                             => 'O ramal deve conter no mínimo 4 dígitos',
            'nameroteiro.required'                      => 'Por favor informe o roteiro.',
            'namefinalidade.required'                   => 'Por favor informe a finalidade desta solicitação.',
            'datahorasaida.required'                    => 'Por favor informe a data e hora de saída.',
            'datahoraretorno.required'                  => 'Por favor informe a data e hora de retorno.',
            'datahoraretorno.after_or_equal'            => 'Desculpe! Não possuímos um DeLorean? A data e hora de retorno não podem ser anterior à data e hora de saída.',
            'nameusuario.required'                      => 'Por favor informe o mome do solicitante ou paciente.',

            'name_driver.required'                      => 'Por favor informe o nome do motorista.',
            'veiculo.required'                          => 'Por favor selecione o veiculo',
            'datasaidaautorizada.required'              => 'Por favor informe a data de saída.',
            'horasaidaautorizada.required'              => 'Por favor informe a hora de saída.',
            'dataretornoautorizada.required'            => 'Por favor informe a data de retorno.',
            'horaretornoautorizada.required'            => 'Por favor informe hora de retorno.',
            'dataretornoautorizada.after_or_equal'      => 'Dr. Emmett Brown, é você? A data e hora de retorno não podem ser menor que a data e hora de saída.',
            // 'kminicial'                                 => 'Por favor informe a quilometragem inicial',
            // 'kmfinal'                                   => 'Por favor informe a quilometragem final',
            // 'kmfinal.min'                               => 'A Quilometragem final precisa ser maior ou igual a inicial.',
            'statussolicitacao.required'                => 'Por favor informe o status da solicitação.',
        ];
    }
}
