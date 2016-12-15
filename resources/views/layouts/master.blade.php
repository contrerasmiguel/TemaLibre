<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>TemaLibre</title>
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('css/temalibre.css') }}" rel="stylesheet"/>
    <!--[if lt IE 9]>
    <script src="{{ URL::asset('js/html5shiv.min.js') }}"></script>
    <script src="{{ URL::asset('js/respond.min.js') }}"></script>
    <![endif]-->
    @yield('head')
</head>
<body>
    @if(Auth::check())
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/"><b>TemaLibre</b></a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="/">Inicio</a></li>
                    <li><a href="/topic/list">Temas</a></li>
                    <li><a href="/profile/list">Miembros</a></li>
                    <li><a href="/auth/logout">Cerrar sesión</a></li>
                </ul>
            </div>
        </nav>
    @endif
    @yield('content')
    <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    @yield('scripts')
</body>
</html>