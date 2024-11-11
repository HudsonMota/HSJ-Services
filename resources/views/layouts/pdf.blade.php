<!DOCTYPE html>
<html lang="pt-BR">

<head>
    @if (isset($statussolicitacao))
        <title>Solicitação: {{ $statussolicitacao }} {{ $solicitacao->id }}</title>
    @elseif (isset($statusauthorization))
        <title>Autorização: {{ $statusauthorization }} {{ $authorization->id }}</title>
    @endif
</head>

<body>
    <div class="container">
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/ARTE.png'))) }}"
                alt="Logo HSJ-SERVICE" style="align:center; width: 300px; height: 100px;">
        </div>
        @yield('content')
    </div>
</body>

</html>
