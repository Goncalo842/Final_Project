@extends('layout.fe_settings')
@section('content')
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Cormorant+Garamond:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --gold: #8a4d00;
            --black: #0A0A0A;
            --dark-charcoal: #1A1A1A;
            --white: #FFFFFF;
            --text-dark: #2C2C2C;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
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
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
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

        .main-title {
            font-family: 'Cinzel', serif;
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--black);
            margin-bottom: 1rem;
            letter-spacing: 1px;
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
            background: linear-gradient(135deg, #f5f5f5, #e0e0e0);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 2rem;
        }

        .product-image {
            max-width: 85%;
            height: auto;
            filter: drop-shadow(0 25px 30px rgba(0, 0, 0, 0.3));
            transform: rotate(5deg);
            transition: transform 0.7s ease;
            z-index: 2;
        }

        .product-image-container:hover .product-image {
            transform: rotate(0deg) scale(1.02);
        }

        .gold-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(212, 175, 55, 0.03) 0%, transparent 70%);
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
            color: var(--gold);
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

        .current-price {
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

        .purchase-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--gold));
            color: var(--white);
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
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
            position: relative;
            overflow: hidden;
        }

        .purchase-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.4);
        }

        .purchase-button:active {
            transform: translateY(1px);
        }

        .purchase-button i {
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

        .detail-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .detail-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .detail-icon {
            font-size: 2.5rem;
            color: var(--gold);
            margin-bottom: 1rem;
        }

        .detail-title {
            font-family: 'Cinzel', serif;
            font-size: 1.2rem;
            margin-bottom: 0.8rem;
            color: var(--black);
        }

        .detail-description {
            color: #666;
            font-size: 1rem;
        }

        .luxury-footer {
            text-align: center;
            padding: 2rem 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            color: #777;
            font-size: 0.9rem;
        }

        .gold-accent {
            position: absolute;
            background: var(--gold);
            opacity: 0.1;
            border-radius: 50%;
        }

        .accent-1 {
            width: 200px;
            height: 200px;
            top: -100px;
            right: -100px;
        }

        .accent-2 {
            width: 150px;
            height: 150px;
            bottom: -75px;
            left: -75px;
        }

        @media (max-width: 1200px) {
            .luxury-product {
                flex-direction: column;
            }

            .product-image-container {
                min-height: 400px;
            }
        }

        @media (max-width: 900px) {
            .luxury-details {
                grid-template-columns: repeat(2, 1fr);
            }

            .main-title {
                font-size: 2.8rem;
            }
        }

        @media (max-width: 600px) {
            .luxury-details {
                grid-template-columns: 1fr;
            }

            .main-title {
                font-size: 2.2rem;
            }

            .product-details {
                padding: 2rem;
            }

            .brand-name {
                font-size: 2rem;
            }

            .current-price {
                font-size: 2rem;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeIn 1s ease forwards;
        }

        .delay-1 {
            animation-delay: 0.2s;
        }

        .delay-2 {
            animation-delay: 0.4s;
        }

        .delay-3 {
            animation-delay: 0.6s;
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
                    <img class="product-image" src="{{ asset('images/caneta.png') }}" alt="Caneta ISTP Premium">
                </div>

                <div class="product-details">
                    <h2 class="brand-name">Caneta ISTP</h2>
                    <p class="product-description">
                        Cada caneta ISTP é meticulosamente fabricada com os mais altos padrões de qualidade, utilizando
                        materiais premium e tecnologia de ponta para garantir uma experiência de escrita excepcional. Para
                        aqueles que apreciam o extraordinário.
                    </p>

                    <div class="features-list">
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-pen-nib"></i></div>
                            <span>Ponta de precisão 0.5mm em ouro 18k</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-weight-hanging"></i></div>
                            <span>Balanceamento perfeito com detalhes em platina</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-infinity"></i></div>
                            <span>Tinta de longa duração com reserva exclusiva</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-gem"></i></div>
                            <span>Acabamento em metal premium com detalhes em diamante</span>
                        </div>
                    </div>

                    <div class="pricing-section">
                        <div class="price-container">
                            <span class="original-price">€499,00</span>
                            <span class="current-price">€399,00</span>
                            <span class="discount-badge">Poupa 20%</span>
                        </div>

                        <a href="#" class="purchase-button">
                            <i class="fas fa-lock"></i> Adquirir Agora
                        </a>

                        <div class="guarantee">
                            <i class="fas fa-shield-alt"></i>
                            <span>Garantia vitalícia | Entrega gratuita | Embalagem presente premium</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="luxury-details">
                <div class="detail-card animate-in delay-2">
                    <div class="detail-icon"><i class="fas fa-award"></i></div>
                    <h3 class="detail-title">Artesanato Excelente</h3>
                    <p class="detail-description">Cada caneta é trabalhada à mão por nossos mestres artesãos, com um
                        processo que leva mais de 100 horas para ser concluído.</p>
                </div>

                <div class="detail-card animate-in delay-2">
                    <div class="detail-icon"><i class="fas fa-feather-alt"></i></div>
                    <h3 class="detail-title">Experiência de Escrita</h3>
                    <p class="detail-description">Equilibrada perfeitamente para uma escrita suave e sem esforço,
                        proporcionando uma experiência de escrita incomparável.</p>
                </div>

                <div class="detail-card animate-in delay-2">
                    <div class="detail-icon"><i class="fas fa-gift"></i></div>
                    <h3 class="detail-title">Embalagem de Luxo</h3>
                    <p class="detail-description">Apresentada em uma caixa de madeira personalizada, forrada a veludo, com
                        certificado de autenticidade numerado.</p>
                </div>
            </section>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const subtitle = document.querySelector('.subtitle');
            const originalText = subtitle.textContent;
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

            const purchaseBtn = document.querySelector('.purchase-button');
            purchaseBtn.addEventListener('mouseover', function() {
                this.style.background = `linear-gradient(135deg, #e6c158, #d4af37)`;
            });

            purchaseBtn.addEventListener('mouseout', function() {
                this.style.background = `linear-gradient(135deg, var(--gold), var(--gold-dark))`;
            });

            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
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
