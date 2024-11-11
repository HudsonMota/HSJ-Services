@extends('layouts.application')

@section('content')
    <h1 class="ls-title-intro ls-ico-code">Editar Atendimento</h1>

    <form method="POST" action="{{ route('solicitacao.postEdit', $vehiclerequest->id) }}" class="ls-form row" id="add">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <fieldset id="field01">
            <div class="ls-box">
                <div class="col-md-12">
                    <div class="ls-box">
                        <div class="col-md-6">
                            <h5 class="ls-title-5">Solicitante / Setor</h5>
                            <hr>

                            <!-- Nome do Solicitante -->
                            <div class="form-group col-md-12">
                                <b class="ls-label-text">Nome do Solicitante:</b>
                                <div id="inputs[0]">
                                    @inject('users', '\App\User')
                                    @foreach ($users->getUsers() as $user)
                                        @if ($user->id == $vehiclerequest->solicitante)
                                            <input type="text" name="solicitante"
                                                class="ls-select form-control col-md-12" value="{{ $user->name }}"
                                                readonly>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Setor Solicitante -->
                            <div class="form-group col-md-12">
                                <b class="ls-label-text">Localização:</b>
                                <div class="ls-custom-select">
                                    <select id="setorsolicitante" name="setorsolicitante" class="ls-select form-control"
                                        required>
                                        @inject('sectors', '\App\Sector')
                                        @foreach ($sectors->getSectors() as $sectors)
                                            <option value="{{ $sectors->cc }}"
                                                @if ($vehiclerequest->setorsolicitante == $sectors->cc) selected @endif class="form-control">
                                                {{ $sectors->sector }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Finalidade -->
                <div class="col-md-12">
                    <div class="ls-box">
                        <h5 class="ls-title-5">Finalidade</h5>
                        <hr>
                        <div class="ls-box">
                            <div class="col-md-12">
                                <b class="ls-label-text">Descreva o motivo da solicitação:</b>
                                <textarea id="adm-fin" class="form-control" rows="3" name="admfin"
                                    oninvalid="this.setCustomValidity('Descreva o motivo da solicitação!')"
                                    onchange="try{setCustomValidity('')}catch(e){}" required>{{ $vehiclerequest->admfin }}</textarea>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <!-- Data e Hora da Solicitação -->
                <div class="col-md-12">
                    <div class="ls-box">
                        <h5 class="ls-title-5">Data da Solicitação</h5>
                        <hr>
                        <div class="form-group col-md-4">
                            <b class="ls-label-text">Data da Solicitação</b>
                            <input type="date" class="form-control" id="dataSolicitacao" name="datasaida"
                                value="{{ $vehiclerequest->datasaida }}" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <b class="ls-label-text">Hora da Solicitação</b>
                            <input type="text" class="form-control" id="horaSolicitacao" name="horasaida"
                                value="{{ $vehiclerequest->horasaida }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <!-- Botões de Ação -->
        <div class="col-md-12">
            <div class="jumbotron">
                <div align="right" style="font-weight: bold;">
                    <input type="submit" value="Salvar Alterações" class="ls-btn-primary" title="Editar"
                        style="font-weight: bold;">
                    <a class="ls-btn-primary-danger" style="font-weight: bold;"
                        href="{{ route('solicitacoes') }}">Cancelar</a>
                </div>
            </div>
        </div>

    </form>

    <!-- Scripts para exibir mapa, incrementar formulário e desabilitar inputs de Tabs -->
    <script type="text/javascript" src="{{ URL::asset('js/confirmeroute.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/incrementForm.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/enableordisableform.js') }}"></script>

    <script>
        function verifyCheck(range) {
            var inputs = document.getElementById("inputs[" + range + "]");
            var checkSolicitante = document.getElementById("checkSolicitante[" + range + "]");
            var inputSolicitante = `<input type="text" class="form-control col-md-12"
                            name="solicitante[` + range + `]" id="inputSolicitante" placeholder="Digite o nome do solicitante"
                            oninvalid="this.setCustomValidity('Informe o nome do solicitante deste roteiro!')"
                            onchange="try{setCustomValidity('')}catch(e){}" required>`;

            var selectSolicitante = `<select id="selectSolicitante" name="solicitante[` + range + `]" class="ls-select form-control col-md-12"
                             oninvalid="this.setCustomValidity('Selecione o usuário!')" onchange="try{setCustomValidity('')}catch(e){}" required>
                                <option value="" class="form-control">Selecione na lista de usuários</option>
                                @inject('users', '\App\User')
                                @foreach ($users->getUsers() as $users)
                                <option value="{{ $users->id }}" class="form-control">{{ $users->name }}</option>
                                @endforeach
                            </select>`;

            inputs.innerHTML = '';
            if (checkSolicitante.checked == true) {
                inputs.innerHTML = inputSolicitante;
            } else if (checkSolicitante.checked == false) {
                inputs.innerHTML = selectSolicitante;
            }
        }
    </script>
@stop
