@extends('layout.fe_settings')
@section('content')
    <style>
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
            color: #333;
            line-height: 1.6;
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 100vh;
            padding: 80px 60px 60px;
            position: relative;
            overflow: hidden;
        }

        .section:nth-child(even) {
            flex-direction: row-reverse;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 4rem;
        }

        .section:nth-child(even) .container {
            flex-direction: row-reverse;
        }

        .text-box {
            flex: 1;
            z-index: 2;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transform: translateY(50px);
            opacity: 0;
            transition: all 0.8s ease;
        }

        .text-box.animate {
            transform: translateY(0);
            opacity: 1;
        }

        .text-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .text-box h1 {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            color: #333;
            font-weight: 800;
            position: relative;
        }

        .text-box h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 4px;
            background: #8a4d00;
            border-radius: 2px;
        }

        .text-box p {
            line-height: 1.8;
            color: #333;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            font-weight: 400;
        }

        .custom-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 16px 32px;
            background: #8a4d00;
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(138, 77, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .custom-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .custom-btn:hover::before {
            left: 100%;
        }

        .custom-btn:hover {
            background: #c94e09;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(138, 77, 0, 0.4);
        }

        .image-box {
            flex: 1;
            z-index: 2;
            text-align: center;
            transform: translateX(50px);
            opacity: 0;
            transition: all 0.8s ease;
        }

        .image-box.animate {
            transform: translateX(0);
            opacity: 1;
        }

        .image-wrapper img {
            width: 100%;
            max-width: 500px;
            height: auto;
            display: block;
            transition: all 0.4s ease;
        }

        .shape {
            position: absolute;
            right: -120px;
            width: 800px;
            height: 800px;
            background: #8a4d00;
            border-radius: 50% 40% 60% 30% / 50% 30% 70% 40%;
            z-index: 1;
            animation: move 6s infinite alternate ease-in-out;
            opacity: 0.1;
        }

        .section:nth-child(even) .shape {
            left: -120px;
            right: auto;
        }

        @keyframes move {
            0% {
                transform: scale(1) translateY(0px);
            }

            100% {
                transform: scale(1.05) translateY(25px);
            }
        }

        .service-icon {
            width: 80px;
            height: 80px;
            background: #8a4d00;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 25px rgba(138, 77, 0, 0.3);
            transition: all 0.3s ease;
        }

        .service-icon:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 35px rgba(138, 77, 0, 0.4);
        }

        @media (max-width: 768px) {
            .section {
                padding: 100px 20px 40px;
            }

            .container {
                flex-direction: column;
                gap: 2rem;
            }

            .section:nth-child(even) .container {
                flex-direction: column;
            }

            .text-box {
                padding: 2rem;
            }

            .text-box h1 {
                font-size: 2.2rem;
            }

            .image-wrapper img {
                max-width: 350px;
            }
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .color {
            background: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
        }
    </style>

    <canvas id="particles"></canvas>

    <section class="section" id="papelaria">

        <div class="text-box fade-in">
            <div class="service-icon">
                <i class="fas fa-pen-fancy"></i>
            </div>
            <h1>Papelaria</h1>
            <p>Aqui você encontra todos os materiais de papelaria: canetas, cadernos, marcadores e muito mais para apoiar os
                seus estudos com qualidade e estilo.</p>
            <a href="{{ route('products') }}" class="custom-btn">Ver mais</a>
            <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="image-box fade-in">
            <div class="image-wrapper">
                <img src="{{ asset('images/caneta.png') }}" alt="Impressões">
            </div>
        </div>

        <div class="shape"></div>
    </section>

    <div class="color">
        <section class="section" id="bufete">
            <div class="container">
                <div class="text-box fade-in">
                    <div class="service-icon">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h1>Bufete</h1>
                    <p>No bufete você encontra opções deliciosas de refeições, lanches e bebidas para manter sua energia
                        durante o dia de estudos.</p>
                    <a href="{{ route('drink') }}" class="custom-btn">
                        <span>Ver mais</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="image-box fade-in">
                    <div class="image-wrapper">
                        <img src="{{ asset('images/prato.png') }}" alt="Impressões">
                    </div>
                </div>
            </div>
            <div class="shape"></div>
        </section>
    </div>

    <section class="section" id="impressoes">
        <div class="container">
            <div class="text-box fade-in">
                <div class="service-icon">
                    <i class="fas fa-print"></i>
                </div>
                <h1>Impressões</h1>
                <p>Serviço rápido e prático de impressões e cópias para os seus trabalhos, apostilas e documentos acadêmicos
                    com qualidade profissional.</p>
                <a href="#" class="custom-btn">
                    <span>Ver mais</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="image-box fade-in">
                <div class="image-wrapper">
                    <img src="{{ asset('images/impressora.png') }}" alt="Impressões">
                </div>
            </div>
        </div>
        <div class="shape"></div>
    </section>

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

        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    entry.target.classList.add('animate');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });
    </script>
@endsection
