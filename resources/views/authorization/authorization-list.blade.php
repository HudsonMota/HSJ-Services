@extends('layouts.application')

@section('content')
    {{-- Mensagens de sucesso ou erro --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    @if (!empty($successMsg))
        <div class="alert alert-success">{{ $successMsg }}</div>
    @endif

    @php
        use Illuminate\Support\Str;
    @endphp

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

    <script>
        function closeModal() {
            locastyle.modal.close();
        }
    </script>

    <h1 class="ls-title-intro ls-ico-code">Chamados em Andamento</h1>

    <div class="col-md-12">

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
        @if ($scriptsauthorizeds->count() == 0)
            <div class="alert alert-danger" role="alert">
                <h2 class="blinking-text"><b>ATENÇÃO!</b></h2>
                Não há Chamados em Andamento para exibir!
            </div>
        @else
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="70">Cod</th>
                        <th width="300">Solicitante/Descrição</th>
                        <th width="300">Técnico</th>
                        <th width="200">Saída <br> Retorno</th>
                        <th width="200">Autorizador</th>
                        <th width="200">Status</th>
                        <th width="100">Ações</th>
                    </tr>
                </thead>
                <tbody id="tbodyright">
                    @foreach ($scriptsauthorizeds as $scriptauthorized)
                        <tr data-index="{{ $scriptauthorized->id }}">
                            <td>{{ $scriptauthorized->id }}</td>

                            <td>
                                @inject('users', '\App\User')
                                <?php
                                // Obtenha o 'vehiclerequest' com base no arr_requests_in_script do scriptauthorized atual
                                $vehiclerequest = $vehiclerequests->get($scriptauthorized->arr_requests_in_script);

                                // Verifique se o 'vehiclerequest' foi encontrado
                                if ($vehiclerequest) {
                                    // Acesse o solicitante
                                    $testeSolicitante = $vehiclerequest->solicitante;

                                    // Verifique se o solicitante está definido
                                    if ($testeSolicitante) {
                                        // Procure o usuário correspondente
                                        foreach ($users->getUsers() as $user) {
                                            if ($testeSolicitante == $user->id) {
                                                echo $user->name; // Mostra o nome do usuário
                                            }
                                        }
                                    } else {
                                        echo 'Solicitante não disponível'; // Mensagem se o solicitante não estiver definido
                                    }
                                } else {
                                    echo 'Não disponível'; // Mensagem se o vehiclerequest não for encontrado
                                }
                                ?>
                                <br>
                                @php
                                    // Acesse o 'admfin' baseado no 'vehiclerequest' encontrado
                                    $admfin = $vehiclerequest ? $vehiclerequest->admfin : null;
                                @endphp
                                {{ $admfin ? Str::limit($admfin, 100) : 'Não disponível' }} <br>
                            </td>

                            <td>
                                <?php
                                // Encontre o motorista pelo ID
                                $driver = $drivers->firstWhere('id', $scriptauthorized->driver);
                                echo $driver ? $driver->name_driver : 'Não disponível';
                                ?>
                            </td>


                            <td>
                                {{ date('d/m/Y', strtotime($scriptauthorized->authorized_departure_date)) }}<br>
                                {{ $scriptauthorized->authorized_departure_time }} <br>
                            </td>
                            <td>
                                {{ $scriptauthorized->authorizer }}
                            </td>
                            <td>
                                @if ($scriptauthorized->statusauthorization == 'ATRIBUIDO')
                                    <b><span style="color: green;">{{ $scriptauthorized->statusauthorization }}</span></b>
                                @elseif($scriptauthorized->statusauthorization == 'AGUARDANDO')
                                    <b><span style="color: red;">{{ $scriptauthorized->statusauthorization }}</span></b>
                                @elseif($scriptauthorized->statusauthorization == 'PENDENTE')
                                    <b><span style="color: orange;">{{ $scriptauthorized->statusauthorization }}</span></b>
                                @elseif($scriptauthorized->statusauthorization == 'REALIZADO')
                                    <b><span
                                            style="color: Mediumaquamarine;">{{ $scriptauthorized->statusauthorization }}</span></b>
                                @elseif($scriptauthorized->statusauthorization == 'NÃO REALIZADO')
                                    <b><span style="color: blue;">{{ $scriptauthorized->statusauthorization }}</span></b>
                                @endif
                            </td>
                            <td>
                                @if ($scriptauthorized->statusauthorization == 'REALIZADO')
                                    <div class="col-md-12">
                                        <a class="ls-ico-windows ls-btn" style="margin: 2px;"
                                            href="/autorizacao-pdf/{{ $scriptauthorized->id }}" target="_blank"></a>
                                    </div>
                                @elseif($scriptauthorized->statusauthorization == 'PENDENTE')
                                    <div class="col-md-6">
                                        <a onclick="endScript('{{ $scriptauthorized->id }}', '{{ $scriptauthorized->itinerary }}')"
                                            class="ls-ico-checkbox-checked ls-btn-primary" style="margin: 2px;"></a>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="ls-ico-windows ls-btn" style="margin: 2px;"
                                            href="/autorizacao-pdf/{{ $scriptauthorized->id }}" target="_blank"></a>
                                    </div>
                                @else
                                    </style>
                                    <div class="col-md-6">
                                        <a onclick="endScript('{{ $scriptauthorized->id }}', '{{ $scriptauthorized->itinerary }}')"
                                            class="ls-ico-checkbox-checked ls-btn-primary" style="margin: 2px;"></a>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="ls-ico-remove ls-btn-primary-danger" style="margin: 2px;"
                                            href="/authorization/delete/{{ $scriptauthorized->id }}"
                                            onclick="return confirm('Deseja retornar esta solicitação para AGUARDANDO?');"></a>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="ls-ico-windows ls-btn" style="margin: 2px;"
                                            href="/autorizacao-pdf/{{ $scriptauthorized->id }}" target="_blank"></a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif {{-- fim do if de Exibição de solicitação --}}

        <div style="margin-top: 5px;" class="ls-float-right">
            <a onclick="resetScript()" class="ls-btn-primary ls-ico-spinner">Mostrar todas as solicitações</a>
        </div>

        {{ $scriptsauthorizeds->links() }}
    </div>

    <script type="text/javascript">
        function endScript(id, itinerary) {
            $('#id').val(id);

            // Fazendo a requisição AJAX para buscar o status da autorização
            $.ajax({
                url: `/authorization/status/${id}`, // URL da rota que retorna o status
                type: 'GET',
                success: function(response) {
                    // Atualiza o status na modal
                    $('#statusDisplay').text(response.statusauthorization);

                    // Lógica para mostrar/ocultar Justificativa de Pendência
                    if (response.statusauthorization === 'ATRIBUIDO') {
                        $('#justificativaPendencia').show();
                    } else {
                        $('#justificativaPendencia').hide();
                    }

                    // Abrir a modal somente após o sucesso da requisição
                    locastyle.modal.open("#modalLarge");
                },
                error: function(error) {
                    console.error('Erro ao carregar dados:', error);
                    $('#statusDisplay').text('Erro ao carregar status: ' + (error.responseJSON ? error
                        .responseJSON.error : 'Erro desconhecido'));

                    // Mesmo em caso de erro, ainda abre a modal
                    locastyle.modal.open("#modalLarge");
                }
            });
        }
    </script>

    <div class="ls-modal" id="modalLarge">
        <div class="ls-modal-large">
            <div class="ls-modal-header">
                <button data-dismiss="modal">&times;</button>
                <h4 class="ls-modal-title">Finalizar Solicitação</h4>
            </div>
            <div class="ls-modal-body">
                <form method="POST" action="{{ url()->current() }}" class="ls-form row" id="add">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <fieldset id="field01">
                        <div class="col-md-12">
                            <div class="ls-box">
                                <div class="col-md-6">
                                    <b class="ls-label-text">Data de retorno</b>
                                    <input type="date" class="form-control" name="dataretorno"
                                        value="{{ date('Y-m-d') }}" required
                                        oninvalid="this.setCustomValidity('Informe a data de retorno do veículo!')"
                                        onchange="try{setCustomValidity('')}catch(e){}">
                                </div>
                                <div class="form-group col-md-6">
                                    <b class="ls-label-text">Hora de retorno</b>
                                    <input type="time" class="form-control" name="horaretorno"
                                        value="{{ date('H:i:s') }}" required
                                        oninvalid="this.setCustomValidity('Informe o horário de retorno do veículo!')"
                                        onchange="try{setCustomValidity('')}catch(e){}">
                                </div>

                                <div class="form-group col-md-12">
                                    <b class="ls-label-text">Acompanhamento</b>
                                    <textarea class="form-control" name="acompanhamento" rows="1"
                                        oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px';"
                                        oninvalid="this.setCustomValidity('Detalhe o Acompanhamento do Atendimento!')"
                                        onchange="try{setCustomValidity('')}catch(e){}"></textarea>
                                </div>

                                <div class="form-group col-md-12" id="justificativaPendencia" style="display: none;">
                                    <b class="ls-label-text">Justificativa de Pendência</b>
                                    <textarea class="form-control" name="reason_pending" rows="1"
                                        oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px';"
                                        oninvalid="this.setCustomValidity('Informe a justificativa para a pendência!')"
                                        onchange="try{setCustomValidity('')}catch(e){}"></textarea>
                                </div>

                                <!-- Contagem de Status -->
                                @php
                                    $contagem = [
                                        'PENDENTE' => 0,
                                        'ATRIBUIDO' => 0,
                                    ];

                                    foreach ($scriptsauthorizeds as $authorizerequest) {
                                        if (isset($contagem[$authorizerequest->statusauthorization])) {
                                            $contagem[$authorizerequest->statusauthorization]++;
                                        }
                                    }
                                @endphp

                            </div>
                        </div>
                        <div>
                            <button style="margin: 20px;" class="btn btn-danger ls-float-right" data-dismiss="modal"
                                type="button">Cancelar</button>
                            <button onclick="kmValidation()" style="margin: 20px;" type="submit"
                                class="ls-btn-primary">Salvar</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection
