<!DOCTYPE html>
<html class="ls-theme-blue" lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="Insira aqui a descrição da página.">
    <link href="http://assets.locaweb.com.br/locastyle/3.10.0/stylesheets/locastyle.css" rel="stylesheet"
        type="text/css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"
        type="text/css">
    <link rel="stylesheet" href="css/app.css">
    <link rel="icon" href="{{ URL::asset('favicon.ico') }}" type="image/x-icon" />
    <title>{{ config('app.name') }}</title>
</head>

<body>
    <div class="ls-topbar">
        <div class="container-fluid d-flex align-items-center">
            <h1 class="ls-brand-name">
                <img src="{{ URL::asset('images/LogoHSJ2.png') }}" alt="profile Pic"
                    style="width: 175px; height: 50px; margin-top: -8px;">
            </h1>
            <div class="dashboard-info">
                @if (request()->routeIs('dashboard'))
                    <!-- Verifica se a rota atual é a do dashboard -->
                    <b class="ls-title-5" style="color:whitesmoke;">
                        <span id="requestCount" style="font-size: 36px; color:greenyellow;">
                            {{ $combinedData->total() ?? '0' }}
                            <!-- Valor padrão se $combinedData não estiver disponível -->
                        </span> - Solicitações e Autorizações
                    </b>
                @endif
            </div>
            <span class="clock-container" id="realtime-clock"></span>
            <div class="ls-notification-topbar ml-auto">
                <!-- Dropdown com detalhes da conta de usuário -->
                <div data-ls-module="dropdown" class="ls-dropdown ls-user-account">
                    <a href="#" class="ls-ico-user">
                        <span class="ls-name">{{ Auth::user()->name }}</span>
                    </a>
                    <nav class="ls-dropdown-nav ls-user-menu">
                        <ul>
                            <li><a href="{{ route('logout') }}">Sair</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <aside class="ls-sidebar">
        <div class="ls-sidebar-inner">
            <a href="/locawebstyle/documentacao/exemplos//pre-painel" class="ls-go-prev">
                <span class="ls-text">Voltar à lista de controle</span>
            </a>
            <nav class="ls-menu">
                <ul>
                    <!-- PÁGINA INICIAL -->
                    <li><a href="/" class="ls-ico-home" title="Pagina Inicial">PÁGINA INICIAL</a></li>
                    <!-- /PÁGINA INICIAL -->
                    <!-- ADMINISTRATIVO -->
                    @can('Manages Users')
                        <li>
                            <a href="#" class="ls-ico-cog">ADMINISTRATIVO</a>
                            <ul>
                                <li><a href="{{ route('users') }}">Atualizar Informações <br> de Usuários</a></li>
                                <li><a href="/roleuser/add">Cadastrar Papel <br> do Usuário</a></li>
                                <li><a href="{{ route('roleusers') }}">Editar Papel <br> do Usuário</a></li>
                            </ul>
                        </li>
                    @endcan
                    <!-- /ADMINISTRATIVO -->
                    <!-- AUTORIZAR SOLICITAÇÕES -->
                    @can('Authorize Request')
                        <li>
                            <a href="#" class="ls-ico-checkmark-circle">AUTORIZAÇÕES E <br> PENDÊNCIAS</a>
                            <ul>
                                <li><a href="/authorization-add"> Autorizações Aguardando Atendimento </a></li>
                                <li><a href="{{ route('authorizations') }}"> Listar Solicitações </a></li>
                            </ul>
                        </li>
                    @endcan
                    <!-- /AUTORIZAR SOLICITAÇÕES -->



                    <!-- CADASTRAR TÉCNICOS -->
                    @can('Manages drivers')
                        <li>
                            <a href="#" class="ls-ico-user-add">TÉCNICOS</a>
                            <ul>
                                <li><a href="/driver/add">Cadastrar Técnico</a></li>
                                <li><a href="{{ route('drivers') }}">Listagem de Técnicos</a></li>
                            </ul>
                        </li>
                    @endcan
                    <!-- /CADASTRAR TÉCNICO -->


                    <!-- SOLICITAR ATENDIMENTO -->
                    <li>
                        <a href="#" class="ls-ico-code" title="Solicitacao">ATENDIMENTOS</a>
                        <ul>
                            <li><a href="/solicitacao-add">Solicitar Atendimento</a></li>
                            <li><a href="{{ route('solicitacoes') }}">Verificar Atendimentos</a></li>
                        </ul>
                    </li>
                    <!-- /SOLICITAR ATENDIMENTO -->

                    <!-- DASHBOARD-->
                    @can('View ADM dashboard')
                        <li>
                            <a href="/dashboard" class="ls-ico-dashboard" name="dashboard">DASHBOARD</a>
                        </li>
                    @endcan
                    <!-- /DASHBOARD-->
                </ul>
            </nav>
        </div>
    </aside>

    <main class="ls-main">
        <div class="container-fluid">
            @yield('content')
            <footer>
                <div class="card-footer text-muted d-flex justify-content-center align-items-center"
                    style="background-color: #f8f9fa; border-top: 1px solid rgba(0,0,0,0.1); padding: 10px 20px; margin: 0;">
                    <div class="text-center">
                        &copy; 2024 - Todos os direitos reservados | TIC-HSJ | (85) 3194-6217
                    </div>
                </div>
            </footer>
        </div>
    </main>


    <style>
        /* CSS global */
        .clock-container {
            font-size: 35px;
            font-family: 'Digital-7', sans-serif;
            color: #fff;
            padding: 5px 10px;
            border-radius: 25px;
            display: inline-block;
            margin-left: 20px;
        }

        .ls-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 120px;
        }

        .ls-brand-name {
            margin: 0;
            flex: 1;
            /* Permite que a imagem ocupe o espaço restante */
        }

        .dashboard-info {
            flex: 2;
            /* Ocupa o espaço do meio */
            text-align: center;
            /* Centraliza o conteúdo */
        }

        .ls-user-account {
            margin-right: 20px;
        }
    </style>

    <!-- We recommended use jQuery 1.10 or up -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="http://assets.locaweb.com.br/locastyle/3.10.0/javascripts/locastyle.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.22/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/datatables.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.22/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/b-print-1.6.5/datatables.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"
        integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw=="
        crossorigin="anonymous"></script>

    <script>
        function updateClock() {
            var now = new Date();
            var formattedTime = now.toLocaleTimeString('pt-BR', {
                hour12: false
            });
            document.getElementById('realtime-clock').innerHTML = formattedTime;
        }

        setInterval(updateClock, 1000);
        updateClock(); // Call once immediately to set the clock

        // Ajusta a classe 'dashboard' no body para estilizar o relógio corretamente
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.pathname === '/dashboard') {
                document.body.classList.add('dashboard');
            }
        });
    </script>

</body>

</html>
