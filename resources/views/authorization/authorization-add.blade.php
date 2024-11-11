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
                    <h5 class="alert alert-danger">{!! \Session::get('error') !!}</h5>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <div class="ls-modal" id="myAwesomeModal">
        <div class="ls-modal-box">
            <div class="ls-modal-header">
                <button data-dismiss="modal">&times;</button>
                <h3 class="ls-modal-title" style="color: red;">Atenção!</h3>
            </div>
            <div class="ls-modal-body" id="myModalBody">
                <b>Não há veículos nesta frota que comportem esta quantidade de passageiros. <br>Por favor, realocar em mais
                    de um veículo.</b>
            </div>
            <div class="ls-modal-footer">
                <button class="ls-btn-danger" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>

    <h1 class="ls-title-intro ls-ico-user-add">Criar Autorização</h1>
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="ls-box">
                <b class="ls-title-5"><span style="color: red;"><?php echo DB::table('vehiclerequests')->where('statussolicitacao', 'AGUARDANDO')->count(); ?></span> - Solicitações Aguardando
                    Atendimento</b>
                <hr>
                <table class="table table-hover" id="tb1">
                    <thead>
                        <tr>
                            <th class="a-center" width="60">Cod</th>
                            <th class="a-center">Solicitante - Setor</th>
                            <th class="a-center">Descrição</th>
                            <th class="a-center">Data Solicitada</th>
                            <th class="a-center" width="25">Inserir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehiclerequests as $vehiclerequest)
                            <tr data-index="{{ $vehiclerequest->id }}">
                                <td>{{ $vehiclerequest->id }}</td>
                                <td>
                                    <?php
                                    $userNameOrInformed = '';
                                    foreach ($users as $user) {
                                        if ($user->id == $vehiclerequest->solicitante) {
                                            $userNameOrInformed = $user->name;
                                        }
                                    }

                                    if ($userNameOrInformed == '') {
                                        $userNameOrInformed = $vehiclerequest->solicitante;
                                    }

                                    $name = substr($userNameOrInformed, 0, 14) . '...';
                                    echo $name;

                                    ?> <br>

                                    @inject('sectors', '\App\Sector')
                                    @foreach ($sectors->getSectors() as $sectors)
                                        @if ($sectors->cc === $vehiclerequest->setorsolicitante)
                                            {{ $setor = substr($sectors->sector, 0, strrpos(substr($sectors->sector, 0, 40), ' ')) . '...' }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ substr($vehiclerequest->admfin, 0, 100) . (strlen($vehiclerequest->admfin) > 100 ? '...' : '') }}
                                </td>


                                {{-- HORA DA SOLICITAÇÃO --}}
                                <td>
                                    <?php
                                    $dataSolicitada = !empty($vehiclerequest->datasaida) ? date('d/m/Y', strtotime($vehiclerequest->datasaida)) : 'Data não disponível';
                                    $horaSolicitada = !empty($vehiclerequest->horasaida) ? date('H:i:s', strtotime($vehiclerequest->horasaida)) : 'Hora não disponível';
                                    ?>
                                    {{ $dataSolicitada }}<br>
                                    {{ $horaSolicitada }}
                                </td>
                                <td><input class="limited" type="checkbox"
                                        onclick="cloneOrRemove(this, '{{ $vehiclerequest->id }}')"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <nav aria-label="...">
                <ul class="pagination pagination-sm justify-content-end">
                    <li class="page-item" aria-current="page">{{ $vehiclerequests->links() }}</li>
                </ul>
            </nav>
        </div>
        <div class="col-md-6">
            <div class="ls-box">
                <b class="ls-title-5">Roteiro
                    <div align="right" style="font-weight: bold; position: relative; top: -25px; margin-bottom: -25px;">
                        <a id="openModal" onclick="parseInfo()" data-ls-module="modal" data-target="#modalLarge"
                            class="ls-ico-user-add ls-btn-primary"> Definir</a>
                        <a href="/authorization-add" class="ls-ico-spinner ls-btn-primary-danger"> Desfazer</a>
                        <!-- Adicionar o botão RECUSADO -->
                        {{-- <div class="col-md-12">
                            <div class="text-right"> --}}
                        {{-- <button id="rejectRequests" class="btn btn-danger">RECUSADO</button> --}}
                        <button id="rejectRequests" class="ls-ico-close ls-btn-danger">RECUSADO</button>
                        {{-- </div>
                    </div> --}}
                    </div>
                </b>
                <hr>
                <table class="table table-hover" id="tb2">
                    <thead id="thead">
                        <tr>
                            <th class="a-center" width="10">Cod</th>
                            <th class="a-center">Solicitante - Setor</th>
                            <th class="a-center">Descrição</th>
                            <th class="a-center">Data Solicitada</th>
                            <th class="a-center" width="25">Saída</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="ls-modal" id="modalLarge">
        <div class="ls-modal-large">
            <div class="ls-modal-header">
                <button data-dismiss="modal">&times;</button>
                <h4 class="ls-modal-title">Informações de Autorização</h4>
            </div>
            <div class="ls-modal-body">
                <form method="POST" action="{{ route('authorization.postAdd') }}" class="ls-form row" id="add">
                    @csrf
                    <fieldset id="field01">
                        <div class="col-md-12">
                            <div class="ls-box">
                                <div class="col-md-12">
                                    <div class="form-group col-md-6">
                                        <b class="ls-label-text">Técnico</b>
                                        <div class="ls-custom-select">
                                            <select id="" name="driver" class="ls-select form-control" required
                                                oninvalid="this.setCustomValidity('Selecione um técnico!')"
                                                onchange="try{setCustomValidity('')}catch(e){}">
                                                <?php $drivers = DB::table('drivers')->where('id', '!=', '1')->get(); ?>
                                                <option value="">Selecione um técnico</option>
                                                @foreach ($drivers as $driver)
                                                    <option value="{{ $driver->id }}">{{ $driver->name_driver }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <b class="ls-label-text">Data da saída autorizada</b>
                                        <input type="date" class="form-control" name="datasaidaautorizada"
                                            value="{{ date('Y-m-d') }}" required
                                            oninvalid="this.setCustomValidity('Informe a data de saída autorizada!')"
                                            onchange="try{setCustomValidity('')}catch(e){}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <b class="ls-label-text">Hora da saída autorizada</b>
                                        <input type="time" class="form-control" name="horasaidaautorizada"
                                            value="{{ date('H:i:s') }}" required
                                            oninvalid="this.setCustomValidity('Informe o horário de saída autorizado!')"
                                            onchange="try{setCustomValidity('')}catch(e){}">
                                    </div>

                                    <input type="hidden" id="selectRequestsArray" name="selectrequestsarray"
                                        value="">

                                    <div class="col-md-12">
                                        <b>Ao verificar se o Atendimento está correto salve as informações adicionais!</b>
                                        <table class="table table-hover" id="confirmeTable">
                                            <thead>
                                                <tr>
                                                    <th class="a-center" width="60">Cod</th>
                                                    <th class="a-center">Solicitante - Setor</th>
                                                    <th class="a-center">Origem - Destino</th>
                                                    <th class="a-center" width="25">Saída</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>

                                        <!-- Este Script apenas clona a tabela para o Modal -->
                                        <!-- Ele também envia os ids das solicitações selecionadas para um input -->
                                        <script>
                                            function parseInfo() {
                                                confirmeTable.innerHTML = '';
                                                var tbody = document.getElementById("tbody");
                                                var thead = document.getElementById("thead");
                                                jQuery("#confirmeTable")
                                                    .append(jQuery(tbody).clone(), jQuery(thead).clone());

                                                var selectrequestsarray = document.getElementById("selectRequestsArray");
                                                selectrequestsarray.value = $confirmScript;
                                            }
                                        </script>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button id="submit" style="margin: 20px;" type="submit"
                                class="ls-btn-primary">Salvar</button>
                            <button style="margin: 20px;" class="btn btn-danger ls-float-right" data-dismiss="modal"
                                type="button">Cancelar</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="{{ URL::asset('js/cloneorremove.js') }}"></script>
    <script>
        document.getElementById('rejectRequests').addEventListener('click', function() {
            var selectedRequests = [];
            document.querySelectorAll('#tb1 input[type="checkbox"]:checked').forEach(function(checkbox) {
                selectedRequests.push(checkbox.closest('tr').getAttribute('data-index'));
            });

            if (selectedRequests.length === 0) {
                alert('Selecione pelo menos uma solicitação para recusar.');
                return;
            }

            // Cria uma caixa de diálogo para inserir o motivo da recusa
            var motivoRecusa = prompt('Descreva o motivo da recusa:');

            if (motivoRecusa === null) {
                return; // Cancelou a operação
            }

            if (confirm('Tem certeza de que deseja recusar as solicitações selecionadas?')) {
                fetch('{{ route('authorization.postReject') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            requests: selectedRequests,
                            motivoRecusa: motivoRecusa // Envia o motivo da recusa para o servidor
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Solicitações recusadas com sucesso.');
                            location.reload();
                        } else {
                            alert('Ocorreu um erro ao recusar as solicitações.');
                        }
                    });
            }
        });
    </script>

@stop
