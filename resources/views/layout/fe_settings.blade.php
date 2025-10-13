<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/settings.css') }}">
    <title>Document</title>
</head>

<body>

    <div class="container bar-container">
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/imagem2.jpeg') }}" alt="ISTP Logo" style="height: 80px;">
            </a>
        </div>

        <nav class="nav-center">
            <a href="{{ url('/settings') }}">Inicio</a>
            <a href="{{ route('user.edit') }}">Caderneta</a>
            @auth
                @if (Auth::user()->user_type == 10)
                    <a href="{{ route('pay') }}">Pagamento</a>
                @endif
            @endauth
            <a href="{{ url('staionery') }}">Papelaria</a>
            <a href="{{ url('grade') }}">Avaliações</a>
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

    @yield('content')

</body>
</html>
