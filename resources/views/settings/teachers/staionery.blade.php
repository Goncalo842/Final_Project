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
            color: var(--text-dark);
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
            height: 100vh;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }

        .section:nth-child(even) {
            flex-direction: row-reverse;
        }

        .text-box {
            width: 45%;
            z-index: 2;
        }

        .text-box h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .text-box p {
            line-height: 1.8;
            color: #333;
            font-size: 20px;
            margin-bottom: 30px;
        }

        .custom-btn {
            display: inline-block;
            padding: 14px 28px;
            background: #8a4d00;
            color: white;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 10px;
            transition: 0.3s;
        }

        .custom-btn:hover {
            background: #c94e09;
        }

        .color {
            background: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
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

        .image-box {
            width: 55%;
            z-index: 2;
            text-align: center;
        }

        .image-box img {
            width: 650px;
            height: auto;
            position: relative;
            z-index: 2;
        }
    </style>

    <canvas id="particles"></canvas>

    <section class="section">
        <div class="text-box">
            <h1>Papelaria</h1>
            <p>Aqui você encontra todos os materiais de papelaria: canetas, cadernos, marcadores e muito mais para apoiar os
                seus estudos.</p>
            <a href="{{ route('products') }}" class="custom-btn">Ver mais</a>
        </div>
        <div class="image-box">
            <img src="{{ asset('images/caneta.png') }}" alt="Papelaria">
        </div>
        <div class="shape"></div>
    </section>

    <div class="color">
        <section class="section">
            <div class="text-box">
                <h1>Bufete</h1>
                <p>No bufete você encontra opções deliciosas de refeições, lanches e bebidas para manter sua energia durante
                    o
                    dia.</p>
                <a href="/buffet" class="custom-btn">Ver mais</a>
            </div>
            <div class="image-box">
                <img src="{{ asset('images/prato.png') }}" alt="Bufete">
            </div>
            <div class="shape"></div>
        </section>
    </div>

    <section class="section">
        <div class="text-box">
            <h1>Impressões</h1>
            <p>Serviço rápido e prático de impressões e cópias para os seus trabalhos, apostilas e documentos acadêmicos.
            </p>
            <a href="/impressões" class="custom-btn">Ver mais</a>
        </div>
        <div class="image-box">
            <img src="{{ asset('images/impressora.png') }}" alt="Impressões">
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
    </script>
@endsection
