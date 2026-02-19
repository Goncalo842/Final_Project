<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISTP - University</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/imagem2.jpeg') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/settings.css') }}">
</head>

<body>

    <div class="container bar-container navbar navbar-expand-md navbar-light">
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="ISTP Logo" style="height: 80px;">
            </a>
        </div>

        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#settingsNavbar" aria-controls="settingsNavbar" aria-expanded="false"
            aria-label="Alternar navegação">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="settingsNavbar">
            <nav class="nav-center">
                @auth
                    @if (Auth::user()->user_type == 30)
                        <a href="{{ route('admin') }}">Dashboard</a>
                    @endif
                @endauth

                @if (!Auth::check() || Auth::user()->user_type != 30)
                    <a href="{{ url('/settings') }}">Inicio</a>
                    <a href="{{ route('user.edit') }}">Caderneta</a>
                @endif

                @auth
                    @if (Auth::user()->user_type == 10)
                        <a href="{{ route('pay') }}">Pagamento</a>
                    @endif
                @endauth

                @auth
                    @if (Auth::user()->user_type == 30)
                        <a href="{{ route('admin.candidaturas.index') }}">Candidaturas</a>
                    @endif
                    <a href="{{ url('staionery') }}">Loja</a>
                @endauth

                @if (!Auth::check() || Auth::user()->user_type != 30)
                    <a href="{{ url('grade') }}">Avaliações</a>
                @endif
            </nav>

            <nav class="d-flex align-items-center gap-3">
                @auth
                    <div class="dropdown">
                        <button class="btn dropdown-toggle account-button" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <img src="https://static.vecteezy.com/system/resources/thumbnails/024/983/914/small_2x/simple-user-default-icon-free-png.png"
                                alt="Perfil" class="profile-img">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form action="{{ route('saldo.recarregar') }}" method="GET">
                                    <button class="dropdown-item" type="submit">
                                        Saldo: {{ number_format(Auth::user()->saldo, 2, ',', '.') }} €
                                    </button>
                                </form>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Sair</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </nav>
        </div>
    </div>

    @yield('content')

</body>

</html>
