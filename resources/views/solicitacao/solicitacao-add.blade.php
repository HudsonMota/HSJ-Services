@extends('layouts.application')

@section('content')
    <h1 class="ls-title-intro ls-ico-code">Solicitar Atendimento</h1>

    <form method="POST" action="{{ route('solicitacao.postAdd') }}" class="ls-form row" id="add" autocomplete="on">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <fieldset id="field01">
            <div class="ls-box">
                <div class="col-md-12">
                    <div class="ls-box">
                        <div class="col-md-6">
                            <h5 class="ls-title-5">Solicitante / Setor</h5>
                            <hr>
                            <div class="form-group col-md-12">
                                <b class="ls-label-text">Nome do Solicitante:</b>

                                <div id="inputs[0]">
                                    <select id="selectSolicitante[0]" name="solicitante[0]"
                                        class="ls-select form-control col-md-12" required readonly>
                                        <option value="{{ Auth::user()->id }}" class="form-control" selected>
                                            {{ Auth::user()->name }}
                                        </option>
                                    </select>
                                </div>

                            </div>

                            <div class="form-group col-md-12">
                                <b class="ls-label-text">Localização:</b>
                                <div class="ls-custom-select">
                                    <select id="setorsolicitante[0]" name="setorsolicitante[0]"
                                        class="ls-select form-control" required
                                        oninvalid="this.setCustomValidity('Selecione o setor!')"
                                        onchange="try{setCustomValidity('')}catch(e){}">
                                        <option value="" class="form-control">--</option>
                                        @inject('sectors', '\App\Sector')
                                        @php
                                            $userSectorId = Auth::user()->sector_id;
                                        @endphp
                                        @foreach ($sectors->getSectors()->sortBy('sector') as $sector)
                                            <option value="{{ $sector->cc }}" class="form-control"
                                                {{ $sector->cc == $userSectorId ? 'selected' : '' }}>
                                                {{ $sector->sector }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="ls-box">
                        <h5 class="ls-title-5">Finalidade</h5>
                        <hr>
                        <div class="ls-box">
                            <div class="col-md-12">
                                <b class="ls-label-text">Descreva o motivo da solicitação:</b>
                                <textarea id="adm-fin[0]" class="form-control" rows="3" name="admfin[0]" required
                                    oninvalid="this.setCustomValidity('Descreva o motivo da solicitação!')"
                                    onchange="try{setCustomValidity('')}catch(e){}"></textarea>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="ls-box">
                        <h5 class="ls-title-5">Data da Solicitação</h5>
                        <hr>
                        <div class="form-group col-md-4">
                            <b class="ls-label-text">Data da Solicitação</b>
                            <input type="date" class="form-control" id="dataSolicitacao" name="datasaida[0]" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <b class="ls-label-text">Hora da Solicitação</b>
                            <input type="text" class="form-control" id="horaSolicitacao" name="horasaida[0]" readonly>
                        </div>
                    </div>
                </div>

                <script type="text/javascript">
                    function formatTimeComponent(component) {
                        return component.toString().padStart(2, '0');
                    }

                    function updateClock() {
                        var now = new Date();
                        var hours = formatTimeComponent(now.getHours());
                        var minutes = formatTimeComponent(now.getMinutes());
                        var seconds = formatTimeComponent(now.getSeconds());
                        var formattedTime = hours + ":" + minutes + ":" + seconds;
                        document.getElementById('horaSolicitacao').value = formattedTime;
                    }

                    window.onload = function() {
                        // Preencher data no carregamento da página
                        var today = new Date();
                        var date = today.toISOString().split('T')[0]; // Pega a data no formato YYYY-MM-DD
                        document.getElementById("dataSolicitacao").value = date;

                        // Preencher hora no carregamento da página
                        updateClock();
                    };

                    // Atualiza a hora exata a cada segundo
                    setInterval(updateClock, 1000);

                    // Atualiza a hora exata no momento do clique no botão de envio
                    document.getElementById('add').addEventListener('submit', function() {
                        updateClock(); // Atualiza a hora com segundos no momento do envio
                    });
                </script>

            </div>
        </fieldset>

        <div class="jumbotron col-md-12" style="margin-top: 20px;">
            <div style="font-weight: bold; text-align: right; margin-bottom: 20px; margin-top:-40px;">
                <input type="submit" value="Solicitar Atendimento" class="ls-btn-primary" title="Solicitar"
                    style="font-weight: bold;">
                <input class="ls-btn-primary-danger" type="reset" value="Limpar Formulário" style="font-weight: bold;">
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
                                <option value="" class=" form-control">Selecione na lista de usuários</option>
                                @inject('users', '\App\User')
                                @foreach ($users->getUsers() as $users)
                                <option value="{{ $users->id }}" class=" form-control">{{ $users->name }}</option>
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
