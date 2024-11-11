@extends('layouts.application')
@section('content')
    @if (\Session::has('error'))
        <div class="ls-modal ls-opened" id="myAwesomeModal" role="dialog" aria-hidden="false" aria-labelledby="lsModal1"
            tabindex="-1">
            <div class="ls-modal-box">
                <div class="ls-modal-header">
                    <h2 class="ls-modal-title" id="lsModal1"><strong>Atenção</strong></h2>
                </div>
                <div class="ls-modal-body">
                    <h3 class="alert alert-danger">{!! \Session::get('error') !!}</h3>
                </div>
                <div class="ls-modal-footer">
                    <button onclick="closeModal()" style="margin-bottom: 20px;"
                        class="btn btn-danger ls-float-right">Fechar</button>
                </div>
            </div>
        </div>
    @endif

    <style>
        /* Animação para piscar */
        @keyframes blink {
            0% {
                opacity: 1;
            }

            /* Totalmente visível */
            50% {
                opacity: 0;
            }

            /* Invisível no meio da animação */
            100% {
                opacity: 1;
            }

            /* Totalmente visível no final */
        }

        /* Aplicando a animação ao elemento */
        .blinking-text {
            animation: blink 1.5s infinite;
            /* 1 segundo de duração, repetindo infinitamente */
            color: red;
            /* Cor de destaque */
        }
    </style>

    {{-- if de Exibição de solicitação --}}
    @if ($combinedData->count() == 0)
        <div class="alert alert-danger text-center" role="alert">
            <h2 class="blinking-text"><b>ATENÇÃO!</b></h2>
            <p style="font-size: 18px;">Não há Chamados em Andamento para exibir!</p>
        </div>
    @else
        <div class="col-md-12">
            <div class="table-container">
                <table class="table table-hover">
                    <thead>
                        <tr style="background-color: black; color: whitesmoke; font-size: 24px;">
                            <th class="th-solicitante" width="250">Solicitante/Localização</th>
                            <th class="th-descricao" width="650">Descrição</th>
                            <th class="th-data-hora" width="200">Data/Hora</th>
                            <th class="th-tecnico" width="200">Técnico</th>
                            <th class="th-status" width="150">Status</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyright">
                        @foreach ($combinedData as $data)
                            <tr data-index="{{ $data->id }}">
                                <td class="align-middle">
                                    <?php
                                    $solicitante = $data->solicitante ?? 'Não informado';
                                    $palavras = explode(' ', $solicitante);

                                    // Verifica se existem pelo menos 2 palavras
                                    $primeiras_palavras = isset($palavras[1]) ? $palavras[0] . ' ' . $palavras[1] : $palavras[0];

                                    echo $primeiras_palavras;
                                    ?>
                                    {{-- {{ $data->solicitante ?? 'Não informado' }} --}}
                                    <br>
                                    {{ $data->setor_nome ?? 'Não informado' }}
                                </td>
                                <td class="description-cell align-middle">
                                    <b
                                        style="color: #0186D4; font-size:26px;">{{ Str::limit($data->admfin ?? 'Não informado', 80) }}</b>
                                </td>
                                <td class="align-middle">
                                    {{ date('d/m/Y', strtotime($data->datahora)) }}<br>
                                    {{ date('h:i:s', strtotime($data->datahora)) }} <br>
                                </td>
                                <td class="align-middle">
                                    @if ($data->status_type == 'ATRIBUIDO')
                                        {{ $data->tecnico ?? 'Não atribuído' }}
                                    @else
                                        Não atribuído
                                    @endif
                                </td>
                                <td class="align-middle" style="background-color: aliceblue;">
                                    @if (isset($data->status_type))
                                        @if ($data->status_type == 'ATRIBUIDO')
                                            <b><span style="color: green;">{{ $data->status_type }}</span></b>
                                        @elseif($data->status_type == 'AGUARDANDO')
                                            <b><span style="color: red;">{{ $data->status_type }}</span></b>
                                        @elseif($data->status_type == 'PENDENTE')
                                            <!-- Novo Status -->
                                            <b><span style="color: orange;">{{ $data->status_type }}</span></b>
                                        @elseif($data->status_type == 'REALIZADO')
                                            <b><span style="color: Mediumaquamarine;">{{ $data->status_type }}</span></b>
                                        @elseif($data->status_type == 'NÃO REALIZADO')
                                            <b><span style="color: blue;">{{ $data->status_type }}</span></b>
                                        @endif
                                    @endif
                                </td>



                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- <div style="margin-top: 5px;" class="ls-float-right">
            <a onclick="resetScript()" class="ls-btn-primary ls-ico-spinner" style="font-size: 24px;">Mostrar todas as
                Solicitações</a>
        </div> --}}

            {{ $combinedData->links() }}
        </div>
    @endif

    <script type="text/javascript">
        function endScript(id) {
            $('#id').val(id);
            $('#status').val('REALIZADO');
            $('#endScriptForm').submit();
        }

        function resetScript() {
            window.location.href = '/dashboard';
        }

        // Atualiza a página a cada 10 segundos
        setInterval(function() {
            window.location.reload();
        }, 10000);

        // Reproduz o som se o número de solicitações mudar
        document.addEventListener('DOMContentLoaded', function() {
            const previousCount = localStorage.getItem('requestCount');
            const currentCount = document.getElementById('requestCount').textContent.trim();

            if (previousCount && previousCount !== currentCount) {
                const audio = new Audio('{{ asset('alert.mp3') }}');
                audio.play();
            }

            localStorage.setItem('requestCount', currentCount);
        });
    </script>

    <form id="endScriptForm" method="POST" action="{{ route('endScript') }}">
        @csrf
        <input type="hidden" id="id" name="id">
        <input type="hidden" id="status" name="status">
    </form>

    <style>
        body,
        h1,
        h2,
        h3,
        p,
        table,
        th,
        td,
        button,
        a {
            font-family: Arial, Helvetica, sans-serif;
        }

        h1,
        h2,
        h3 {
            font-size: 36px;
        }

        .ls-title-5 {
            font-size: 30px;
        }

        .table {
            font-size: 24px;
            width: 100%;
            table-layout: fixed;
            /* Força a tabela a ter uma largura fixa */
            margin: 0 auto;
            /* Centraliza a tabela */
        }

        .ls-btn-primary {
            font-size: 24px;
        }

        .th-solicitante,
        .th-descricao,
        .th-data-hora,
        .th-tecnico,
        .th-status {
            text-align: center;
        }

        .description-cell {
            text-align: center;
            vertical-align: middle;
            padding: 10px;
            /* Adiciona algum padding para melhorar a visualização */
        }

        .align-middle {
            vertical-align: middle;
            /* Alinha verticalmente o conteúdo das células */
        }

        .table-container {
            text-align: center;
            /* Centraliza o texto dentro do contêiner */
        }
    </style>
@endsection
