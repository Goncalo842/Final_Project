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
            --notebook-spiral: #b5b9c1;
            --notebook-price: 24.99;
            --page-style: repeating-linear-gradient(to bottom, rgba(0, 0, 0, 0.16) 0, rgba(0, 0, 0, 0.16) 1px, transparent 24px);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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

        .luxury-header {
            text-align: center;
            margin-bottom: 4rem;
            position: relative;
            padding: 2rem 0;
        }

        .exclusive-badge {
            display: inline-block;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            color: var(--white);
            padding: 0.8rem 2rem;
            border-radius: 2px;
            font-family: 'Cinzel', serif;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 3px;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            position: relative;
            box-shadow: 0 5px 15px rgba(170, 126, 63, 0.3);
        }

        .exclusive-badge::after {
            content: "";
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .subtitle {
            font-size: 1.4rem;
            color: var(--text-dark);
            max-width: 700px;
            margin: 0 auto;
            font-weight: 300;
            font-style: italic;
        }

        .luxury-product {
            display: flex;
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            margin-bottom: 4rem;
            min-height: 600px;
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
            overflow: hidden;
            padding: 2.5rem;
            perspective: 1400px;
        }

        .notebook-model {
            width: 330px;
            height: 460px;
            background-color: var(--notebook-cover);
            background-image:
                linear-gradient(120deg, rgba(255, 255, 255, 0.08), rgba(0, 0, 0, 0.12)),
                repeating-linear-gradient(45deg, rgba(0, 0, 0, 0.02) 0px, rgba(0, 0, 0, 0.02) 2px, transparent 2px, transparent 4px),
                repeating-linear-gradient(-45deg, rgba(0, 0, 0, 0.02) 0px, rgba(0, 0, 0, 0.02) 2px, transparent 2px, transparent 4px);
            border-radius: 5px 18px 18px 5px;
            box-shadow:
                inset 3px 0 6px rgba(0, 0, 0, 0.22),
                inset -2px 0 6px rgba(255, 255, 255, 0.12),
                16px 22px 44px rgba(0, 0, 0, 0.42);
            position: relative;
            transform: rotate(-3deg) perspective(1400px) rotateY(2deg);
            transition: transform 0.4s ease, background-color 0.4s, box-shadow 0.4s ease;
            z-index: 10;
            overflow: hidden;
        }

        .notebook-model::after {
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

        .product-image-container:hover .notebook-model {
            box-shadow:
                inset 3px 0 6px rgba(0, 0, 0, 0.22),
                20px 26px 52px rgba(0, 0, 0, 0.36);
        }

        .notebook-spiral-side {
            position: absolute;
            left: -15px;
            top: 20px;
            bottom: 20px;
            width: 30px;
            background: transparent;
            z-index: 20;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 5px 0;
        }

        .spiral-ring {
            width: 100%;
            height: 12px;
            background: linear-gradient(90deg,
                    rgba(0, 0, 0, 0.5) 0%,
                    var(--notebook-spiral) 20%,
                    white 50%,
                    var(--notebook-spiral) 80%,
                    rgba(0, 0, 0, 0.5) 100%);
            border-radius: 6px;
            box-shadow: 0 2px 3px rgba(0, 0, 0, 0.3);
            margin-bottom: 8px;
        }

        .notebook-pages {
            position: absolute;
            right: -12px;
            top: 10px;
            bottom: 10px;
            width: 15px;
            background: repeating-linear-gradient(90deg, #fdfbf7, #e8e6e1 1px, #fdfbf7 2px);
            border-radius: 0 5px 5px 0;
            box-shadow: inset 2px 0 5px rgba(0, 0, 0, 0.1), 3px 3px 5px rgba(0, 0, 0, 0.1);
            z-index: 5;
            transform: translateZ(-2px);
        }

        .notebook-pages-bottom {
            position: absolute;
            bottom: -12px;
            left: 10px;
            right: 0;
            height: 15px;
            background: repeating-linear-gradient(180deg, #fdfbf7, #e8e6e1 1px, #fdfbf7 2px);
            border-radius: 0 0 5px 15px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1), 3px 3px 5px rgba(0, 0, 0, 0.1);
            transform: skewX(45deg);
            z-index: 4;
            width: 98%;
        }

        .notebook-elastic {
            position: absolute;
            top: -2px;
            bottom: -2px;
            right: 40px;
            width: 12px;
            background-color: var(--notebook-cover);
            filter: brightness(0.8);
            box-shadow: 2px 0 4px rgba(0, 0, 0, 0.3);
            z-index: 15;
            display: none;
        }

        .notebook-inner,
        .notebook-spine,
        .page-sheet {
            display: none;
        }

        .notebook-shine {
            position: absolute;
            inset: -10% -30% 20% 30%;
            background: linear-gradient(125deg, rgba(255, 255, 255, 0.18) 0%, rgba(255, 255, 255, 0.02) 35%, rgba(255, 255, 255, 0) 50%);
            mix-blend-mode: screen;
            pointer-events: none;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .notebook-shadow {
            position: absolute;
            width: 420px;
            height: 120px;
            background: radial-gradient(ellipse at center, rgba(0, 0, 0, 0.28) 0%, rgba(0, 0, 0, 0) 70%);
            filter: blur(12px);
            opacity: 0.6;
            transform: translateY(120px) rotate(-3deg);
            z-index: 1;
            pointer-events: none;
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

        .product-image {
            display: none;
        }

        .gold-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(170, 126, 63, 0.03) 0%, transparent 70%);
            pointer-events: none;
        }

        .product-details {
            flex: 1;
            padding: 3rem;
            background: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: center;
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

        .features-list {
            margin-bottom: 2.5rem;
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

        .pricing-section {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding-top: 2rem;
            margin-top: auto;
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
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
        }

        .personalize-button:hover {
            background: var(--gold);
            color: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
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
            box-shadow: 0 18px 55px rgba(0, 0, 0, 0.08);
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
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.04);
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
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.12);
            position: relative;
        }

        .swatch:hover {
            transform: translateY(-4px);
        }

        .swatch.active {
            border: 3px solid var(--gold);
            box-shadow: 0 0 0 5px rgba(170, 126, 63, 0.28);
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
        <main>
            <section class="luxury-product animate-in delay-1">
                <div class="product-image-container">
                    <div class="gold-accent accent-1"></div>
                    <div class="gold-accent accent-2"></div>
                    <div class="gold-overlay"></div>

                    <div class="notebook-shadow"></div>
                    <div class="notebook-model" id="notebook-preview">
                        <div class="notebook-pages-bottom"></div>
                        <div class="notebook-pages"></div>
                        <div class="notebook-elastic"></div>
                        <div class="notebook-spiral-side" id="spiral-preview">
                            @for ($i = 0; $i < 20; $i++)
                                <div class="spiral-ring"></div>
                            @endfor
                        </div>
                        <div class="notebook-shine"></div>
                        <div class="notebook-logo gold-foil">ISTP</div>
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
                            <span>Papel de 100g/m² | Sem sangria de tinta</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-layer-group"></i></div>
                            <span>Capa rígida personalizável (Fosco ou Brilhante)</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-cogs"></i></div>
                            <span>Espiral de Metal Dupla (Gold, Silver ou Black)</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-ruler-combined"></i></div>
                            <span>Formato A5 | 180 páginas numeradas</span>
                        </div>
                    </div>

                    <div class="pricing-section">
                        <div class="price-container">
                            <span class="original-price">€29,99</span>
                            <span id="current-price-display">€24,99</span>
                            <span class="discount-badge">Lançamento</span>
                        </div>

                        <div class="purchase-buttons-group">
                            <button type="button" class="personalize-button" id="toggle-customizer-btn">
                                <i class="fas fa-brush"></i> Personalizar
                            </button>
                            <a href="#" class="purchase-button" onclick="alert('Caderno Padrão Adquirido!')">
                                <i class="fas fa-lock"></i> Adquirir (Padrão)
                            </a>
                        </div>

                        <div class="guarantee">
                            <i class="fas fa-star-of-life"></i>
                            <span>100% Satisfação Garantida | Produção artesanal em Portugal</span>
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
                            <div class="swatch" style="background-color: #4a4a4a;" data-cover-color="#4a4a4a"
                                title="Cinza grafite" onclick="setCoverColor(this, 0)"></div>
                            <div class="swatch" style="background-color: #6b7a8f;" data-cover-color="#6b7a8f"
                                title="Slate urbano" onclick="setCoverColor(this, 0)"></div>
                            <div class="swatch" style="background-color: #0f3b2f;" data-cover-color="#0f3b2f"
                                title="Verde escuro" onclick="setCoverColor(this, 0)"></div>
                            <div class="swatch" style="background-color: #0c1f3f;" data-cover-color="#0c1f3f"
                                title="Azul noite" onclick="setCoverColor(this, 0)"></div>
                            <div class="swatch" style="background-color: #c0392b;" data-cover-color="#c0392b"
                                title="Vermelho rubi" onclick="setCoverColor(this, 0)"></div>
                            <div class="swatch" style="background-color: #27ae60;" data-cover-color="#27ae60"
                                title="Verde clássico" onclick="setCoverColor(this, 0)"></div>
                            <div class="swatch" style="background-color: #8e44ad;" data-cover-color="#8e44ad"
                                title="Roxo profundo" onclick="setCoverColor(this, 0)"></div>
                            <div class="swatch" style="background-color: #ff9f43;" data-cover-color="#ff9f43"
                                title="Âmbar" onclick="setCoverColor(this, 0)"></div>
                            <div class="swatch" style="background-color: #00bcd4;" data-cover-color="#00bcd4"
                                title="Turquesa" onclick="setCoverColor(this, 0)"></div>
                        </div>
                    </div>

                    <div class="option-block">
                        <div class="option-title">Acabamento da Espiral</div>
                        <div class="color-swatch-grid" id="spiral-options">
                            <div class="swatch active" style="background-color: #b5b9c1;" data-spiral-color="#b5b9c1"
                                data-price-modifier="0" title="Aço escovado" onclick="setSpiralColor(this, 0)"></div>
                            <div class="swatch" style="background-color: #4c4c4c;" data-spiral-color="#4c4c4c"
                                data-price-modifier="0" title="Grafite fosco" onclick="setSpiralColor(this, 0)"></div>
                            <div class="swatch" style="background-color: #b08d57;" data-spiral-color="#b08d57"
                                data-price-modifier="3.00" title="Bronze quente" onclick="setSpiralColor(this, 3.00)">
                            </div>
                            <div class="swatch" style="background-color: #8a6a46;" data-spiral-color="#8a6a46"
                                data-price-modifier="4.00" title="Cobre envelhecido"
                                onclick="setSpiralColor(this, 4.00)"></div>
                        </div>
                        <p style="text-align: center; font-size: 0.9em; margin-top: 10px; color: #777;">Metais naturais sem
                            acréscimo | Bronze +€3.00 | Cobre +€4.00</p>
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
        let currentBasePrice = 24.99;
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

            // Atualiza visual do acabamento
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

        function setPageStyle(type) {}

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
