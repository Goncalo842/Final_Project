@extends('layout.fe_settings')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
                transform: translateX(400px);
            }
        }

        :root {
            --accent-gold: #AA7E3F;
            --text-main: #1d1d1f;
            --text-muted: #86868b;
            --notebook-cover: #1b1b1b;
            --bg-light: #f5f5f7;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-main);
            font-family: 'Montserrat', sans-serif;
            margin: 0;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 60px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 100px;
            align-items: center;
        }

        .visual-container {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            perspective: 1600px;
            height: 700px;
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
            background: radial-gradient(circle at 30% 25%, rgba(255, 255, 255, 0.12), transparent 35%), radial-gradient(circle at 70% 65%, rgba(0, 0, 0, 0.2), transparent 45%), repeating-linear-gradient(25deg, rgba(255, 255, 255, 0.08) 0px, rgba(255, 255, 255, 0.08) 1px, rgba(0, 0, 0, 0.06) 1px, rgba(0, 0, 0, 0.06) 2px), repeating-linear-gradient(25deg, rgba(255, 255, 255, 0.08) 0px, rgba(255, 255, 255, 0.08) 1px, rgba(0, 0, 0, 0.06) 1px, rgba(0, 0, 0, 0.06) 2px), linear-gradient(135deg, var(--notebook-cover) 0%, color-mix(in srgb, var(--notebook-cover) 88%, #000) 100%);
            border-radius: 0 20px 20px 0;
            border: 1px solid rgba(255, 255, 255, 0.03);
            box-shadow: inset 12px 0 10px rgba(104, 104, 104, 0.5), inset -8px 0 15px rgba(104, 104, 104, 0.5), 25px 35px 90px rgba(104, 104, 104, 0.5);
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

        .notebook-back {
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 28% 35%, rgba(255, 255, 255, 0.1), transparent 38%), radial-gradient(circle at 72% 60%, rgba(0, 0, 0, 0.18), transparent 50%), repeating-linear-gradient(30deg, rgba(255, 255, 255, 0.07) 0px, rgba(255, 255, 255, 0.07) 1px, rgba(0, 0, 0, 0.055) 1px, rgba(0, 0, 0, 0.055) 2px), repeating-linear-gradient(120deg, rgba(255, 255, 255, 0.045) 0px, rgba(255, 255, 255, 0.045) 1px, rgba(0, 0, 0, 0.045) 1px, rgba(0, 0, 0, 0.045) 2px), linear-gradient(135deg, color-mix(in srgb, var(--notebook-cover) 86%, #000) 0%, var(--notebook-cover) 100%);
            border-radius: 20px 0 0 20px;
            border: 1px solid rgba(255, 255, 255, 0.02);
            box-shadow: inset -12px 0 10px rgba(104, 104, 104, 0.5), inset 8px 0 15px rgba(104, 104, 104, 0.5), -25px 35px 90px rgba(104, 104, 104, 0.5);
            transform: rotateY(180deg) translateZ(22px);
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

        .notebook-pages-side1 {
            position: absolute;
            width: 44px;
            height: 100%;
            right: 0;
            top: 0;
            background: repeating-linear-gradient(180deg, #fdfbf7 0px, #fdfbf7 2px, #e8e6e1 2px, #e8e6e1 4px, #fdfbf7 4px, #fdfbf7 6px, #d4d0cb 6px, #d4d0cb 8px);
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
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.25), 2px 0 6px rgba(0, 0, 0, 0.35), -1px 0 4px rgba(255, 255, 255, 0.08);
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
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.25), -2px 0 6px rgba(0, 0, 0, 0.35), 1px 0 4px rgba(255, 255, 255, 0.08);
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

        .notebook-logo.gold-foil {
            position: absolute;
            top: 40%;
            left: 55%;
            transform: translate(-50%, -50%);
            font-family: 'Cinzel', serif;
            font-size: 3.5rem;
            font-weight: 900;
            color: transparent;
            background: linear-gradient(135deg, #d4af37 0%, #f9f295 50%, #aa8e28 100%);
            -webkit-background-clip: text;
            background-clip: text;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            letter-spacing: 4px;
            pointer-events: none;
            text-align: center;
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

        .product-header h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3.8rem;
            font-weight: 400;
            margin: 0;
        }

        .price-tag {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            color: var(--accent-gold);
            margin-bottom: 40px;
        }

        .color-selector {
            margin-bottom: 40px;
        }

        .swatches {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .swatch {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
            transition: 0.3s;
        }

        .swatch.active {
            border-color: var(--text-main);
            transform: scale(1.15);
        }

        .btn-buy-apple {
            width: 100%;
            background: var(--text-main);
            color: white;
            border: none;
            padding: 22px;
            border-radius: 40px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-buy-apple:hover {
            background: #333;
            transform: translateY(-2px);
        }

        .pause-control {
            position: absolute;
            bottom: 20px;
            background: white;
            border: 1px solid #ddd;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            transition: 0.3s;
        }

        .pause-control:hover {
            background: #f0f0f0;
        }
    </style>

    <div class="container">
        <div class="product-grid">

            <div class="visual-container">
                <div class="notebook-container" id="notebook">
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

                <button class="pause-control" onclick="toggleAnim()">
                    <i class="fas fa-pause"></i> PAUSAR ROTAÇÃO
                </button>
            </div>

            <div class="info-container">
                <div class="product-header">
                    <span
                        style="color: var(--text-muted); font-size: 13px; text-transform: uppercase; letter-spacing: 2px;">ISTP
                        Signature</span>
                    <h1>Notebook Deluxe</h1>
                    <div class="price-tag">12,00€</div>
                </div>

                <p style="line-height: 1.8; color: #444; font-size: 1.1rem; font-weight: 300;">
                    A união perfeita entre funcionalidade e estética. O caderno ISTP Deluxe oferece uma experiência de
                    escrita inigualável, envolta num design 3D minimalista com acabamentos em folha de ouro.
                </p>

                <div class="color-selector">
                    <span style="font-size: 12px; font-weight: 600; text-transform: uppercase;">Escolher Cor da Capa</span>
                    <div class="swatches">
                        <div class="swatch active" style="background-color: #1b1b1b;" title="Preto profundo"
                            onclick="updateColor('#1b1b1b', this)"></div>
                        <div class="swatch" style="background-color: #3c3c3c;" title="Cinza grafite"
                            onclick="updateColor('#3c3c3c', this)"></div>
                        <div class="swatch" style="background-color: #4f5968;" title="Azul aço"
                            onclick="updateColor('#4f5968', this)"></div>
                        <div class="swatch" style="background-color: #0f2f26;" title="Verde oliva escuro"
                            onclick="updateColor('#0f2f26', this)"></div>
                        <div class="swatch" style="background-color: #122d4a;" title="Azul noite"
                            onclick="updateColor('#122d4a', this)"></div>
                        <div class="swatch" style="background-color: #7a2e2a;" title="Bordô"
                            onclick="updateColor('#7a2e2a', this)"></div>
                        <div class="swatch" style="background-color: #566b3a;" title="Verde musgo"
                            onclick="updateColor('#566b3a', this)"></div>
                        <div class="swatch" style="background-color: #8f5306;" title="Couro caramelo"
                            onclick="updateColor('#8f5306', this)"></div>
                    </div>
                </div>

                <form action="{{ route('caderno.adquirir') }}" method="POST">
                    @csrf
                    <input type="hidden" name="preco" value="12">
                    <button type="submit" class="btn-buy-apple">Adquirir Agora</button>
                </form>

                <div style="margin-top: 30px; text-align: center; color: var(--text-muted); font-size: 0.9rem;">
                    <i class="fas fa-wallet" style="margin-right: 8px;"></i> Saldo Atual:
                    €{{ number_format(Auth::user()->saldo, 2, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div style="position: fixed; top: 100px; right: 20px; z-index: 9999; background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 20px 30px; border-radius: 12px; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3); animation: slideInRight 0.5s ease-out, fadeOut 0.5s ease-in 4.5s forwards; max-width: 400px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-check-circle" style="font-size: 24px;"></i>
                <span style="font-size: 15px; font-weight: 500;">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div style="position: fixed; top: 100px; right: 20px; z-index: 9999; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; padding: 20px 30px; border-radius: 12px; box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3); animation: slideInRight 0.5s ease-out, fadeOut 0.5s ease-in 4.5s forwards; max-width: 400px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-exclamation-circle" style="font-size: 24px;"></i>
                <span style="font-size: 15px; font-weight: 500;">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <script>
        function toggleAnim() {
            const nb = document.getElementById('notebook');
            nb.classList.toggle('paused');
            const btn = event.currentTarget;
            btn.innerHTML = nb.classList.contains('paused') ?
                '<i class="fas fa-play"></i> RETOMAR ROTAÇÃO' :
                '<i class="fas fa-pause"></i> PAUSAR ROTAÇÃO';
        }

        function updateColor(color, el) {
            document.documentElement.style.setProperty('--notebook-cover', color);
            document.querySelectorAll('.swatch').forEach(s => s.classList.remove('active'));
            el.classList.add('active');
        }
    </script>
@endsection
