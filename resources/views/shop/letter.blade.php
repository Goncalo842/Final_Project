@extends('layout.fe_settings')
@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-weight: 400 !important;
        }

        :root {
            --card-bg: #ffffff;
            --text-primary: #1d1d1f;
            --text-secondary: #86868b;
            --accent: #000000;
            --border-radius: 20px;
        }

        body {
            background: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
            position: relative;
        }

        #particles-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        .shop-hero {
            position: relative;
            height: 300px;
            background: linear-gradient(135deg, #2d3436 0%, #636e72 50%, #2d3436 100%);
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: -40px;
            z-index: 2;
        }

        .shop-hero h1 {
            font-size: clamp(5rem, 15vw, 10rem);
            color: #fff;
            font-weight: 800;
            letter-spacing: -5px;
            margin: 0;
        }

        .shop-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px 80px;
            position: relative;
            z-index: 3;
        }

        .search-wrapper {
            background: #fff;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 40px;
            gap: 20px;
        }

        .search-wrapper h2 {
            font-size: 1.1rem;
            font-weight: 400;
            margin: 0;
            white-space: nowrap;
        }

        .search-input-group {
            display: flex;
            background: #f5f5f7;
            border-radius: 10px;
            padding: 5px 15px;
            flex: 1;
            max-width: 600px;
        }

        .search-input-group input {
            border: none;
            background: transparent;
            padding: 10px;
            width: 100%;
            outline: none;
            font-family: inherit;
        }

        .btn-search {
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 8px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 400;
            transition: 0.3s;
        }

        .btn-search:hover {
            opacity: 0.8;
        }

        .shop-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 40px;
        }

        .category-sidebar {
            background: #fff;
            border-radius: var(--border-radius);
            padding: 30px;
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .filter-section {
            margin-bottom: 30px;
        }

        .filter-section h3 {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: var(--text-secondary);
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .filter-option {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 0;
            cursor: pointer;
        }

        .filter-option input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--accent);
            cursor: pointer;
        }

        .filter-option label {
            font-size: 0.95rem;
            cursor: pointer;
        }

        .price-inputs {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 15px;
        }

        .price-field {
            width: 100%;
            padding: 10px;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            font-size: 0.9rem;
            outline: none;
        }

        .btn-action {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-weight: 400;
            cursor: pointer;
            border: none;
            transition: 0.3s;
        }

        .btn-apply {
            background: var(--accent);
            color: #fff;
            margin-bottom: 10px;
        }

        .btn-clear {
            background: #f5f5f7;
            color: var(--text-primary);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .product-card {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 25px;
            transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .product-card.hidden {
            display: none !important;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
        }

        .badge-cat {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #f5f5f7;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 400;
            color: var(--text-secondary);
            text-transform: uppercase;
        }

        .image-box {
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .image-box img {
            max-height: 100%;
            max-width: 90%;
            object-fit: contain;
        }

        .product-info h3 {
            font-size: 1.15rem;
            font-weight: 400;
            margin-bottom: 15px;
            color: var(--text-primary);
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 15px;
            border-top: 1px solid #f5f5f7;
        }

        .price-val {
            font-size: 1.4rem;
            font-weight: 600;
        }

        .btn-buy-now {
            background: var(--accent);
            color: #fff;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 400;
            transition: 0.3s;
        }

        .btn-buy-now:hover {
            background: #333;
        }

        @media (max-width: 1024px) {
            .shop-layout {
                grid-template-columns: 1fr;
            }

            .shop-hero h1 {
                font-size: 5rem;
            }
        }
    </style>

    <canvas id="particles-canvas"></canvas>

    <section class="shop-hero">
        <h1>LOJA</h1>
    </section>

    <div class="shop-container">
        <div class="search-wrapper">
            <h2>Tudo o que precisas</h2>
            <div class="search-input-group">
                <i class="fas fa-search" style="align-self: center; color: #999;"></i>
                <input type="text" id="shop-search" placeholder="Pesquisar produtos pelo nome...">
            </div>
            <button class="btn-search" onclick="applyFilters()">Pesquisar</button>
        </div>

        <div class="shop-layout">
            <aside class="category-sidebar">
                <div class="filter-section">
                    <h3>Categorias</h3>
                    @foreach (['Headphones', 'Auriculares', 'Acessórios', 'Eletrónicos'] as $cat)
                        <div class="filter-option">
                            <input type="checkbox" class="cat-checkbox" id="cat-{{ $loop->index }}"
                                data-filter="{{ $cat }}">
                            <label for="cat-{{ $loop->index }}">{{ $cat }}</label>
                        </div>
                    @endforeach
                </div>

                <div class="filter-section">
                    <h3>Preço</h3>
                    <div class="price-inputs">
                        <input type="number" id="min-price" class="price-field" placeholder="Mín">
                        <input type="number" id="max-price" class="price-field" placeholder="Máx">
                    </div>
                    <button class="btn-action btn-apply" onclick="applyFilters()">Aplicar Filtros</button>
                    <button class="btn-action btn-clear" onclick="clearFilters()">Limpar Tudo</button>
                </div>
            </aside>

            <main class="products-area">
                <div class="products-grid" id="main-grid">
                    @foreach ($produtos as $produto)
                        <div class="product-card" data-price="{{ $produto->preco }}" data-category="Eletrónicos"
                            data-name="{{ strtolower($produto->nome) }}">
                            <a href="{{ route('stock.show', $produto->id) }}"
                                style="text-decoration: none; color: inherit;">
                                <div class="image-box">
                                    <img src="{{ asset($produto->imagem ? 'storage/' . $produto->imagem : 'images/default.png') }}"
                                        alt="{{ $produto->nome }}">
                                </div>
                                <div class="product-info">
                                    <h3>{{ $produto->nome }}</h3>

                                    <div class="price-row">
                                        <div class="price-val">{{ number_format($produto->preco, 2, ',', '.') }}€</div>
                                    </div>
                                </div>
                            </a>

                            @auth
                                @if (Auth::user()->user_type == 30)
                                    <div
                                        style="margin-top: 15px; display: flex; gap: 10px; border-top: 1px dashed #eee; padding-top: 10px;">
                                        <a href="{{ route('stock.edit', $produto->id) }}"
                                            style="font-size: 0.75rem; color: var(--text-secondary); text-decoration: none;">Editar</a>
                                        <form method="POST" action="{{ route('stock.destroy', $produto->id) }}"
                                            onsubmit="return confirm('Apagar produto?');">
                                            @csrf @method('DELETE')
                                            <button
                                                style="border:none; background:none; font-size: 0.75rem; color: #ff4d4d; cursor:pointer; padding:0;">Remover</button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    @endforeach
                </div>
            </main>
        </div>
    </div>

    <script>
        function applyFilters() {
            const searchTerm = document.getElementById('shop-search').value.toLowerCase();
            const minPrice = parseFloat(document.getElementById('min-price').value) || 0;
            const maxPrice = parseFloat(document.getElementById('max-price').value) || Infinity;

            const selectedCats = Array.from(document.querySelectorAll('.cat-checkbox:checked'))
                .map(cb => cb.dataset.filter);

            const cards = document.querySelectorAll('.product-card');

            cards.forEach(card => {
                const name = card.dataset.name;
                const price = parseFloat(card.dataset.price);
                const category = card.dataset.category;

                const matchesSearch = name.includes(searchTerm);
                const matchesPrice = price >= minPrice && price <= maxPrice;
                const matchesCategory = selectedCats.length === 0 || selectedCats.includes(category);

                if (matchesSearch && matchesPrice && matchesCategory) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        }

        function clearFilters() {
            document.getElementById('shop-search').value = '';
            document.getElementById('min-price').value = '';
            document.getElementById('max-price').value = '';
            document.querySelectorAll('.cat-checkbox').forEach(cb => cb.checked = false);

            const cards = document.querySelectorAll('.product-card');
            cards.forEach(card => card.classList.remove('hidden'));
        }

        document.getElementById('shop-search').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyFilters();
            }
        });

        const canvas = document.getElementById('particles-canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        let particles = [];
        const particleCount = 80;

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.size = Math.random() * 3 + 1;
                this.speedX = Math.random() * 1 - 0.5;
                this.speedY = Math.random() * 1 - 0.5;
            }
            update() {
                this.x += this.speedX;
                this.y += this.speedY;
                if (this.x > canvas.width) this.x = 0;
                if (this.x < 0) this.x = canvas.width;
                if (this.y > canvas.height) this.y = 0;
                if (this.y < 0) this.y = canvas.height;
            }
            draw() {
                ctx.fillStyle = 'rgba(255, 255, 255, 0.6)';
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        function init() {
            particles = [];
            for (let i = 0; i < particleCount; i++) {
                particles.push(new Particle());
            }
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });

            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < 120) {
                        ctx.strokeStyle = `rgba(255, 255, 255, ${0.2 * (1 - distance / 120)})`;
                        ctx.lineWidth = 1;
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.stroke();
                    }
                }
            }

            requestAnimationFrame(animate);
        }

        init();
        animate();

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            init();
        });
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
