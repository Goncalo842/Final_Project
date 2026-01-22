@extends('layout.fe_settings')
@section('content')
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Cormorant+Garamond:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #AA7E3F;
            --gold-dark: #8a4d00;
            --black: #0A0A0A;
            --dark-charcoal: #1A1A1A;
            --white: #FFFFFF;
            --text-dark: #2C2C2C;
            --notebook-cover: #1b1b1b;
        }

        body {
            background: linear-gradient(135deg, #f7f7f7, #e6e2e0, #f3f7fb);
            overflow-x: hidden;
            min-height: 100vh;
            font-family: 'Montserrat', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .luxury-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 2rem;
        }

        .luxury-product {
            display: flex;
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            margin-bottom: 4rem;
            min-height: 850px;
            position: relative;
        }

        .product-image-container {
            flex: 1;
            background: radial-gradient(circle at 30% 20%, rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0)),
                linear-gradient(145deg, #f6f6f6 0%, #e3e3e3 50%, #f0f0f0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: visible;
            padding: 2.5rem;
            perspective: 1600px;
        }

        .pause-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--gold);
            color: var(--white);
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(170, 126, 63, 0.3);
            transition: all 0.3s ease;
            z-index: 20;
        }

        .pause-button:hover {
            background: var(--gold-dark);
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(170, 126, 63, 0.4);
        }

        .notebook-container {
            width: 420px;
            height: 580px;
            position: relative;
            transform-style: preserve-3d;
            animation: spin3d-full 7s linear infinite;
        }

        .notebook-container.paused {
            animation-play-state: paused;
        }

        @keyframes spin3d-full {
            from {
                transform: rotateY(9deg) rotateX(10deg);
            }

            to {
                transform: rotateY(360deg) rotateX(5deg);
            }
        }

        .notebook-front {
            position: absolute;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 30% 25%, rgba(255, 255, 255, 0.12), transparent 35%),
                radial-gradient(circle at 70% 65%, rgba(0, 0, 0, 0.2), transparent 45%),
                repeating-linear-gradient(25deg,
                    rgba(255, 255, 255, 0.08) 0px,
                    rgba(255, 255, 255, 0.08) 1px,
                    rgba(0, 0, 0, 0.06) 1px,
                    rgba(0, 0, 0, 0.06) 2px),
                repeating-linear-gradient(25deg,
                    rgba(255, 255, 255, 0.08) 0px,
                    rgba(255, 255, 255, 0.08) 1px,
                    rgba(0, 0, 0, 0.06) 1px,
                    rgba(0, 0, 0, 0.06) 2px),

                linear-gradient(135deg, var(--notebook-cover) 0%, color-mix(in srgb, var(--notebook-cover) 88%, #000) 100%);
            border-radius: 0 20px 20px 0;
            border: 1px solid rgba(255, 255, 255, 0.03);
            box-shadow:
                inset 12px 0 10px rgba(104, 104, 104, 0.5),
                inset -8px 0 15px rgba(104, 104, 104, 0.5),
                25px 35px 90px rgba(104, 104, 104, 0.5);
            transform: translateZ(22px);
        }

        .notebook-front::after {
            content: "";
            position: absolute;
            top: 12px;
            right: 12px;
            bottom: 12px;
            left: 40px;
            border: 2px dashed rgba(255, 255, 255, 0.2);
            border-radius: 3px 12px 12px 3px;
            pointer-events: none;
        }

        .notebook-back::after {
            content: "";
            position: absolute;
            top: 12px;
            left: 12px;
            bottom: 12px;
            right: 40px;
            border: 2px dashed rgba(255, 255, 255, 0.15);
            border-radius: 12px 3px 3px 12px;
            pointer-events: none;
        }

        .notebook-back {
            position: absolute;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 28% 35%, rgba(255, 255, 255, 0.1), transparent 38%),
                radial-gradient(circle at 72% 60%, rgba(0, 0, 0, 0.18), transparent 50%),
                repeating-linear-gradient(30deg,
                    rgba(255, 255, 255, 0.07) 0px,
                    rgba(255, 255, 255, 0.07) 1px,
                    rgba(0, 0, 0, 0.055) 1px,
                    rgba(0, 0, 0, 0.055) 2px),
                repeating-linear-gradient(120deg,
                    rgba(255, 255, 255, 0.045) 0px,
                    rgba(255, 255, 255, 0.045) 1px,
                    rgba(0, 0, 0, 0.045) 1px,
                    rgba(0, 0, 0, 0.045) 2px),
                linear-gradient(135deg, color-mix(in srgb, var(--notebook-cover) 86%, #000) 0%, var(--notebook-cover) 100%);
            border-radius: 20px 0 0 20px;
            border: 1px solid rgba(255, 255, 255, 0.02);
            box-shadow:
                inset -12px 0 10px rgba(104, 104, 104, 0.5),
                inset 8px 0 15px rgba(104, 104, 104, 0.5),
                -25px 35px 90px rgba(104, 104, 104, 0.5);
            transform: rotateY(180deg) translateZ(22px);
        }

        .notebook-pages-side1 {
            position: absolute;
            width: 44px;
            height: 100%;
            right: 0;
            top: 0;
            background: repeating-linear-gradient(180deg,
                #fdfbf7 0px,
                #fdfbf7 2px,
                #e8e6e1 2px,
                #e8e6e1 4px,
                #fdfbf7 4px,
                #fdfbf7 6px,
                #d4d0cb 6px,
                #d4d0cb 8px
            );
            transform: rotateY(90deg) translateZ(5px);
            transform-origin: center;
        }

        .notebook-pages-side2 {
            position: absolute;
            width: 44px;
            height: 100%;
            right: 0;
            top: 0;
            background: var(--notebook-cover);
            transform: rotateY(90deg) translateZ(-398px);
            transform-origin: center;
        }

        .notebook-elastic {
            position: absolute;
            top: 0px;
            bottom: 0px;
            right: 26px;
            width: 14px;
            background: rgb(166, 157, 90);
            box-shadow:
                0 0 0 1px rgba(0, 0, 0, 0.25),
                2px 0 6px rgba(0, 0, 0, 0.35),
                -1px 0 4px rgba(255, 255, 255, 0.08);
            z-index: 18;
            display: block;
            pointer-events: none;
        }

        .notebook-elastic::after {
            content: "";
            position: absolute;
            inset: 6px 3px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.18), rgba(255, 255, 255, 0));
            border-radius: 6px;
            opacity: 0.8;
        }

        .notebook-elastic-back {
            position: absolute;
            left: 50px;
            height: 70px;
            width: 10px;
            background: rgb(166, 157, 90);
            box-shadow:
                0 0 0 1px rgba(0, 0, 0, 0.25),
                -2px 0 6px rgba(0, 0, 0, 0.35),
                1px 0 4px rgba(255, 255, 255, 0.08);
            z-index: 18;
            display: block;
            pointer-events: none;
        }

        .notebook-elastic-back.top {
            top: 0px;
        }

        .notebook-elastic-back.bottom {
            bottom: 0px;
        }

        .notebook-logo {
            position: absolute;
            top: 40%;
            left: 55%;
            transform: translate(-50%, -50%);
            font-family: 'Cinzel', serif;
            font-size: 3.5rem;
            font-weight: 900;
            color: rgba(255, 255, 255, 0.1);
            text-shadow:
                -1px -1px 1px rgba(0, 0, 0, 0.5),
                1px 1px 1px rgba(255, 255, 255, 0.3);
            letter-spacing: 4px;
            pointer-events: none;
            text-align: center;
        }

        .notebook-logo.gold-foil {
            color: transparent;
            background: linear-gradient(135deg, #d4af37 0%, #f9f295 50%, #aa8e28 100%);
            -webkit-background-clip: text;
            background-clip: text;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .notebook-tagline {
            position: absolute;
            bottom: 35%;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.7);
            letter-spacing: 1px;
            font-weight: 300;
            text-align: center;
            line-height: 1.4;
            z-index: 10;
        }

        .notebook-tagline-first {
            font-size: 1rem;
        }

        .notebook-tagline-second {
            font-size: 1.2rem;
            margin-top: 2px;
        }

        .product-details {
            flex: 1;
            padding: 4rem 3rem;
            background: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            position: relative;
        }

        .brand-name {
            font-family: 'Cinzel', serif;
            font-size: 2.5rem;
            color: var(--gold);
            margin-bottom: 1.5rem;
            letter-spacing: 2px;
            position: relative;
            display: inline-block;
        }

        .brand-name::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 2px;
            background: var(--gold);
        }

        .product-description {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            line-height: 1.8;
            color: #555;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .feature-icon {
            width: 28px;
            height: 28px;
            background: var(--gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            margin-right: 1rem;
            font-size: 0.9rem;
        }

        .price-container {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .original-price {
            font-size: 1.5rem;
            color: #999;
            text-decoration: line-through;
            margin-right: 1rem;
        }

        #current-price-display {
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--gold);
            margin-right: 1.5rem;
        }

        .discount-badge {
            background: var(--gold);
            color: var(--white);
            padding: 0.4rem 1rem;
            border-radius: 3px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .purchase-buttons-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .purchase-button,
        .personalize-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 1.2rem 2.5rem;
            border: none;
            border-radius: 2px;
            font-family: 'Cinzel', serif;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            flex-grow: 1;
        }

        .purchase-button {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white);
            box-shadow: 0 5px 15px rgba(170, 126, 63, 0.3);
        }

        .purchase-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(170, 126, 63, 0.4);
        }

        .personalize-button {
            background: var(--white);
            color: var(--gold);
            border: 2px solid var(--gold);
            flex-grow: 1;
        }

        .personalize-button:hover {
            background: var(--gold);
            color: var(--white);
            transform: translateY(-3px);
        }

        .purchase-button i,
        .personalize-button i {
            margin-right: 0.8rem;
        }

        .guarantee {
            display: flex;
            align-items: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #777;
        }

        .guarantee i {
            color: var(--gold);
            margin-right: 0.5rem;
        }

        .luxury-details {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-bottom: 4rem;
        }

        #customizer {
            background: linear-gradient(135deg, #ffffff, #fbf8f3);
            border-radius: 16px;
            border: 1px solid rgba(170, 126, 63, 0.15);
            transform: translateY(8px);
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            pointer-events: none;
            padding: 0 2rem;
            margin: 0;
            transition: max-height 0.65s ease, opacity 0.4s ease, padding 0.4s ease, margin 0.4s ease, transform 0.4s ease;
        }

        #customizer.open {
            max-height: 1600px;
            opacity: 1;
            pointer-events: auto;
            padding: 3.5rem 2.5rem;
            margin: 0 0 4rem 0;
            transform: translateY(0);
        }

        .customizer-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .customizer-header h2 {
            font-family: 'Cinzel', serif;
            font-size: 2.5rem;
            color: var(--gold);
            margin-bottom: 0.4rem;
        }

        .customizer-header p {
            color: #5c5c5c;
        }

        .customizer-meta {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 2.5rem;
        }

        .pill-tag {
            background: rgba(170, 126, 63, 0.12);
            color: var(--gold-dark);
            padding: 0.45rem 0.9rem;
            border-radius: 999px;
            font-size: 0.95rem;
            border: 1px solid rgba(170, 126, 63, 0.2);
        }

        .customizer-options-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .option-block {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #f0f0f0;
        }

        .option-title {
            font-family: 'Cinzel', serif;
            font-size: 1.3rem;
            color: var(--black);
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #eee;
            text-align: center;
        }

        .color-swatch-grid {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 1.2rem;
        }

        .swatch {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.25s ease;
            position: relative;
        }

        .swatch:hover {
            transform: translateY(-4px);
        }

        .swatch.active {
            border: 3px solid var(--gold);
        }

        .finish-button {
            flex: 1;
            padding: 0.95rem 1rem;
            border-radius: 10px;
            border: 1px solid #ddd;
            background: #f7f7f7;
            color: var(--text-dark);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .finish-button.glossy {
            background: linear-gradient(135deg, #fff, #fcefdc);
            color: var(--gold-dark);
            border-color: rgba(170, 126, 63, 0.5);
        }

        .finish-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.06);
        }

        .finish-button.active {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(170, 126, 63, 0.25);
        }

        @media (max-width: 1200px) {
            .luxury-product {
                flex-direction: column;
            }

            .purchase-buttons-group {
                flex-direction: column;
            }
        }

        @media (max-width: 600px) {
            .customizer-options-group {
                flex-direction: column;
                gap: 2rem;
            }
        }
    </style>
    <canvas id="particles"></canvas>

    <div class="luxury-container">
        @if (session('success'))
            <div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px;
            border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px;
            border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <main>
            <section class="luxury-product animate-in delay-1">
                <div class="product-image-container">

                    <button class="pause-button" id="pause-btn" title="Pausar/Retomar">
                        <i class="fas fa-pause"></i>
                    </button>

                    <div class="notebook-container">
                            <div class="notebook-pages-side1"></div>
                            <div class="notebook-pages-side2"></div>

                            <div class="notebook-front">
                                <div class="notebook-elastic"></div>
                                <div class="notebook-logo gold-foil">ISTP</div>
                                <div class="notebook-tagline">
                                    <div class="notebook-tagline-first">O teu futuro</div>
                                    <div class="notebook-tagline-second">começa aqui</div>
                                </div>
                            </div>

                            <div class="notebook-back">
                                <div class="notebook-elastic-back top"></div>
                                <div class="notebook-elastic-back bottom"></div>
                            </div>
                    </div>
                </div>

                <div class="product-details">
                    <h2 class="brand-name">ISTP Notebook Deluxe</h2>
                    <p class="product-description">
                        O Caderno ISTP é uma fusão perfeita de design ergonómico e materiais de topo. Personalize a capa
                        e a espiral para criar um item exclusivo que reflete o seu profissionalismo e bom gosto.
                    </p>

                    <div class="features-list">
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-feather-alt"></i></div>
                            <span>Papel de 100g/m² </span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-layer-group"></i></div>
                            <span>Capa rígida personalizável</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-ruler-combined"></i></div>
                            <span>Formato A5 | 200 páginas numeradas</span>
                        </div>
                    </div>

                    <div class="pricing-section">
                        <div class="price-container">
                            <span class="original-price">€15,00</span>
                            <span id="current-price-display">€12,00</span>
                            <span class="discount-badge">Lançamento -20%</span>
                        </div>

                        <div class="purchase-buttons-group">
                            <button type="button" class="personalize-button" id="toggle-customizer-btn">
                                <i class="fas fa-brush"></i> Personalizar
                            </button>
                            <form action="{{ route('caderno.adquirir') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="preco" value="12">
                                <button type="submit" class="purchase-button">
                                    <i class="fas fa-lock"></i> Adquirir (€12,00)
                                </button>
                            </form>
                        </div>

                        <div class="guarantee">
                            <i class="fas fa-star-of-life"></i>
                            <span>Saldo Atual: €{{ number_format(Auth::user()->saldo, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </section>

            <section id="customizer" class="animate-in delay-2" aria-expanded="false">
                <div class="customizer-header">
                    <h2>Selecione o Seu Acabamento</h2>
                    <p>Ajuste as cores da capa, o tipo de espiral e acabamentos premium.</p>
                </div>

                <div class="customizer-meta">
                    <span class="pill-tag"><i class="fas fa-clock"></i> Produção em 48h</span>
                    <span class="pill-tag"><i class="fas fa-recycle"></i> Materiais FSC</span>
                    <span class="pill-tag"><i class="fas fa-shield-alt"></i> Garantia de cor</span>
                </div>

                <div class="customizer-options-group">
                    <div class="option-block">
                        <div class="option-title">Cor da Capa</div>
                        <div class="color-swatch-grid" id="cover-options">
                            <div class="swatch active" style="background-color: #1b1b1b;" data-cover-color="#1b1b1b"
                                title="Preto profundo" onclick="setCoverColor(this, 0)"></div>
                            <div class="swatch" style="background-color: #3c3c3c;" data-cover-color="#3c3c3c"
                                title="Cinza grafite" onclick="setCoverColor(this, 0)"></div>
                            <div class="swatch" style="background-color: #4f5968;" data-cover-color="#4f5968"
                                title="Azul aço" onclick="setCoverColor(this, 0)"></div>
                            <div class="swatch" style="background-color: #0f2f26;" data-cover-color="#0f2f26"
                                title="Verde oliva escuro" onclick="setCoverColor(this, 0)"></div>
                            <div class="swatch" style="background-color: #122d4a;" data-cover-color="#122d4a"
                                title="Azul noite" onclick="setCoverColor(this, 0)"></div>
                            <div class="swatch" style="background-color: #7a2e2a;" data-cover-color="#7a2e2a"
                                title="Bordô" onclick="setCoverColor(this, 0)"></div>
                            <div class="swatch" style="background-color: #566b3a;" data-cover-color="#566b3a"
                                title="Verde musgo" onclick="setCoverColor(this, 0)"></div>
                            <div class="swatch" style="background-color: #8f5306;" data-cover-color="#8f5306"
                                title="Couro caramelo" onclick="setCoverColor(this, 0)"></div>
                        </div>
                    </div>

                    <div class="option-block">
                        <div class="option-title">Acabamento da Capa</div>
                        <div class="color-swatch-grid" style="justify-content: space-between;">
                            <button type="button" class="finish-button matte"
                                onclick="setFinish(this, 'fosco')">Fosco</button>
                            <button type="button" class="finish-button glossy"
                                onclick="setFinish(this, 'brilhante')">Brilhante</button>
                        </div>
                        <p style="text-align: center; font-size: 0.9em; margin-top: 10px; color: #777;">Escolha o toque
                            final: elegante fosco ou brilho sofisticado.</p>
                    </div>


                </div>

                <div
                    style="text-align: center; margin-top: 3rem; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
                    <button type="button" class="personalize-button" style="width: 200px;"
                        onclick="toggleCustomizer(false)">
                        <i class="fas fa-eye-slash"></i> Fechar
                    </button>
                    <a href="#" class="purchase-button" style="width: 260px;"
                        onclick="alert('A sua personalização foi adicionada ao carrinho!')">
                        <i class="fas fa-cart-plus"></i> Adicionar Configuração
                    </a>
                </div>

            </section>

            <section class="luxury-details">
                <div class="detail-card animate-in delay-3">
                    <div class="detail-icon"><i class="fas fa-palette"></i></div>
                    <h3 class="detail-title">Design Ilimitado</h3>
                    <p class="detail-description">Escolha entre uma vasta paleta de cores para a capa e o tipo de metal
                        para a espiral, criando um caderno verdadeiramente único.</p>
                </div>

                <div class="detail-card animate-in delay-3">
                    <div class="detail-icon"><i class="fas fa-book-open"></i></div>
                    <h3 class="detail-title">Páginas de Elevada Qualidade</h3>
                    <p class="detail-description">O nosso papel premium oferece a melhor superfície para qualquer tipo de
                        tinta, desde esferográfica a caneta-tinteiro.</p>
                </div>

                <div class="detail-card animate-in delay-3">
                    <div class="detail-icon"><i class="fas fa-gift"></i></div>
                    <h3 class="detail-title">Entrega Cuidada</h3>
                    <p class="detail-description">Cada caderno é inspecionado manualmente e enviado em embalagem protetora
                        de luxo para garantir a perfeição.</p>
                </div>
            </section>
        </main>
    </div>

    <script>
        let currentBasePrice = 12.00;
        let spiralPriceModifier = 0;

        function updatePrice() {
            const finalPrice = currentBasePrice + spiralPriceModifier;
            document.getElementById('current-price-display').textContent = `€${finalPrice.toFixed(2)}`;
        }

        function setActiveSwatch(element) {
            const parentGrid = element.closest('.color-swatch-grid');
            parentGrid.querySelectorAll('.swatch').forEach(swatch => {
                swatch.classList.remove('active');
            });
            element.classList.add('active');
        }

        function setCoverColor(element, priceMod) {
            setActiveSwatch(element);
            const color = element.getAttribute('data-cover-color');
            document.documentElement.style.setProperty('--notebook-cover', color);
            updatePrice();
        }

        function setSpiralColor(element, priceMod) {
            setActiveSwatch(element);
            const color = element.getAttribute('data-spiral-color');
            document.documentElement.style.setProperty('--notebook-spiral', color);
            spiralPriceModifier = priceMod;
            updatePrice();
        }

        function setFinish(button, finish) {
            document.querySelectorAll('.finish-button').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            const model = document.querySelector('.notebook-model');
            if (!model) return;
            if (finish === 'brilhante') {
                model.style.backgroundImage =
                    `
                    linear-gradient(120deg, rgba(255,255,255,0.18), rgba(0,0,0,0.08)),
                    linear-gradient(115deg, rgba(255,255,255,0) 40%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0) 60%),
                    repeating-linear-gradient(45deg, rgba(0,0,0,0.02) 0px, rgba(0,0,0,0.02) 2px, transparent 2px, transparent 4px),
                    repeating-linear-gradient(-45deg, rgba(0,0,0,0.02) 0px, rgba(0,0,0,0.02) 2px, transparent 2px, transparent 4px)`;
            } else {
                model.style.backgroundImage =
                    `
                    linear-gradient(120deg, rgba(255,255,255,0.08), rgba(0,0,0,0.12)),
                    repeating-linear-gradient(45deg, rgba(0,0,0,0.02) 0px, rgba(0,0,0,0.02) 2px, transparent 2px, transparent 4px),
                    repeating-linear-gradient(-45deg, rgba(0,0,0,0.02) 0px, rgba(0,0,0,0.02) 2px, transparent 2px, transparent 4px)`;
            }
        }

        function toggleCustomizer(forceOpen = null) {
            const customizer = document.getElementById('customizer');
            const toggleBtn = document.getElementById('toggle-customizer-btn');
            const willOpen = forceOpen !== null ? forceOpen : !customizer.classList.contains('open');

            if (willOpen) {
                customizer.classList.add('open');
                customizer.setAttribute('aria-expanded', 'true');
                if (toggleBtn) toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i> Ocultar personalização';
                customizer.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            } else {
                customizer.classList.remove('open');
                customizer.setAttribute('aria-expanded', 'false');
                if (toggleBtn) toggleBtn.innerHTML = '<i class="fas fa-brush"></i> Personalizar';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const subtitle = document.querySelector('.subtitle');
            const originalText =
                "Crie o seu legado. O toque inigualável da qualidade onde as suas ideias ganham forma.";
            if (subtitle) {
                subtitle.textContent = '';
                let i = 0;

                function typeWriter() {
                    if (i < originalText.length) {
                        subtitle.textContent += originalText.charAt(i);
                        i++;
                        setTimeout(typeWriter, 50);
                    }
                }
                setTimeout(typeWriter, 1000);
            }

            updatePrice();

            const toggleBtn = document.getElementById('toggle-customizer-btn');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => toggleCustomizer());
            }

            const matteBtn = document.querySelector('.finish-button.matte');
            if (matteBtn) setFinish(matteBtn, 'fosco');

            const goldColor = getComputedStyle(document.documentElement).getPropertyValue('--gold').trim();
            const goldDarkColor = getComputedStyle(document.documentElement).getPropertyValue('--gold-dark').trim();

            document.querySelectorAll('.purchase-button').forEach(btn => {
                btn.addEventListener('mouseover', function() {
                    this.style.background = `linear-gradient(135deg, #e6c158, ${goldColor})`;
                });

                btn.addEventListener('mouseout', function() {
                    this.style.background =
                        `linear-gradient(135deg, ${goldColor}, ${goldDarkColor})`;
                });
            });

            const imageContainer = document.querySelector('.product-image-container');
            const model = document.querySelector('.notebook-model');
            const baseZ = -3;
            const baseY = 2;
            const maxTilt = 7;
            // Controlar pausa/retomada da rotação
            const pauseBtn = document.getElementById('pause-btn');
            const notebookContainer = document.querySelector('.notebook-container');
            let isPaused = false;

            if (pauseBtn && notebookContainer) {
                pauseBtn.addEventListener('click', function() {
                    isPaused = !isPaused;
                    if (isPaused) {
                        notebookContainer.classList.add('paused');
                        pauseBtn.innerHTML = '<i class="fas fa-play"></i>';
                    } else {
                        notebookContainer.classList.remove('paused');
                        pauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
                    }
                });
            }

            if (imageContainer && model) {
                imageContainer.addEventListener('mousemove', (e) => {
                    const rect = imageContainer.getBoundingClientRect();
                    const relX = (e.clientX - rect.left - rect.width / 2) / rect.width;
                    const relY = (e.clientY - rect.top - rect.height / 2) / rect.height;
                    const tiltX = -(relY * maxTilt);
                    const tiltY = relX * maxTilt;
                    model.style.transform =
                        `rotateX(${tiltX}deg) rotateY(${tiltY + baseY}deg) rotateZ(${baseZ}deg) scale(1.02)`;
                });

                imageContainer.addEventListener('mouseleave', () => {
                    model.style.transform = `rotate(${baseZ}deg) perspective(1400px) rotateY(${baseY}deg)`;
                });
            }

            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const selector = this.getAttribute('href');
                    if (!selector || selector === '#') return;
                    e.preventDefault();
                    const targetElement = document.querySelector(selector);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
    <script>
        const canvas = document.getElementById("particles");
        const ctx = canvas.getContext("2d");
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        let particles = [];
        const total = 80;

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
                ctx.fillStyle = "#ffffff";
                ctx.fill();
            }
        }

        function connectParticles() {
            for (let a = 0; a < total; a++) {
                for (let b = a + 1; b < total; b++) {
                    let dx = particles[a].x - particles[b].x;
                    let dy = particles[a].y - particles[b].y;
                    let distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < 150) {
                        ctx.beginPath();
                        ctx.moveTo(particles[a].x, particles[a].y);
                        ctx.lineTo(particles[b].x, particles[b].y);
                        ctx.strokeStyle = "rgba(255,255,255,0.3)";
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

        function init() {
            for (let i = 0; i < total; i++) {
                particles.push(new Particle());
            }
            animate();
        }

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });

        init();
    </script>
@endsection
