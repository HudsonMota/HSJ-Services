@extends('layouts.application')

@section('content')
    <h1 class="ls-title-intro ls-ico-code">Lista de Solicitações</h1>

    @if (isset($msg))
        <div class="alert alert-success">
            {{ $msg }}
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
    @if ($vehiclerequests == false)
        <div class="alert alert-danger" role="alert">
            <h2 class="blinking-text"><b>ATENÇÃO!</b></h2>
            Não há Chamados Criados para exibir!
        </div>
    @else
        <table class="table table-hover" id="tabRequests">
            <thead>
                <tr>
                    {{-- <th width="15">Ordem</th> --}}
                    <th>Cod</th>
                    <th>Solicitante</th>
                    <th width="400">Descrição</th>
                    <th>Setor</th>
                    <th>Data e hora de saída</th>
                    <th>Status</th>
                    <th width="240">Ações</th>
                </tr>
            </thead>
            <tbody id="tbodyrequests">
                <tr>
                    <td></td>
                </tr>
            </tbody>
        </table>
    @endif

    <script type="text/javascript">
        var requests = <?php echo $requests; ?>;
        var sectors = <?php echo $sectors; ?>;
        var users = <?php echo $users; ?>;

        function nameSolicitante(solcitanteTablreResquessts) {
            var userNameOrInformed = ''

            function returnUser(item) {
                if (solcitanteTablreResquessts === item.id.toString()) {
                    userNameOrInformed = item.name
                }
            }
            users.forEach(returnUser);

            if (userNameOrInformed == '') {
                userNameOrInformed = solcitanteTablreResquessts
            }

            return userNameOrInformed;
        }

        // Recebe o identificador do setor e retorna com base no DB o nome do setor
        function sectorsName(codSector) {
            for (var j = 0; j <= sectors.length; j++) {
                if (codSector == sectors[j].cc) {
                    return codSector = sectors[j].sector;
                }
            }
        }

        // Se o dia ou mês for menor que 10 será formatdo com um "0" a esquerda
        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }

        // Verifica o status da solicitação ou do roteiro e retorna uma cor para o style da coluna status das tabelas
        function colorSts(i) {
            if (i == "AGUARDANDO") {
                i = "red";
            } else if (i == "ATRIBUIDO" || i == "ATRIBUIDO") {
                i = "green";
            } else if (i == "PENDENTE") {
                i = "orange";
            } else if (i == "REALIZADO" || i == "REALIZADO") {
                i = "Mediumaquamarine";
            } else {
                i = "blue";
            }
            return i;
        }

        // Reseta a Table de solicitações
        tbodyrequests.innerHTML = '';
        // O "for" percorre o array de solicitações com base em seu tamanho
        for (var i = 0; i < requests.length; i++) {

            var datetime = new Date(requests[i].datasaida + "T" + requests[i].horasaida);
            var day = datetime.getDate();
            day = checkTime(day);
            var month = datetime.getMonth();
            month = checkTime(month + 1);
            var hour = datetime.getHours();
            hour = checkTime(hour);
            var minutes = datetime.getMinutes();
            minutes = checkTime(minutes);
            var seconds = datetime.getSeconds();
            seconds = checkTime(seconds);

            function getActionButtons(status) {
                switch (status) {
                    case 'AGUARDANDO':
                        return `
        <div class="col-md-4">
          <a class="ls-ico-pencil ls-btn-dark" style="background-color: blue;" href="/solicitacao-edit/${requests[i].id}"></a>
        </div>
        <div class="col-md-4">
          <a class="ls-ico-windows ls-btn" href="/solicitacao-pdf/${requests[i].id}" target="_blank"></a>
        </div>
      `;
                    case 'NÃO REALIZADA':
                        return `
        <div class="col-md-4">
          <a class="ls-ico-pencil ls-btn-dark" style="background-color: blue;" href="/solicitacao-edit/${requests[i].id}"></a>
        </div>
        <div class="col-md-4">
          <a class="ls-ico-windows ls-btn" href="/solicitacao-pdf/${requests[i].id}" target="_blank"></a>
        </div>
      `;
                    default:
                        return `
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
          <a class="ls-ico-windows ls-btn" href="/solicitacao-pdf/${requests[i].id}" target="_blank"></a>
        </div>
      `;
                }
            }

            // Preenche a tabela esquerda com as solicitações
            tbodyrequests.innerHTML += `<tr onclick="showScript('` + requests[i].grouprequest + `')">` +
                `<td data-index="1">` + requests[i].id + `</td>` +
                "<td>" + nameSolicitante(requests[i].solicitante) + "</td>" +
                "<td>" + (requests[i].admfin && requests[i].admfin.trim() !== '' ? requests[i].admfin.substring(0, 100) + (
                    requests[i].admfin.length > 100 ? '...' : '') : 'Não disponível') + "</td>" +
                "<td>" + sectorsName(requests[i].setorsolicitante) + "</td>" +
                "<td>" + day + "/" + month + "/" + datetime.getFullYear() + "<br>" + hour + ":" + minutes + ":" + seconds +
                "</td>" +
                `<td style="color:` + colorSts(requests[i].statussolicitacao) + `; font-weight: bold;">` + requests[i]
                .statussolicitacao + `</td>` +
                `<td>
        <div class="col-12">` +
                getActionButtons(requests[i].statussolicitacao) +
                `</div>
    </td>` +
                "</tr>";

        }

        //Exibe as opções de Datatables nas tabelas

        $(document).ready(function() {
            $('#tabRequests').DataTable({
                paging: true,
                lengthChange: true,
                pageLength: 10,
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
        });
    </script>
@endsection
