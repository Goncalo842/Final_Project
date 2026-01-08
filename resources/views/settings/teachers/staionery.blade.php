@extends('layout.fe_settings')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        :root {
            --primary: #8a4d00;
            --primary-dark: #5a2f00;
            --primary-light: #c17a2f;
            --accent: rgba(138, 77, 0, 0.12);
            --warm: #f6f6f6;
            --ink: #0f172a;
            --shadow-sm: 0 6px 18px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 16px 40px rgba(0, 0, 0, 0.12);
            --shadow-xl: 0 22px 60px rgba(138, 77, 0, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
            color: #1f2937;
            overflow-x: hidden;
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .hero {
            position: relative;
            min-height: 82vh;
            display: flex;
            align-items: center;
            padding: 70px 6%;
            background: linear-gradient(135deg, #e3e2e2 0%, #dcd6d0 38%, rgba(138,77,0,0.06) 60%, #ecebeb 100%);
            border: 1px solid rgba(0,0,0,0.03);
            border-radius: 26px;
            box-shadow: 0 22px 54px rgba(0,0,0,0.06);
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -12%;
            right: 0;
            width: 520px;
            height: 520px;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 35%, rgba(138,77,0,0.22), rgba(0,0,0,0.06) 55%, transparent 75%);
            filter: blur(52px) saturate(1.05);
            opacity: 0.7;
            pointer-events: none;
            z-index: 0;
        }

        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 12% 88%, rgba(0,0,0,0.06), transparent 32%);
            pointer-events: none;
            z-index: 0;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .left,
        .right {
            flex: 1;
        }

        .left {
            padding-right: 50px;
        }

        .hero h1 {
            font-size: clamp(2.6rem, 5vw, 3.9rem);
            font-weight: 500;
            color: var(--ink);
            margin: 12px 0 18px;
            line-height: 1.08;
            text-shadow: 0 8px 28px rgba(0,0,0,0.06);
            letter-spacing: -0.01em;
            animation: fadeInUp 0.8s ease-out;
        }

        .hero h1 .highlight {
            color: var(--primary);
            display: inline-block;
            position: relative;
        }

        .hero h1 .highlight::after {
            content: '';
            position: absolute;
            bottom: 6px;
            left: 0;
            right: 0;
            height: 10px;
            background: linear-gradient(90deg, rgba(138,77,0,0.25), rgba(193,122,47,0.12));
            z-index: -1;
            border-radius: 999px;
        }

        .hero p {
            font-size: clamp(1.04rem, 2vw, 1.2rem);
            color: #374151;
            line-height: 1.8;
            margin: 18px 0 26px;
            animation: fadeInUp 1s ease-out;
            max-width: 640px;
        }

        .premium-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(138,77,0,0.1);
            padding: 9px 14px;
            border-radius: 14px;
            margin-bottom: 14px;
            color: #8a4d00;
            font-weight: 700;
            font-size: 0.85rem;
            border: 1px solid rgba(138,77,0,0.22);
            box-shadow: 0 12px 32px rgba(0,0,0,0.06);
            animation: fadeInUp 0.6s ease-out;
        }

        .subline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            background: rgba(138,77,0,0.08);
            color: #1f2937;
            border-radius: 12px;
            font-weight: 700;
            letter-spacing: 0.01em;
            box-shadow: 0 10px 24px rgba(0,0,0,0.08);
            animation: fadeInUp 0.6s ease-out;
        }

        .hero-meta {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            flex-wrap: wrap;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            background: white;
            border-radius: 14px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(75,85,99,0.14);
            font-weight: 600;
            color: #1f2937;
        }

        .pill i { color: var(--primary); }

        .btn-cta {
            display: inline-block;
            padding: 15px 34px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            font-weight: 800;
            font-size: 1.02rem;
            text-decoration: none;
            border-radius: 14px;
            box-shadow: 0 16px 36px rgba(138,77,0,0.2);
            transition: all 0.3s ease;
            animation: fadeInUp 1.2s ease-out;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(138,77,0,0.2);
        }

        .btn-cta::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(255,255,255,0.18), rgba(255,255,255,0));
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn-cta:hover::before { opacity: 1; }

        .btn-cta:hover {
            color: white;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 22px 48px rgba(138,77,0,0.22);
            border-color: rgba(138,77,0,0.24);
        }

        .btn-cta span {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            animation: fadeInUp 1.4s ease-out;
        }

        .btn-secondary:hover { gap: 12px; color: var(--primary-dark); }

        .notebook-visual {
            position: relative;
            width: 480px;
            max-width: 100%;
            aspect-ratio: 4 / 5;
            display: grid;
            place-items: center;
            z-index: 2;
            animation: floatBottle 4s cubic-bezier(0.4,0.0,0.2,1) infinite;
        }

        .notebook-visual img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 28px;
            box-shadow: 0 28px 60px rgba(0,0,0,0.12);
            border: 1px solid rgba(138,77,0,0.12);
        }

        .floating-note {
            position: absolute;
            bottom: 16px;
            right: -12px;
            background: white;
            padding: 14px 16px;
            border-radius: 16px;
            box-shadow: 0 18px 44px rgba(15,23,42,0.12);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(138,77,0,0.2);
            backdrop-filter: blur(6px);
            animation: floatBottle 5s ease-in-out infinite;
        }

        .floating-note span { font-weight: 700; color: #8a4d00; }

        @keyframes floatBottle {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            35% { transform: translateY(-28px) rotate(-4deg) scale(1.02); }

            65% { transform: translateY(-12px) rotate(3deg); }

            100% { transform: translateY(0px) rotate(0deg); }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 22px;
            padding: 60px 6% 30px;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            background: transparent;
        }

        .feature {
            background: rgba(255, 255, 255, 0.9);
            padding: 26px 22px;
            border-radius: 18px;
            text-align: left;
            box-shadow: 0 14px 30px rgba(0,0,0,0.06);
            transition: all 0.25s ease;
            border: 1px solid rgba(138,77,0,0.1);
            backdrop-filter: blur(8px);
        }

        .feature:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 38px rgba(0,0,0,0.08);
            border-color: rgba(138,77,0,0.2);
            background: #fff;
        }

        .feature .icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, #8a4d00, #c17a2f);
            color: white;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            margin: 0 0 14px;
            box-shadow: 0 8px 20px rgba(138,77,0,0.18);
        }

        .feature h3 {
            font-size: 1.2rem;
            color: #111827;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .feature small {
            color: #4b5563;
            font-size: 0.98rem;
            line-height: 1.6;
        }

        .shop {
            padding: 80px 6% 100px;
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
        }

        .shop::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 52%;
            background: linear-gradient(180deg, rgba(209,213,219,0.14) 0%, transparent 100%);
            pointer-events: none;
            border-radius: 40px;
        }

        .shop-header {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
            z-index: 1;
        }

        .shop-header h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            color: #2d3748;
            margin-bottom: 30px;
            font-weight: 800;
            position: relative;
            display: inline-block;
        }

        .shop-header h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(223, 124, 4, 0.3);
        }

        .category-tabs {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 28px;
        }

        .category-btn {
            padding: 12px 22px;
            background: #ffffff;
            color: #111827;
            border: 1px solid rgba(138,77,0,0.18);
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.98rem;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 10px 24px rgba(0,0,0,0.06);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(8px);
        }

        .category-btn:hover,
        .category-btn.active {
            background: linear-gradient(135deg, #8a4d00, #c17a2f);
            color: #ffffff;
            border-color: rgba(138,77,0,0.26);
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(138,77,0,0.16);
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 28px;
            margin-top: 40px;
            position: relative;
            z-index: 1;
        }

        .card {
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 12px 28px rgba(0,0,0,0.08);
            transition: all 0.25s ease;
            position: relative;
            border: 1px solid rgba(0,0,0,0.06);
            backdrop-filter: blur(8px);
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 36px rgba(0,0,0,0.1);
            border-color: rgba(138,77,0,0.18);
            background: white;
        }

        .tag {
            position: absolute;
            top: 16px;
            left: 16px;
            background: linear-gradient(135deg, #8a4d00, #c17a2f);
            color: white;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.82rem;
            font-weight: 700;
            z-index: 2;
            box-shadow: 0 10px 20px rgba(138,77,0,0.18);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .img-wrap {
            position: relative;
            height: 240px;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(148, 163, 184, 0.08), rgba(255, 255, 255, 0.75));
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .card:hover .img-wrap img {
            transform: scale(1.15) rotate(2deg);
        }

        .hero-decor {
            position: absolute;
            right: 4%;
            top: 6%;
            width: 460px;
            height: 460px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(138,77,0,0.2), rgba(209,213,219,0.35) 35%, rgba(226,232,240,0.08) 60%, transparent 70%);
            filter: blur(8px) saturate(1.04);
            transform: rotate(-8deg);
            z-index: 1;
            pointer-events: none;
            box-shadow: 0 40px 120px rgba(0,0,0,0.06);
        }

        .card .card-body {
            padding: 22px 24px 6px;
            text-align: left;
            width: 100%;
        }

        .card h3 {
            font-size: 1.25rem;
            color: #111827;
            margin-bottom: 10px;
            font-weight: 800;
        }

        .price-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(90deg,#f8f3ec,#f3e7d9);
            color: #8a4d00;
            padding: 7px 12px;
            border-radius: 999px;
            font-weight: 800;
            box-shadow: 0 6px 18px rgba(138,77,0,0.12);
            border: 1px solid rgba(138,77,0,0.18);
            margin-top: 4px;
            font-size: 0.95rem;
        }

        .desc {
            color: #4b5563;
            font-size: 0.98rem;
            line-height: 1.6;
            margin: 10px 0 16px;
            min-height: 48px;
        }

        .actions {
            margin-top: 10px;
            display:flex;
            gap:10px;
            padding: 0 24px 18px;
            width: 100%;
        }

        .btn-view {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex: 1;
            padding: 14px 18px;
            background: linear-gradient(135deg, #8a4d00, #c17a2f);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 800;
            font-size: 0.98rem;
            text-align: center;
            transition: all 0.25s ease;
            box-shadow: 0 8px 20px rgba(138,77,0,0.18);
            position: relative;
            overflow: hidden;
        }

        .btn-buy {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex: 1;
            padding: 14px 16px;
            background: linear-gradient(90deg,#f9fafb,#f3f4f6);
            color: #111827;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 800;
            font-size: 0.98rem;
            border: 1px solid rgba(0,0,0,0.08);
            box-shadow: 0 8px 18px rgba(0,0,0,0.08);
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }

        .btn-buy:hover { transform: translateY(-4px); box-shadow: 0 14px 30px rgba(223,124,4,0.18); }

        .btn-view::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .btn-view:hover::before {
            left: 100%;
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(223, 124, 4, 0.4);
        }

        @media (max-width: 1024px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding: 40px 5%;
            }

            .left {
                padding-right: 0;
                margin-bottom: 40px;
            }

            .products {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 30px;
            }
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .features {
                grid-template-columns: 1fr;
                padding: 60px 5%;
                gap: 25px;
            }

            .products {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .category-tabs {
                gap: 10px;
            }

            .category-btn {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .btn-cta {
                padding: 14px 30px;
                font-size: 1rem;
            }

            .shop-header h2 {
                font-size: 1.8rem;
            }

            .card .card-body { padding: 20px; }
        }
    </style>

    <canvas id="particles"></canvas>

    <section class="hero" aria-label="Hero banner">
        <div class="container" style="display: flex; align-items: center; justify-content: space-between; width: 100%; gap: 40px;">
            <div class="left">
                <div class="premium-badge">
                    <i class="fas fa-star"></i>
                    <span>LANÇAMENTO 2026</span>
                </div>
                <div class="subline">
                    <i class="fas fa-feather-alt"></i>
                    Papel 100 g/m², textura sedosa
                </div>
                <h1>Cadernos de <span class="highlight">papel premium</span> para estudar com estilo</h1>
                <p>Páginas que não marcam, capas com detalhe dourado e abertura 180° para anotações impecáveis. Um caderno que acompanha seu ritmo e eleva cada página.</p>
                <div style="display:flex;gap:15px;align-items:center;margin-top:30px;flex-wrap:wrap;">
                    <a href="{{ route('products') }}" class="btn-cta">
                        <span>
                            <i class="fas fa-shopping-cart"></i>
                            VER MODELOS
                        </span>
                    </a>
                    <a href="{{ route('products') }}" class="btn-secondary">
                        <span>Ver reviews</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="hero-meta">
                    <div class="pill"><i class="fas fa-leaf"></i><span>Papel certificado FSC</span></div>
                    <div class="pill"><i class="fas fa-star"></i><span>4.9/5 por estudantes</span></div>
                    <div class="pill"><i class="fas fa-pen-ruler"></i><span>Abertura 180°</span></div>
                </div>
            </div>
            <div class="hero-decor" aria-hidden="true"></div>
            <div class="notebook-visual" aria-hidden="true">
                <img src="{{ asset('images/default.png') }}" alt="Caderno premium" loading="lazy">
                <div class="floating-note">
                    <i class="fas fa-book-open"></i>
                    <span>Papel 100 g/m²</span>
                </div>
            </div>
        </div>
    </section>

    <section class="shop" aria-label="Shop">
        <div class="shop-header">
            <h2>Nossa Coleção Exclusiva</h2>
            <div class="category-tabs">
                <button class="category-btn active" onclick="filterProducts('all', this)">
                    <i class="fas fa-th-large"></i>
                    <span>Todos</span>
                </button>
                <button class="category-btn" onclick="filterProducts('cadernos', this)">
                    <i class="fas fa-book"></i>
                    <span>Cadernos</span>
                </button>
                <button class="category-btn" onclick="filterProducts('kits', this)">
                    <i class="fas fa-layer-group"></i>
                    <span>Kits</span>
                </button>
                <button class="category-btn" onclick="filterProducts('acessorios', this)">
                    <i class="fas fa-pen"></i>
                    <span>Acessórios</span>
                </button>
            </div>
        </div>

        <div class="products" role="list">
            <article class="card" role="listitem" data-category="cadernos">
                <div class="img-wrap">
                    <img src="{{ asset('images/default.png') }}" alt="Caderno minimalista">
                </div>
                <div class="card-body">
                        <h3>Caderno Dot Grid A5</h3>
                        <p class="desc">Costura exposta, abertura 180°, ideal para mapas mentais e bullet journal</p>
                        <div class="price-badge">€ 18.90</div>
                </div>
                <div class="actions">
                        <a href="{{ route('products') }}" class="btn-buy">
                            <i class="fas fa-cart-plus"></i>
                            Comprar
                        </a>
                        <a href="{{ route('stock') }}" class="btn-view">
                            <span>Ver detalhes</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                </div>
            </article>

            <article class="card" role="listitem" data-category="kits">
                <div class="tag">
                    <i class="fas fa-star"></i>
                    <span>KIT</span>
                </div>
                <div class="img-wrap">
                    <img src="{{ asset('images/default.png') }}" alt="Kit de estudo premium">
                </div>
                <div class="card-body">
                    <h3>Kit Estudo Signature</h3>
                    <p class="desc">Caderno capa dura, bloco pautado e marcador em dourado para sua rotina</p>
                    <div class="price-badge">€ 42.00</div>
                </div>
                <div class="actions">
                    <a href="{{ route('products') }}" class="btn-buy">
                        <i class="fas fa-cart-plus"></i>
                        Comprar
                    </a>
                    <a href="{{ route('stock') }}" class="btn-view">
                        <span>Ver detalhes</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </article>

            <article class="card" role="listitem" data-category="acessorios">
                <div class="img-wrap">
                    <img src="{{ asset('images/default.png') }}" alt="Estojo minimalista">
                </div>
                <div class="card-body">
                    <h3>Estojo Canvas Minimal</h3>
                    <p class="desc">Compartimentos inteligentes, lona resistente e zíper dourado</p>
                    <div class="price-badge">€ 16.50</div>
                </div>
                <div class="actions">
                    <a href="{{ route('products') }}" class="btn-buy">
                        <i class="fas fa-cart-plus"></i>
                        Comprar
                    </a>
                    <a href="{{ route('stock') }}" class="btn-view">
                        <span>Ver detalhes</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </article>
        </div>
    </section>

    <script>
        window.addEventListener('load', () => {
            const canvas = document.getElementById("particles");
            const ctx = canvas.getContext("2d");

            function resizeCanvas() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }

            resizeCanvas();
            window.addEventListener('resize', resizeCanvas);

            const particles = [];
            const totalParticles = 80;

            class Particle {
                constructor() {
                    this.x = Math.random() * canvas.width;
                    this.y = Math.random() * canvas.height;
                    this.vx = (Math.random() - 0.5) * 1.5;
                    this.vy = (Math.random() - 0.5) * 1.5;
                    this.radius = 3;
                }

                move() {
                    this.x += this.vx;
                    this.y += this.vy;
                    if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                    if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
                }

                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                    ctx.fillStyle = "rgba(255, 255, 255, 0.6)";
                    ctx.fill();
                }
            }

            for (let i = 0; i < totalParticles; i++) {
                particles.push(new Particle());
            }

            function connectParticles() {
                for (let a = 0; a < totalParticles; a++) {
                    for (let b = a + 1; b < totalParticles; b++) {
                        let dx = particles[a].x - particles[b].x;
                        let dy = particles[a].y - particles[b].y;
                        let distance = Math.sqrt(dx * dx + dy * dy);

                        if (distance < 150) {
                            ctx.beginPath();
                            ctx.moveTo(particles[a].x, particles[a].y);
                            ctx.lineTo(particles[b].x, particles[b].y);
                            ctx.strokeStyle = `rgba(255, 255, 255, ${0.3 * (1 - distance / 150)})`;
                            ctx.stroke();
                        }
                    }
                }
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                for (let p of particles) {
                    p.move();
                    p.draw();
                }
                connectParticles();
                requestAnimationFrame(animate);
            }

            animate();
        });

        function filterProducts(category, el) {
            const cards = document.querySelectorAll('.card');
            const buttons = document.querySelectorAll('.category-btn');

            buttons.forEach(btn => btn.classList.remove('active'));
            if (el) el.classList.add('active');

            cards.forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.6s ease-out';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
@endsection

