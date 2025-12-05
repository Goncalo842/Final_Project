@extends('layout.fe_settings')
@section('content')
    <style>
        :root {
            --orange-600: #d86a09;
            --orange-500: #f07a1a;
            --orange-400: #ff9a3c;
            --light-bg: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
            --text: #222;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --glass: rgba(255, 255, 255, 0.7);
            --accent: rgba(240, 122, 26, 0.12);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--text);
            background: var(--light-bg);
            -webkit-font-smoothing: antialiased
        }

        a {
            color: inherit;
            text-decoration: none
        }

        .hero {
            position: relative;
            min-height: 72vh;
            display: flex;
            align-items: center;
            background-image: url('{{ asset('images/hero.png') }}');
            background-size: cover;
            background-position: center;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            padding: 56px 0;
        }

        .hero-overlay {
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(8, 12, 15, 0.55) 0%, rgba(8, 12, 15, 0.25) 40%, rgba(255, 255, 255, 0.02) 100%);
            position: absolute;
            left: 0;
            top: 0;
        }

        .hero .container {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px;
            display: grid;
            grid-template-columns: 1fr 480px;
            gap: 2.5rem;
            align-items: center;
        }

        .hero .left {
            color: white;
            max-width: 650px;
        }

        .hero h1 {
            font-size: 42px;
            line-height: 1.05;
            margin-bottom: 18px;
            font-weight: 800;
            text-shadow: 0 6px 30px rgba(0, 0, 0, 0.45);
        }

        .hero p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            margin-bottom: 22px;
            max-width: 520px;
        }

        .btn-cta {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(180deg, var(--orange-500), var(--orange-600));
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 700;
            box-shadow: 0 8px 30px rgba(208, 106, 9, 0.25);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(208, 106, 9, 0.35);
        }

        .hero .bottle {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            position: relative;
        }

        .hero .bottle img {
            width: 360px;
            max-width: 100%;
            transform: translateY(10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            border-radius: 18px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0.01));
            transition: transform 0.3s ease;
        }

        .hero .bottle img:hover {
            transform: translateY(10px) scale(1.05);
        }

        .features {
            max-width: 1200px;
            margin: -48px auto 48px;
            padding: 28px 24px;
            display: flex;
            gap: 18px;
            justify-content: space-between;
            align-items: center;
        }

        .feature {
            flex: 1;
            text-align: center;
            background: white;
            padding: 18px;
            border-radius: 14px;
            box-shadow: var(--card-shadow);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            transition: transform 0.3s ease;
        }

        .feature:hover {
            transform: translateY(-5px);
        }

        .feature .icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: var(--orange-400);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            font-weight: 800;
            box-shadow: 0 8px 20px rgba(240, 122, 26, 0.18);
        }

        .feature small {
            font-size: 13px;
            color: #666;
            margin-top: 6px
        }

        .shop {
            max-width: 1200px;
            margin: 48px auto;
            padding: 0 24px 80px;
        }

        .shop-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .shop-header h2 {
            font-size: 20px;
            color: #444;
            font-weight: 700;
            letter-spacing: 0.06em
        }

        .tabs {
            display: flex;
            gap: 18px;
            justify-content: center;
            margin-top: 10px
        }

        .tab {
            padding: 8px 16px;
            border-radius: 999px;
            background: transparent;
            border: 1px solid rgba(0, 0, 0, 0.06);
            font-weight: 600;
            color: #777;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .tab:hover {
            border-color: var(--orange-400);
            color: var(--orange-500);
        }

        .tab.active {
            background: transparent;
            color: var(--orange-600);
            border-color: rgba(240, 122, 26, 0.12);
            box-shadow: 0 6px 20px rgba(240, 122, 26, 0.06)
        }

        .products {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
            margin-top: 28px;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .card .img-wrap {
            width: 220px;
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: linear-gradient(180deg, rgba(240, 122, 26, 0.04), rgba(240, 122, 26, 0.01));
            overflow: hidden
        }

        .card .img-wrap img {
            max-width: 160px;
            max-height: 160px;
            display: block;
            transition: transform 0.3s ease;
        }

        .card:hover .img-wrap img {
            transform: scale(1.1);
        }

        .tag {
            position: absolute;
            top: 14px;
            right: 14px;
            background: var(--orange-600);
            color: white;
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 700;
            box-shadow: 0 6px 20px rgba(208, 106, 9, 0.18)
        }

        .card h3 {
            font-size: 16px;
            font-weight: 800;
            color: #222;
            margin-top: 6px
        }

        .card p.desc {
            font-size: 13px;
            color: #666;
            text-align: center;
            margin: 0 8px
        }

        .price {
            font-weight: 800;
            margin-top: 6px;
            font-size: 18px;
            color: var(--orange-600);
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            width: 100%;
            justify-content: center;
        }

        .btn-outline {
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            background: transparent;
            font-weight: 700;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-outline:hover:not(:disabled) {
            border-color: var(--orange-400);
            color: var(--orange-500);
        }

        .btn-add {
            padding: 10px 18px;
            border-radius: 10px;
            border: none;
            background: var(--orange-500);
            color: white;
            font-weight: 800;
            box-shadow: 0 8px 30px rgba(240, 122, 26, 0.12);
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-add:hover {
            background: var(--orange-600);
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(240, 122, 26, 0.25);
        }

        .btn-view {
            padding: 10px 18px;
            border-radius: 10px;
            border: 1px solid var(--orange-500);
            background: transparent;
            color: var(--orange-500);
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-view:hover {
            background: var(--orange-500);
            color: white;
            transform: translateY(-2px);
        }

        @media (max-width: 1100px) {
            .hero .container {
                grid-template-columns: 1fr 340px
            }

            .products {
                grid-template-columns: repeat(2, 1fr)
            }
        }

        @media (max-width: 760px) {
            .hero {
                min-height: 60vh
            }

            .hero .container {
                grid-template-columns: 1fr;
                padding: 32px
            }

            .features {
                flex-direction: column;
                margin: 8px auto
            }

            .products {
                grid-template-columns: 1fr;
                gap: 16px
            }

            .hero h1 {
                font-size: 28px
            }

            .hero p {
                font-size: 14px
            }
        }

        .muted-note {
            font-size: 12px;
            color: #777;
            margin-top: 8px
        }

        .category-tabs {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .category-btn {
            padding: 12px 24px;
            border: 2px solid var(--orange-400);
            background: transparent;
            color: var(--orange-600);
            border-radius: 25px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .category-btn:hover {
            background: var(--orange-400);
            color: white;
            transform: translateY(-2px);
        }
    </style>

    <canvas id="particles"></canvas>

    <section class="hero" aria-label="Hero banner">
        <div class="hero-overlay" aria-hidden="true"></div>

        <div class="container">
            <div class="left">
                <div
                    style="display:inline-block;background:var(--accent);padding:8px 12px;border-radius:999px;margin-bottom:12px;color:var(--orange-600);font-weight:800;font-size:13px">
                    PREMIUM QUALITY</div>
                <h1>Canetas de escrita suave que inspiram criatividade</h1>
                <p>Descubra nossa seleção premium de canetas - designs ergonômicos, tinta de fluxo contínuo e estilo incomparável para cada momento de escrita.</p>

                <div style="display:flex;gap:12px;align-items:center;margin-top:20px">
                    <a href="{{ route('products') }}" class="btn-cta">COMPRAR AGORA</a>
                    <a href="{{ route('products') }}"
                        style="padding:10px 14px;border-radius:10px;background:rgba(255,255,255,0.12);color:white;font-weight:700;border:1px solid rgba(255,255,255,0.06);transition:all 0.3s ease;">Explorar</a>
                </div>

            </div>

            <div class="bottle" aria-hidden="true">
                <img src="{{ asset('images/caneta.png') }}" alt="Caneta premium">
            </div>
        </div>
    </section>

    <section class="shop" aria-label="Shop">
        <div class="shop-header">
            <h2>Nossas Canetas</h2>
            <div class="category-tabs">
                <button class="category-btn" onclick="filterProducts('all')">Todas</button>
                <button class="category-btn" onclick="filterProducts('e')">Papelaria</button>
                <button class="category-btn" onclick="filterProducts('premium')">Bufete</button>
                <button class="category-btn" onclick="filterProducts('gift')">Impressão</button>
            </div>
        </div>

        <div class="products" role="list">
            <article class="card" role="listitem" aria-label="Caneta Executiva" data-category="executive">
                <div class="img-wrap">
                    <img src="{{ asset('images/caneta.png') }}" alt="Caneta Executiva">
                </div>
                <div style="text-align:center;width:100%">
                    <h3>Caneta Executiva Premium</h3>
                    <p class="desc">Design ergonômico, tinta de fluxo contínuo, acabamento em aço inoxidável - perfeita para reuniões</p>
                </div>
                <div class="actions">
                    <a href="{{ route('letter') }}" class="category-btn">Ver detalhes</a>
                </div>
            </article>

            <article class="card" role="listitem" aria-label="Kit Presente" data-category="gift">
                <div class="tag">MAIS VENDIDO</div>
                <div class="img-wrap">
                    <img src="{{ asset('images/prato.png') }}" alt="Kit de Canetas Presente">
                </div>
                <div style="text-align:center;width:100%">
                    <h3>Kit Presente Elegance</h3>
                    <p class="desc">Conjunto com 3 canetas premium em estojo de madeira - ideal para presentear</p>
                </div>
                <div class="actions">
                    <a href="{{ route('letter') }}" class="category-btn">Ver detalhes</a>
                </div>
            </article>

            <article class="card" role="listitem" aria-label="Caneta Signature" data-category="premium">
                <div class="img-wrap">
                    <img src="{{ asset('images/impressora.png') }}" alt="Caneta Signature">
                </div>
                <div style="text-align:center;width:100%">
                    <h3>Caneta Signature Edition</h3>
                    <p class="desc">Edição limitada com detalhes em ouro 18k, madeira nobre e mecanismo suíço</p>
                </div>
                <div class="actions">
                    <a href="{{ route('letter') }}" class="category-btn">Ver detalhes</a>
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
            ctx.fillStyle = "#ffffff";
            ctx.fill();
        }
    }

    function connectParticles() {
        for (let i = 0; i < totalParticles; i++) {
            for (let j = i + 1; j < totalParticles; j++) {
                let dx = particles[i].x - particles[j].x;
                let dy = particles[i].y - particles[j].y;
                let distance = Math.sqrt(dx * dx + dy * dy);

                if (distance < 150) {
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.strokeStyle = `rgba(255, 255, 255, ${1 - distance/150})`;
                    ctx.lineWidth = 1;
                    ctx.stroke();
                }
            }
        }
    }

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        particles.forEach(p => {
            p.move();
            p.draw();
        });

        connectParticles();

        requestAnimationFrame(animate);
    }

    function initParticles() {
        for (let i = 0; i < totalParticles; i++) {
            particles.push(new Particle());
        }
        animate();
    }

    initParticles();
});

function filterProducts(category) {
    const products = document.querySelectorAll('.card');
    products.forEach(product => {
        if (category === 'all' || product.dataset.category === category) {
            product.style.display = 'flex';
        } else {
            product.style.display = 'none';
        }
    });
}

function viewProduct(productId) {
    window.location.href = `/products/${productId}`;
}
</script>

<style>
canvas#particles {
    position: fixed;
    top: 0;
    left: 0;
    z-index: -1;
    pointer-events: none;
}
</style>

@endsection