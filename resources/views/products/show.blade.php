@extends('layout.fe_settings')
@section('content')
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=Montserrat:wght@300;400;600&display=swap"
        rel="stylesheet">

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
            --accent-gold: #8a4d00;
            --text-main: #1d1d1f;
            --text-muted: #86868b;
        }

        body {
            background: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
            color: var(--text-main);
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
        }

        .serif-display {
            font-family: 'Cormorant Garamond', serif;
            text-transform: uppercase;
            letter-spacing: 4px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 60px;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #f5f5f7;
            color: var(--text-main);
            text-decoration: none;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: 0.3s;
            margin-bottom: 20px;
        }

        .btn-back:hover {
            background: #e8e8e8;
            transform: translateX(-3px);
        }
        .breadcrumb {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 40px;
            color: var(--text-muted);
        }

        .breadcrumb a {
            color: var(--text-muted);
            text-decoration: none;
            transition: 0.3s;
        }

        .breadcrumb a:hover {
            color: var(--accent-gold);
        }

        .product-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 80px;
            align-items: start;
        }

        .visual-container {
            position: sticky;
            top: 40px;
        }

        model-viewer {
            width: 100%;
            height: 700px;
            --poster-color: transparent;
            background-color: transparent;
        }

        .info-container {
            padding-top: 20px;
        }

        .product-header h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 4rem;
            font-weight: 300;
            line-height: 1.1;
            margin-bottom: 10px;
            color: var(--text-main);
        }

        .product-ref {
            font-size: 11px;
            letter-spacing: 3px;
            color: var(--text-muted);
            text-transform: uppercase;
            margin-bottom: 30px;
        }

        .price-tag {
            font-size: 2.5rem;
            font-weight: 400;
            margin-bottom: 40px;
            font-family: 'Cormorant Garamond', serif;
        }

        .description-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #444;
            margin-bottom: 40px;
            font-weight: 300;
        }

        .buy-controls {
            border-top: 1px solid #d2d2d7;
            padding-top: 40px;
        }

        .quantity-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            display: block;
        }

        .qty-selector {
            display: flex;
            align-items: center;
            background: #fff;
            width: fit-content;
            border-radius: 30px;
            padding: 5px;
            margin-bottom: 30px;
            border: 1px solid #d2d2d7;
        }

        .qty-selector button {
            background: transparent;
            border: none;
            width: 40px;
            height: 40px;
            cursor: pointer;
            font-size: 18px;
            border-radius: 50%;
            transition: 0.2s;
        }

        .qty-selector button:hover {
            background: #f5f5f7;
        }

        .qty-selector input {
            border: none;
            text-align: center;
            width: 50px;
            font-weight: 600;
            font-size: 16px;
            background: transparent;
        }

        .btn-primary-apple {
            width: 100%;
            background: var(--text-main);
            color: #fff;
            border: none;
            padding: 22px;
            border-radius: 40px;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary-apple:hover {
            background: var(--accent-gold);
            transform: scale(1.02);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2px;
            background: #d2d2d7;
            margin-top: 80px;
            border: 1px solid #d2d2d7;
        }

        .feature-item {
            background: #fff;
            padding: 60px 30px;
            text-align: center;
        }

        .feature-item i {
            font-size: 24px;
            color: var(--accent-gold);
            margin-bottom: 20px;
            display: block;
        }

        .feature-item h4 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.2rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .feature-item p {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        @media (max-width: 1024px) {
            .product-grid {
                grid-template-columns: 1fr;
            }

            .visual-container {
                position: relative;
                top: 0;
            }

            model-viewer {
                height: 500px;
            }

            .product-header h1 {
                font-size: 3rem;
            }
        }
    </style>

    <div class="container">
        <nav class="breadcrumb">
            <a href="/">Início</a> / <a href="{{ route('products') }}">Coleção</a> / <span>{{ $produto->nome }}</span>
        </nav>

        <a href="{{ route('stock') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            Voltar para a Loja
        </a>

        <div class="product-grid">
            <div class="visual-container">
                <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
                <model-viewer src="{{ asset('images/' . $produto->modelo_3d) }}" alt="{{ $produto->nome }}" auto-rotate
                    camera-controls shadow-intensity="0.5" exposure="1">
                </model-viewer>
            </div>

            <div class="info-container">
                <div class="product-header">
                    <div class="product-ref">Ref. {{ $produto->id }} — Série Design</div>
                    <h1>{{ $produto->nome }}</h1>
                </div>

                <div class="price-tag" id="totalPrice">
                    {{ number_format($produto->preco, 2) }}€
                </div>

                <div class="description-text">
                    {{ $produto->descricao }}
                    <br><br>
                    Inspirado na elegância das linhas puras e no compromisso com a excelência técnica. Cada detalhe foi
                    concebido para proporcionar uma experiência sensorial única.
                </div>

                <div class="buy-controls">
                    <span class="quantity-label">Quantidade</span>
                    <div class="qty-selector">
                        <button type="button" onclick="decreaseQty()">–</button>
                        <input type="number" id="quantity" value="1" min="1" readonly>
                        <button type="button" onclick="increaseQty()">+</button>
                    </div>

                    <form method="POST" action="{{ route('produto.adquirir', $produto->id) }}">
                        @csrf
                        <input type="hidden" name="quantity" id="formQuantity" value="1">
                        <button type="submit" class="btn-primary-apple">
                            Adicionar ao Carrinho
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <section class="features-grid">
            <div class="feature-item">
                <i class="fas fa-gem"></i>
                <h4>Qualidade Premium</h4>
                <p>Materiais selecionados para garantir durabilidade e um acabamento impecável.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-leaf"></i>
                <h4>Design Minimalista</h4>
                <p>A harmonia perfeita entre forma e função, focada no essencial.</p>
            </div>
            <div class="feature-item">
                <i class="fas fa-award"></i>
                <h4>Garantia Dupla</h4>
                <p>Controlo de qualidade rigoroso antes de cada envio para sua total confiança.</p>
            </div>
        </section>
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
        const basePrice = {{ $produto->preco }};

        function updatePrice() {
            const qty = parseInt(document.getElementById('quantity').value);
            const total = basePrice * qty;
            document.getElementById('totalPrice').textContent = total.toLocaleString('pt-PT', {
                minimumFractionDigits: 2
            }) + '€';
            document.getElementById('formQuantity').value = qty;
        }

        function increaseQty() {
            let input = document.getElementById('quantity');
            input.value = parseInt(input.value) + 1;
            updatePrice();
        }

        function decreaseQty() {
            let input = document.getElementById('quantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                updatePrice();
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
