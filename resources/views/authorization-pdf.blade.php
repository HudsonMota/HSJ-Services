@extends('layouts.pdf')
@section('content')
    <table id="autorizacao">
        <tr>
            <th colspan="6">AUTORIZAÇÃO</th>
        </tr>
        <tr>
            <th>Autorização N°</th>
            <th>Status</th>
            <th>Solicitante</th>
            <th>Setor</th>
            <th>Motivo da Solicitação</th>
            <th>Data/Hora Solicitação</th>
        </tr>
        <tr>
            <td>{{ $authorization->id < 10 ? '0' . $authorization->id : $authorization->id }}</td>
            <td id="status" class="{{ strtolower($authorization->statusauthorization) }}">
                {{ $authorization->statusauthorization }}</td>
            <td>{{ $users->where('id', $solicitacao->solicitante)->first()->name }}</td>
            <td>{{ $sectors->where('cc', $solicitacao->setorsolicitante)->first()->sector }}</td>
            <td>{{ $solicitacao->admfin }}</td>
            <td>{{ Carbon\Carbon::parse($solicitacao->datasaida . ' ' . $solicitacao->horasaida)->format('d/m/Y H:i:s') }}
            </td>
        </tr>
    </table>

    <br>

    <table id="authorization">
        <tr>
            <th @if ($solicitacao->statussolicitacao === 'PENDENTE') colspan="5"
                    @elseif ($solicitacao->statussolicitacao === 'REALIZADO')
                        @if ($authorization->reason_pending != null) colspan="6"
                            @else
                                colspan="5" @endif
            @else colspan="3" @endif>
                INFORMAÇÕES DA AUTORIZAÇÃO</th>
        </tr>
        <tr>
            @if ($solicitacao->statussolicitacao === 'AGUARDANDO')
                <th>Técnico</th>
                <th>Data/Hora Autorização</th>
                <th>Autorizado por</th>
            @elseif ($solicitacao->statussolicitacao === 'RECUSADO')
                <th>Motivo do Cancelamento</th>
                <th>Data/Hora Cancelamento</th>
                <th>Recusado por</th>
            @elseif ($solicitacao->statussolicitacao === 'ATRIBUIDO')
                <th>Técnico</th>
                <th>Data/Hora Autorização</th>
                <th>Autorizado por</th>
            @elseif ($solicitacao->statussolicitacao === 'PENDENTE')
                <th>Técnico</th>
                <th>Data/Hora Autorização</th>
                <th>Autorizado por</th>
                <th>Motivo da Pendência</th>
                <th>Data/Hora</th>
            @elseif ($solicitacao->statussolicitacao === 'REALIZADO')
                <th>Técnico</th>
                <th>Data/Hora Autorização</th>
                <th>Autorizado por</th>
                @if ($authorization->reason_pending != null)
                    <th>Motivo da Pendência</th>
                @endif
                <th>Conclusão</th>
                <th>Data/Hora Conclusão</th>
            @endif

        </tr>
        <tr>
            {{-- AGUARDANDO --}}
            @if ($solicitacao->statussolicitacao === 'AGUARDANDO')
                <td colspan="4">Aguardando autorização</td>
                {{-- /AGUARDANDO --}}
                {{-- RECUSADO --}}
            @elseif ($solicitacao->statussolicitacao === 'RECUSADO')
                <td>{{ $solicitacao->motivo_recusa }}</td>
                <td>{{ Carbon\Carbon::parse($solicitacao->updated_at)->format('d/m/Y') }}
                    <br>
                    {{ Carbon\Carbon::parse($solicitacao->updated_at)->format('H:i:s') }}
                </td>
                <td>{{ $solicitacao->recuser }}</td>
                {{-- /RECUSADO --}}
                {{-- ATRIBUIDO --}}
            @elseif ($solicitacao->statussolicitacao === 'ATRIBUIDO')
                @if ($authorization)
                    <td>{{ $drivers->where('id', $authorization->driver)->first()->name_driver }}</td>
                    <td>{{ Carbon\Carbon::parse($authorization->authorized_departure_date)->format('d/m/Y') }}
                        <br>
                        {{ Carbon\Carbon::parse($authorization->authorized_departure_time)->format('H:i:s') }}
                    </td>
                    <td>{{ $authorization->authorizer }}</td>
                @else
                    <td colspan="3">Nenhuma autorização Encontrada</td>
                @endif
                {{-- /ATRIBUIDO --}}
                {{-- PENDENTE --}}
            @elseif ($solicitacao->statussolicitacao === 'PENDENTE')
                @if ($authorization)
                    <td>{{ $drivers->where('id', $authorization->driver)->first()->name_driver }}</td>
                    <td>{{ Carbon\Carbon::parse($authorization->authorized_departure_date)->format('d/m/Y') }}
                        <br>
                        {{ Carbon\Carbon::parse($authorization->authorized_departure_time)->format('H:i:s') }}
                    </td>
                    <td>{{ $authorization->authorizer }}</td>
                    <td>{{ $authorization->reason_pending }}</td>
                    <td>{{ Carbon\Carbon::parse($authorization->updated_at)->format('d/m/Y') }}
                        <br>
                        {{ Carbon\Carbon::parse($authorization->updated_at)->format('H:i:s') }}
                    </td>
                @else
                    <td colspan="5">Nenhuma autorização Encontrada</td>
                @endif
                {{-- /PENDENTE --}}
                {{-- REALIZADO --}}
            @elseif ($solicitacao->statussolicitacao === 'REALIZADO')
                @if ($authorization)
                    <td>{{ $drivers->where('id', $authorization->driver)->first()->name_driver }}</td>
                    <td>{{ Carbon\Carbon::parse($authorization->authorized_departure_date)->format('d/m/Y') }}
                        <br>
                        {{ Carbon\Carbon::parse($authorization->authorized_departure_time)->format('H:i:s') }}
                    </td>
                    <td>{{ $authorization->authorizer }}</td>
                    @if ($authorization->reason_pending != null)
                        <td>{{ $authorization->reason_pending }}</td>
                    @endif
                    <td>{{ $authorization->acompanhamento }}</td>
                    <td>{{ Carbon\Carbon::parse($authorization->updated_at)->format('d/m/Y') }}
                        <br>
                        {{ Carbon\Carbon::parse($authorization->updated_at)->format('H:i:s') }}
                    </td>
                @else
                    <td colspan="5">Nenhuma autorização Encontrada</td>
                @endif
                {{-- /REALIZADO --}}
            @endif
        </tr>
    </table>
    {{-- /DIV CONTAINER --}}


    </div>




    <style>
        /*  */
        #status {
            background-color: transparent;
        }

        #status.aguardando {
            color: #8E9089;
            font-weight: bold;

        }

        #status.recusado {
            color: brown;
            font-weight: bold;

        }

        #status.atribuido {
            color: #77C5D5;
            font-weight: bold;

        }

        #status.pendente {
            color: #FF6A13;
            font-weight: bold;

        }

        #status.realizado {
            color: #279989;
            font-weight: bold;

        }

        /*  */


        #autorizacao,
        #authorization {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
            box-sizing: border-box;
        }

        #autorizacao td,
        #autorizacao th,
        #authorization td,
        #authorization th {
            text-align: center;
            font-size: 14px;
            padding: 8px;
            border: 1px solid #000;
        }

        #autorizacao th,
        #authorization th {
            background-color: #777474;
            color: whitesmoke;
        }

        #autorizacao td,
        #authorization td {
            background-color: #f9f9f9;
            color: #333;
        }

        #footer {
            position: absolute;
            bottom: -15px;
            width: 100%;
            text-align: center;
        }
    </style>
    <footer id="footer">
        <hr style="height: 1px; border: none; border-top: 1px solid #ccc;">
        {{-- ___________________________________________________________________ --}}
        <p>HOSPITAL SÃO JOSÉ DE DOENÇAS INFECCIOSAS <br>
            Rua Nestor Barbosa, 315 Parquelandia, Fortaleza - CE</p>
    </footer>
@endsection
