@extends('layout.fe_settings')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        :root {
            --primary: #df7c04;
            --primary-dark: #c46d03;
            --primary-light: #e88b1a;
            --accent: rgba(223, 124, 4, 0.1);
            --orange-600: #c46d03;
            --orange-400: #e88b1a;
            --gold: linear-gradient(135deg, #df7c04 0%, #c46d03 100%);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.15);
            --shadow-xl: 0 12px 32px rgba(223, 124, 4, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
            color: #2d3748;
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
            min-height: 85vh;
            display: flex;
            align-items: center;
            padding: 60px 5%;
            background:
                linear-gradient(135deg,
                    rgba(255, 255, 255, 0.95) 0%,
                    rgba(255, 255, 255, 0.95) 67%,
                    rgba(223, 124, 4, 0.15) 67%,
                    rgba(232, 139, 26, 0.15) 100%);
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 40%;
            height: 100%;
            pointer-events: none;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 150px;
            opacity: 0.6;
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
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            color: #2d3748;
            margin: 20px 0;
            line-height: 1.2;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
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
            bottom: 5px;
            left: 0;
            right: 0;
            height: 12px;
            background: rgba(223, 124, 4, 0.2);
            z-index: -1;
            border-radius: 5px;
        }

        .hero p {
            font-size: clamp(1rem, 2vw, 1.25rem);
            color: #718096;
            line-height: 1.8;
            margin: 25px 0;
            animation: fadeInUp 1s ease-out;
        }

        .premium-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            padding: 10px 20px;
            border-radius: 999px;
            margin-bottom: 20px;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
            box-shadow: 0 4px 12px rgba(223, 124, 4, 0.3);
            animation: fadeInUp 0.6s ease-out;
        }

        .btn-cta {
            display: inline-block;
            padding: 16px 40px;
            background: white;
            color: var(--primary);
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
            border-radius: 50px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: fadeInUp 1.2s ease-out;
            position: relative;
            overflow: hidden;
            border: 2px solid transparent;
        }

        .btn-cta::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: var(--primary);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-cta:hover::before {
            width: 400px;
            height: 400px;
        }

        .btn-cta:hover {
            color: white;
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 12px 32px rgba(223, 124, 4, 0.3);
            border-color: var(--primary);
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
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            animation: fadeInUp 1.4s ease-out;
        }

        .btn-secondary:hover {
            gap: 12px;
            color: var(--primary-dark);
        }

        .bottle {
            position: relative;
            animation: floatBottle 3s ease-in-out infinite;
        }

        .bottle img {
            max-width: 100%;
            height: auto;
            filter: drop-shadow(0 20px 40px rgba(223, 124, 4, 0.2));
        }

        @keyframes floatBottle {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(2deg);
            }
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
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            padding: 80px 5%;
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            background: linear-gradient(180deg,
                    rgba(255, 255, 255, 0.5) 0%,
                    rgba(223, 124, 4, 0.05) 100%);
            border-radius: 30px;
        }

        .feature {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: var(--shadow-md);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 2px solid transparent;
            backdrop-filter: blur(10px);
        }

        .feature:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary);
            background: white;
        }

        .feature .icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 20px;
            box-shadow: 0 8px 16px rgba(223, 124, 4, 0.3);
        }

        .feature h3 {
            font-size: 1.5rem;
            color: #2d3748;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .feature small {
            color: #718096;
            font-size: 1rem;
            line-height: 1.6;
        }

        .shop {
            padding: 80px 5% 100px;
            max-width: 1600px;
            margin: 0 auto;
            position: relative;
        }

        .shop::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 50%;
            background:
                linear-gradient(180deg,
                    rgba(223, 124, 4, 0.03) 0%,
                    transparent 100%);
            pointer-events: none;
            border-radius: 50px;
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
            gap: 15px;
            margin-top: 40px;
        }

        .category-btn {
            padding: 12px 30px;
            background: rgba(255, 255, 255, 0.9);
            color: #2d3748;
            border: 2px solid rgba(223, 124, 4, 0.2);
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
        }

        .category-btn:hover,
        .category-btn.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(223, 124, 4, 0.3);
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 40px;
            margin-top: 50px;
            position: relative;
            z-index: 1;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            border: 2px solid rgba(223, 124, 4, 0.1);
            backdrop-filter: blur(10px);
        }

        .card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary);
            background: white;
        }

        .tag {
            position: absolute;
            top: 20px;
            left: 20px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
            z-index: 2;
            box-shadow: 0 4px 12px rgba(223, 124, 4, 0.4);
            animation: pulse 2s infinite;
            display: flex;
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
            height: 280px;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(223, 124, 4, 0.03), rgba(255, 255, 255, 0.5));
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

        .card>div:last-of-type {
            padding: 30px;
        }

        .card h3 {
            font-size: 1.5rem;
            color: #2d3748;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .desc {
            color: #718096;
            font-size: 1rem;
            line-height: 1.6;
            margin: 12px 0 20px;
            min-height: 48px;
        }

        .actions {
            margin-top: 20px;
        }

        .btn-view {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 14px 28px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(223, 124, 4, 0.3);
            position: relative;
            overflow: hidden;
        }

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

            .card>div:last-of-type {
                padding: 20px;
            }
        }
    </style>

    <canvas id="particles"></canvas>

    <section class="hero" aria-label="Hero banner">
        <div class="container" style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
            <div class="left">
                <div class="premium-badge">
                    <i class="fas fa-star"></i>
                    <span>PREMIUM QUALITY</span>
                </div>
                <h1>Canetas de <span class="highlight">escrita suave</span> que inspiram criatividade</h1>
                <p>Descubra nossa seleção premium de canetas - designs ergonômicos, tinta de fluxo contínuo e estilo
                    incomparável para cada momento de escrita.</p>
                <div style="display:flex;gap:15px;align-items:center;margin-top:35px;flex-wrap:wrap;">
                    <a href="{{ route('products') }}" class="btn-cta">
                        <span>
                            <i class="fas fa-shopping-cart"></i>
                            COMPRAR AGORA
                        </span>
                    </a>
                    <a href="{{ route('products') }}" class="btn-secondary">
                        <span>Explorar Coleção</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="bottle" aria-hidden="true">
                <img src="{{ asset('images/caneta.png') }}" alt="Caneta premium" style="max-height:500px;">
            </div>
        </div>
    </section>

    <section class="features" aria-label="Features">
        <div class="feature">
            <div class="icon"><i class="fas fa-check"></i></div>
            <h3>Qualidade Premium</h3>
            <small>Materiais de alta durabilidade e acabamento impecável</small>
        </div>
        <div class="feature">
            <div class="icon"><i class="fas fa-pen-fancy"></i></div>
            <h3>Escrita Suave</h3>
            <small>Ponta de precisão para uma experiência de escrita única</small>
        </div>
        <div class="feature">
            <div class="icon"><i class="fas fa-gift"></i></div>
            <h3>Presente Perfeito</h3>
            <small>Embalagem elegante ideal para presentear</small>
        </div>
    </section>

    <section class="shop" aria-label="Shop">
        <div class="shop-header">
            <h2>Nossa Coleção Exclusiva</h2>
            <div class="category-tabs">
                <button class="category-btn active" onclick="filterProducts('all')">
                    <i class="fas fa-th"></i>
                    <span>Todos</span>
                </button>
                <button class="category-btn" onclick="filterProducts('executive')">
                    <i class="fas fa-book"></i>
                    <span>Papelaria</span>
                </button>
                <button class="category-btn" onclick="filterProducts('premium')">
                    <i class="fas fa-print"></i>
                    <span>Impressões</span>
                </button>
                <button class="category-btn" onclick="filterProducts('gift')">
                    <i class="fas fa-utensils"></i>
                    <span>Comida</span>
                </button>
            </div>
        </div>

        <div class="products" role="list">
            <article class="card" role="listitem" data-category="executive">
                <div class="img-wrap">
                    <img src="{{ asset('images/caneta.png') }}" alt="Caneta Executiva">
                </div>
                <div style="text-align:center;width:100%">
                    <h3>Caneta Executiva Premium</h3>
                    <p class="desc">Design ergonômico, tinta de fluxo contínuo, acabamento em aço inoxidável</p>
                </div>
                <div class="actions">
                    <a href="{{ route('letter') }}" class="btn-view">
                        <span>Ver detalhes</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </article>

            <article class="card" role="listitem" data-category="gift">
                <div class="tag">
                    <i class="fas fa-fire"></i>
                    <span>MAIS VENDIDO</span>
                </div>
                <div class="img-wrap">
                    <img src="{{ asset('images/prato.png') }}" alt="Kit Presente">
                </div>
                <div style="text-align:center;width:100%">
                    <h3>Kit Presente Elegance</h3>
                    <p class="desc">Conjunto com 3 canetas premium em estojo de madeira</p>
                </div>
                <div class="actions">
                    <a href="{{ route('letter') }}" class="btn-view">
                        <span>Ver detalhes</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </article>

            <article class="card" role="listitem" data-category="premium">
                <div class="img-wrap">
                    <img src="{{ asset('images/impressora.png') }}" alt="Caneta Signature">
                </div>
                <div style="text-align:center;width:100%">
                    <h3>Caneta Signature Edition</h3>
                    <p class="desc">Edição limitada com detalhes em ouro 18k e mecanismo suíço</p>
                </div>
                <div class="actions">
                    <a href="{{ route('letter') }}" class="btn-view">
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

        function filterProducts(category) {
            const cards = document.querySelectorAll('.card');
            const buttons = document.querySelectorAll('.category-btn');

            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.closest('.category-btn').classList.add('active');

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