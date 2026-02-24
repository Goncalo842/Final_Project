@extends('layout.fe_settings')
@section('content')
    <style>
        :root {
            --light-bg: #f5f5f7;
            --text-dark: #1d1d1f;
            --accent-gray: #86868b;
        }

        body {
            background-color: var(--light-bg);
            margin: 0;
            padding: 0;
            color: var(--text-dark);
            overflow-x: hidden;
            width: 100%;
        }

        .full-screen-container {
            width: 100vw;
            margin: 0;
            padding: 0;
        }

        .hero-apple {
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: #f5f5f7;
        }

        .hero-bg-text {
            position: absolute;
            font-size: 28vw;
            font-weight: 800;
            color: rgba(0, 0, 0, 0.03);
            z-index: 1;
            line-height: 0.8;
            text-align: center;
            width: 100%;
            pointer-events: none;
        }

        .hero-content-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 90%;
            max-width: 1600px;
            z-index: 2;
            align-items: center;
            gap: 50px;
        }

        .hero-image-main {
            text-align: center;
        }

        .hero-image-main img {
            width: 100%;
            max-width: 700px;
            filter: drop-shadow(0 50px 100px rgba(0, 0, 0, 0.12));
        }

        .hero-text-side h1 {
            font-size: 6rem;
            font-weight: 800;
            line-height: 0.9;
            margin-bottom: 25px;
        }

        .hero-text-side p {
            font-size: 1.3rem;
            color: var(--accent-gray);
            max-width: 500px;
            margin-bottom: 40px;
        }

        .btn-apple {
            display: inline-block;
            padding: 18px 50px;
            border: 1px solid #d2d2d7;
            border-radius: 30px;
            text-decoration: none;
            color: var(--text-dark);
            font-size: 1rem;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-apple:hover {
            background: #fff;
            transform: translateY(-2px);
        }

        .feature-split {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            width: 100%;
            min-height: 80vh;
            background: #fff;
            align-items: center;
        }

        .feature-image-card {
            height: 100%;
            width: 100%;
            background-color: #e8e8e8;
            display: flex;
            align-items: flex-end;
            padding-bottom: 50px;
        }

        .feature-image-card img {
            width: 100%;
            height: 100%;
            max-height: 600px;
            object-fit: contain;
            filter: grayscale(100%);
        }

        .feature-text-overlay {
            padding: 0 10%;
        }

        .feature-text-overlay h2 {
            font-size: 5rem;
            font-weight: 800;
            margin-bottom: 30px;
            color: #1d1d1f;
        }

        .feature-text-overlay p {
            font-size: 1.1rem;
            color: var(--accent-gray);
            line-height: 1.8;
        }

        .magical-section {
            padding: 150px 5%;
            display: flex;
            align-items: center;
            justify-content: space-around;
            background: #f5f5f7;
        }

        .magical-content {
            max-width: 500px;
        }

        .magical-content h2 {
            font-size: 5.5rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 40px;
        }

        .magical-image img {
            width: 100%;
            max-width: 800px;
            transform: rotate(10deg);
        }

        .products-container {
            padding: 100px 5%;
            background: #fff;
        }

        .section-label {
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: var(--accent-gray);
            margin-bottom: 60px;
            text-align: center;
            display: block;
        }

        .products-grid-apple {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .product-card-apple {
            background: #f5f5f7;
            border-radius: 40px;
            padding: 50px 30px;
            text-align: center;
            transition: 0.4s;
        }

        .product-card-apple:hover {
            transform: scale(1.03);
            background: #eee;
        }

        .product-card-apple img {
            width: 90%;
            margin-bottom: 30px;
        }

        .product-card-apple h3 {
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        .apple-price {
            font-weight: 800;
            font-size: 1.4rem;
        }
    </style>

    <div class="full-screen-container">

        <section class="hero-apple">
            <div class="hero-bg-text">ISTP</div>
            <div class="hero-content-wrapper">
                <div class="hero-image-main">
                    <img src="{{ asset('images/fones.png') }}" alt="Fones">
                </div>
                <div class="hero-text-side">
                    <h1>Fones<br>Max</h1>
                    <p>A mais pura essência do som técnico, desenhada para uma clareza absoluta nos teus estudos e projetos
                        no ISTP.</p>
                </div>
            </div>
        </section>

        <section class="feature-split">
            <div class="feature-image-card">
                <img src="{{ asset('images/cadernos.png') }}"
                    alt="Cadernos Premium">
            </div>
            <div class="feature-text-overlay">
                <h2>Cadernos<br>Essenciais</h2>
                <p>Cadernos premium desenvolvidos para os teus apontamentos e projetos académicos. Design funcional que combina qualidade e durabilidade para acompanhar o teu dia a dia no ISTP.</p>
                <a href="{{ route('products') }}" class="btn-apple" style="margin-top: 30px;">Ver Detalhes</a>
            </div>
        </section>

        <div class="products-container">
            <span class="section-label">Novidades & Promoções</span>
            <section class="products-grid-apple">
                @php
                    $produtos = \App\Models\Stock::take(4)->get();
                @endphp
                @foreach ($produtos as $produto)
                    <div class="product-card-apple">
                        <img src="{{ asset($produto->imagem ? 'storage/' . $produto->imagem : 'images/default.png') }}" alt="{{ $produto->nome }}">
                        <h3 class="serif-display">{{ $produto->nome }}</h3>
                        <div class="apple-price">{{ number_format($produto->preco, 2) }}€</div>
                    </div>
                @endforeach
            </section>
        </div>

        <section class="magical-section">
            <div class="magical-content">
                <h2>Descobre<br>Tudo</h2>
                <p>Explora a nossa coleção completa de produtos. Desde headphones premium a acessórios essenciais,
                    encontra tudo o que precisas para elevar a tua experiência.</p>
                <a href="{{ route('stock') }}" class="btn-apple">Ver Todos os Produtos</a>
            </div>
            <div class="magical-image">
                <img src="{{ asset('images/fones.png') }}" alt="Coleção Completa">
            </div>
        </section>
    </div>
@endsection
