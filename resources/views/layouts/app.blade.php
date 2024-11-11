<!doctype html>
<html lang="{{ date_default_timezone_set('America/Fortaleza') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ URL::asset('favicon.ico') }}" type="image/x-icon" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logos-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 100%;
        }

        .logos-container img.logo1 {
            width: 316px;
            margin-top: 6px;
        }

        .logos-container img.logo3 {
            width: 210px;
            margin-top: 5px;
        }

        .navbar-nav.ml-auto {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .navbar-nav.ml-auto li {
            margin-left: 10px;
        }

        /* Estilo para o contêiner da imagem de fundo */
        .background-container {
            position: relative;
            width: 100%;
            height: 240px;
            /* Ajuste a altura conforme necessário */
            background-image: url('{{ asset('images/LogoHSJ.png') }}');
            background-size: contain;
            /* Ajusta o tamanho da imagem para caber dentro do contêiner */
            background-position: center;
            background-repeat: no-repeat;
            opacity: 20%;
            margin-top: 0px;
            /* Espaçamento para separar da área de conteúdo */
            z-index: -1;
            /* Garante que a imagem fique atrás do conteúdo */
            /* background-color: #fff; */
            /* Cor de fundo para evitar mostrar partes não preenchidas */
        }

        /* Adiciona opacidade à imagem de fundo */
        /* .background-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('images/LogoHSJ.png') }}');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 50%;*/
        /* Define a opacidade para 30% */
        /* z-index: -1;
         }*/

        /* Garante que o conteúdo principal não se sobreponha à imagem de fundo */
        .content-wrapper {
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>

    <div style="display: none;">
        Ícones feitos por <a href="https://www.flaticon.com/br/autores/freepik" title="Freepik">Freepik</a> from <a
            href="https://www.flaticon.com/br/" title="Flaticon"> www.flaticon.com</a>
    </div>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <div class="logos-container">
                    <ul
                        style="display: flex; justify-content: center; align-items: center; list-style-type: none; padding: 0;">
                        <li>
                            <img src="{{ asset('images/ARTE.png') }}" class="logo1"
                                style="width: 316px; margin-top: 6px; margin-left:150px;" />
                        </li>
                        <li>
                            <img src="{{ asset('images/LogoHSJ.png') }}" class="logo3"
                                style="width: 160px; margin-top: 5px; margin-left: 100px;" />
                        </li>
                        <li>
                            <img src="{{ asset('images/logo.png') }}" class="logo3"
                                style="width: 150px; margin-top: 5px; margin-left: 100px;" />
                        </li>
                    </ul>
                </div>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item" style="margin-left: 100px;">
                            <a class="nav-link btn btn-success" style="color: #fff; font-weight: bold;"
                                href="{{ route('login') }}">{{ __('Entrar') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link btn btn-primary" style="color: #fff; font-weight: bold;"
                                    href="{{ route('register') }}">{{ __('Cadastro') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>
        <div class="content-wrapper">
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Adiciona o contêiner da imagem de fundo -->
    <div class="background-container"></div>

</body>

</html>
