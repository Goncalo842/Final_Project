<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISTP - University</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<div class="container topbar-container d-flex justify-content-between align-items-center py-3">
    <div class="logo">
    <img src="{{ asset('images/imagem2.jpeg') }}" alt="ISTP Logo" style="height: 80px;">
</div>

    <nav class="nav-center d-flex gap-3">
        <a href="{{ url('/') }}">Sobre</a>
        <a href="{{ url('courses') }}">Cursos</a>
        <a href="{{ url('info') }}">Candidatos</a>
        <a href="{{ url('contact') }}">Contacto</a>
    </nav>

    @if (Route::has('login'))
        <nav class="d-flex align-items-center gap-3">
            @auth
                <div class="dropdown">
                    <button class="btn dropdown-toggle account-button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('images/login.png') }}" alt="Perfil" class="profile-img">
                        {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('settings') }}">Conta</a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit">Sair</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                    <a href="{{ route('login') }}">Entrar</a>
                    <l>/</l>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Registar</a>
                @endif
            @endauth
        </nav>
    @endif
</div>

@yield('content')

<br>
</body>
<script defer src="{{ asset('js/n8n-chat-widget.js') }}"
        data-endpoint="http://localhost:5678/webhook/b663ae95-d857-4d40-a340-514ec557432e"
        data-title="ARIS - Artificial Response Intelligence System"
        data-welcome="Olá! Eu sou a ARIS, a assistente virtual do ISTP Porto. Em que posso ajudar?"
        data-placeholder="Escreva a sua mensagem..." data-position="bottom-right"></script>
</html>
