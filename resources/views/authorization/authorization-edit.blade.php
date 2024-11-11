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
            locastyle.modal.close()
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

    <h1 class="ls-title-intro ls-ico-user-add">Editar Atendimento</h1>
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
                            <th class="a-center">Origem - Destino</th>
                            <th class="a-center" width="25">Saída</th>
                            <th class="a-center" width="25">Inserir</th>
                        </tr>
                    </thead>
                    <tbody id="tbodytb1">
                        @foreach ($vehiclerequests as $vehiclerequest)
                            <tr data-index="<?php echo $vehiclerequest->id; ?>" id="<?php echo $vehiclerequest->id; ?>">
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

                                    -

                                    @inject('sectors', '\App\Sector')
                                    @foreach ($sectors->getSectors() as $sectors)
                                        @if ($sectors->cc === $vehiclerequest->setorsolicitante)
                                            {{ $sectors->sector }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <?php
                                    $origem = substr($vehiclerequest->origem, 0, strrpos(substr($vehiclerequest->origem, 0, 20), ' ')) . '...';
                                    $destino = substr($vehiclerequest->destino, 0, strrpos(substr($vehiclerequest->destino, 0, 20), ' ')) . '...';
                                    ?>
                                    {{ $origem }} -
                                    <br>
                                    {{ $destino }}
                                </td>
                                <td>
                                    <?php echo date('d/m/Y', strtotime($vehiclerequest->datasaida)); ?>
                                    <?php echo date('H:m', strtotime($vehiclerequest->horasaida)); ?>
                                </td>
                                <td><input class="limited" type="checkbox"
                                        onclick="cloneOrRemove(this,'<?php echo $vehiclerequest->id; ?>')"></td>
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
                <b class="ls-title-5">Atendimento Nº: {{ $scriptauthorized->id }}
                    <div align="right" style="font-weight: bold; position: relative; top: -25px; margin-bottom: -25px;">
                        <a onclick="parseInfoModal()" class="ls-ico-user-add ls-btn-primary"> Definir</a href="#">
                        <a href="/authorization-edit/{{ $scriptauthorized->id }}"
                            class="ls-ico-spinner ls-btn-primary-danger"> Desfazer</a href="#">
                    </div>
                </b>
                <hr>
                <table class="table table-hover" id="tb2">
                    <thead id="thead">
                        <tr>
                            <th class="a-center" width="60">Cod</th>
                            <th class="a-center">Solicitante - Setor</th>
                            <th class="a-center">Origem - Destino</th>
                            <th class="a-center" width="25">Saída</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="ls-modal ls-opened" data-modal-blocked id="modalLarge" aria-hidden="false" data-backdrop="static"
        data-keyboard="false">
        <div class="ls-modal-large">
            <div class="ls-modal-header">
                <h4 class="ls-modal-title">Informações adicionais</h4>
            </div>
            <div class="ls-modal-body">
                <form method="POST" action="{{ route('authorization.postEdit', $scriptauthorized->id) }}"
                    class="ls-form row" id="add">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <fieldset id="field01">
                        <div class="col-md-12">
                            <div class="ls-box">
                                <div class="col-md-12">
                                    <div class="form-group col-md-6">
                                        <b class="ls-label-text">Motorista</b>
                                        <div class="ls-custom-select">
                                            <select id="" name="driver" class="ls-select form-control" required
                                                oninvalid="this.setCustomValidity('Selecione um motorista!')"
                                                onchange="try{setCustomValidity('')}catch(e){}">
                                                <?php $drivers = DB::table('drivers')->where('id', '!=', '1')->get(); ?>
                                                @foreach ($drivers as $driver)
                                                    <option @if ($scriptauthorized->driver == $driver->id) selected @endif
                                                        value="{{ $driver->id }}">{{ $driver->name_driver }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <b class="ls-label-text">Data do saída autorizada</b>
                                        <input type="date" class="form-control" name="datasaidaautorizada"
                                            value="{{ $scriptauthorized->authorized_departure_date }}" required
                                            oninvalid="this.setCustomValidity('Informe a data que pretende sair!')"
                                            onchange="try{setCustomValidity('')}catch(e){}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <b class="ls-label-text">Hora do saída autorizada</b>
                                        <input type="time" class="form-control" name="horasaidaautorizada"
                                            value="{{ $scriptauthorized->authorized_departure_time }}" required
                                            oninvalid="this.setCustomValidity('Informe o horário que pretende sair!')"
                                            onchange="try{setCustomValidity('')}catch(e){}">
                                    </div>

                                    <input type="hidden" id="selectRequestsArray" name="selectrequestsarray"
                                        value="">

                                    <div class="col-md-12">
                                        <div id="alertmodal" onclick="closeAlertRemove()" class="ls-alert-info">
                                            <strong>Caso hajam itens na lista e queira remove-los, <br> basta clicar no item
                                                desejado.</strong> <span class="ls-float-right ls-ico-close"></span>
                                        </div>
                                        <script>
                                            function closeAlertRemove() {
                                                alertmodal.style.display = "none";
                                            }
                                        </script>
                                        <b>Ao verificar se o atendimento está correto salve as informações adicionais!</b>
                                        <table class="table table-hover" id="confirmeTable2">
                                            <thead id="theadmodal">
                                                <tr>
                                                    <th class="a-center" width="60">Cod</th>
                                                    <th class="a-center">Solicitante - Setor</th>
                                                    <th class="a-center">Origem - Destino</th>
                                                    <th class="a-center" width="25">Saída</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbodymodal">
                                                @foreach ($grouprequestsauth as $grouprequest)
                                                    <tr onclick="removeItemModal(this,'{{ $grouprequest->id }}'), remove(this)"
                                                        data-index="{{ $grouprequest->id }}"
                                                        id="{{ $grouprequest->id }}">
                                                        <td>{{ $grouprequest->id }}</td>
                                                        <td>

                                                            <?php
                                                            $userNameOrInformed = '';
                                                            foreach ($users as $user) {
                                                                if ($user->id == $grouprequest->solicitante) {
                                                                    $userNameOrInformed = $user->name;
                                                                }
                                                            }

                                                            if ($userNameOrInformed == '') {
                                                                $userNameOrInformed = $grouprequest->solicitante;
                                                            }

                                                            $name = substr($userNameOrInformed, 0, 14) . '...';
                                                            echo $name;

                                                            ?> <br>

                                                            @inject('sectors', '\App\Sector')
                                                            @foreach ($sectors->getSectors() as $sectors)
                                                                @if ($sectors->cc === $grouprequest->setorsolicitante)
                                                                    {{ $sectors->sector }}
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $origem = substr($grouprequest->origem, 0, strrpos(substr($grouprequest->origem, 0, 20), ' ')) . '...';
                                                            $destino = substr($grouprequest->destino, 0, strrpos(substr($grouprequest->destino, 0, 20), ' ')) . '...';
                                                            ?>
                                                            {{ $origem }} -
                                                            <br>
                                                            {{ $destino }}
                                                        </td>
                                                        <td>
                                                            <?php echo date('d/m/Y', strtotime($grouprequest->datasaida)); ?>
                                                            <?php echo date('H:m', strtotime($grouprequest->horasaida)); ?>
                                                        </td>
                                                        <!-- <td style="color: red;" class="ls-ico-close"></td> -->
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="/authorizations" style="margin: 20px; text-decoration:none;"
                                class="ls-btn-primary-danger ls-float-right">Cancelar</a>
                            <button style="margin: 20px;" type="submit" class="ls-btn-primary">Salvar alterações deste
                                Atendimento</button>
                            <span onclick="parseInfoReturn()" style="margin: 20px; background-color: blue; color: #fff;"
                                class="ls-btn-default">
                                <span class="ls-ico-plus"></span>
                                Clique aqui para incluir mais um passageiro
                            </span>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ URL::asset('js/cloneorremove.js') }}"></script>

    <!-- Este Script apenas clona a tabela para o Modal -->
    <!-- Ele também envia os ids das solicitações selecionadas para um input -->
    <script>
        function parseInfoModal() {
            var codmodal, requestermodal, pathrequetsmodal, exittimemodal;
            var countTrTableRight = jQuery("#tb2 tbody tr").length;
            tbodymodal.innerHTML = "";
            for (var t = 0; t < countTrTableRight; t++) {
                var trr = jQuery("#tb2 tbody tr:eq(" + t + ")");

                codmodal = $('td:eq(0)', trr).text().trim();
                requestermodal = $('td:eq(1)', trr).text().trim();
                pathrequetsmodal = $('td:eq(2)', trr).text().trim();
                exittimemodal = $('td:eq(3)', trr).text().trim();

                jQuery("table#confirmeTable2 tbody").append(
                    `<tr  onclick="removeItemModal(this,'` + codmodal + `'), remove(this)" data-index="` + codmodal +
                    `" id="` + codmodal + `">
              <td>` + codmodal + `</td>
              <td>` + requestermodal + `</td>
              <td>` + pathrequetsmodal + `</td>
              <td>` + exittimemodal + `</td>
            </tr>`
                );
            }
            locastyle.modal.open("#modalLarge");
        }

        // Pega as linhas da tabela modal e suas colunas
        var row2 = jQuery("#confirmeTable2 tbody tr");
        // Pega as colunas da tabela modal
        var txt2 = $('td:eq(0)', row2).text().trim();

        // Pega as linhas da tabela direita e suas colunas
        var row3 = jQuery("#tb2 tbody tr");
        // Pega as colunas da tabela direita
        var txt3 = $('td:eq(0)', row3).text().trim();

        // Este script ...
        // Desabilita o modal
        // Pega as solicitações não selecionadas joga na tabela esquerda com chebox marcado
        // o que fará com que elas sejam refletidas na tabela direita
        function parseInfoReturn() {

            var cod, requester, pathrequets, exittime;
            var countTrTableModal = jQuery("#confirmeTable2 tbody tr").length;
            for (var c = 0; c < countTrTableModal; c++) {
                var trm = jQuery("#confirmeTable2 tbody tr:eq(" + c + ")");

                cod = $('td:eq(0)', trm).text().trim();
                requester = $('td:eq(1)', trm).text().trim();
                pathrequets = $('td:eq(2)', trm).text().trim();
                exittime = $('td:eq(3)', trm).text().trim();

                // Pega as linhas da tabela esquerda e suas colunas
                var row = jQuery("#tb1 tbody tr");
                // Pega as colunas da tabela esquerda
                var txt = $('td:eq(0)', row).text().trim();

                if (txt.match(txt2) && txt2.match(txt3)) {

                } else {
                    jQuery("table#tb2 tbody").append(
                        `<tr data-index="` + cod + `" id="` + cod + `">
              <td>` + cod + `</td>
              <td>` + requester + `</td>
              <td>` + pathrequets + `</td>
              <td>` + exittime + `</td>
            </tr>`
                    );

                    jQuery("table#tb1 tbody").append(
                        `<tr data-index="` + cod + `" id="` + cod + `">
              <td>` + cod + `</td>
              <td>` + requester + `</td>
              <td>` + pathrequets + `</td>
              <td>` + exittime + `</td>
              <td><input class="limited" type="checkbox" checked onclick="cloneOrRemove(this,'` + cod + `')"></td>
            </tr>`
                    );
                }

            }

            $("#modalLarge").removeClass("ls-opened");

        }
    </script>

    <!-- Este remove o item selecionado da tabela do modal
    e adiciona o mesmo item na tabela da esquerda na página -->
    <script>
        // Reinicializa o array com ids usados para criar roteiro
        $confirmScript = [];

        var cod, requester, pathrequets, exittime;

        // Conta os trs da tabel do modal
        var countTrTableModal = jQuery("#confirmeTable2 tbody tr").length;
        for (var it = 0; it < countTrTableModal; it++) {
            // Pega as linhas da tabela modal e suas colunas
            var ids = jQuery("#confirmeTable2 tbody tr:eq(" + it + ")").attr("id");
            // Pega as colunas da tabela modal

            // criar array ids para o roteiro
            $confirmScript.push(ids);
        }

        // Envia array de ids para input hidden form do modal
        var selectrequestsarray = document.getElementById("selectRequestsArray");
        selectrequestsarray.value = $confirmScript;

        var target = document.getElementById('tbodymodal');

        var observer = new MutationObserver(mutation => {
            ifThereIsaChange();
        });

        observer.observe(target, {
            childList: true
        });

        function ifThereIsaChange() {
            // Reinicializa o array com ids usados para criar roteiro
            $confirmScript = [];

            var cod, requester, pathrequets, exittime;

            // Conta os trs da tabel do modal
            var countTrTableModal = jQuery("#confirmeTable2 tbody tr").length;
            for (var it = 0; it < countTrTableModal; it++) {
                // Pega as linhas da tabela modal e suas colunas
                var ids = jQuery("#confirmeTable2 tbody tr:eq(" + it + ")").attr("id");
                // Pega as colunas da tabela modal

                // criar array ids para o roteiro
                $confirmScript.push(ids);
            }

            // Envia array de ids para input hidden form do modal
            var selectrequestsarray = document.getElementById("selectRequestsArray");
            selectrequestsarray.value = $confirmScript;
        }

        function removeItemModal(obj) {

            cod = $('td:eq(0)', obj).text().trim();
            requester = $('td:eq(1)', obj).text().trim();
            pathrequets = $('td:eq(2)', obj).text().trim();
            exittime = $('td:eq(3)', obj).text().trim();

            jQuery("table#tb1 tbody").append(
                `<tr data-index="` + cod + `" id="` + cod + `">
              <td>` + cod + `</td>
              <td>` + requester + `</td>
              <td>` + pathrequets + `</td>
              <td>` + exittime + `</td>
              <td><input class="limited" type="checkbox" onclick="cloneOrRemove(this,'` + cod + `')"></td>
            </tr>`
            );

            remove = function(item) {
                var tr = $(item).closest('tr');
                tr.fadeOut(400, function() {
                    tr.remove();
                });
                return false;
            }

        }
    </script>

@stop
