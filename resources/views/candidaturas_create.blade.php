@extends('layout.fe_master')
@section('content')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css'>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--gradient-accent);
            color: var(--text-dark, #333);
        }

        .candidatura-section {
            padding: 5rem 5%;
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .candidatura-container {
            max-width: 700px;
            width: 100%;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 3rem;
        }

        .section-title-form {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 2rem;
            color: var(--primary-color, #f87808);
            position: relative;
            font-weight: 700;
        }

        .section-title-form::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--primary-color, #f87808);
            border-radius: 2px;
        }

        /* Estilo dos Alertas (Success) */
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
            padding: 1rem;
            margin-top: 1.5rem;
            border-radius: 8px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-color, #f87808);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: var(--primary-color, #f87808);
            box-shadow: 0 0 0 3px rgba(248, 120, 8, 0.2);
            outline: none;
        }

        textarea.form-control {
            resize: vertical;
        }

        .btn-primary {
            background-color: var(--primary-color, #f87808);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(248, 120, 8, 0.4);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark, #cc6207);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(248, 120, 8, 0.6);
        }

        @media (max-width: 768px) {
            .candidatura-container {
                padding: 2rem;
            }
            .section-title-form {
                font-size: 2rem;
            }
        }
    </style>


    <canvas id="particles"></canvas>

    <section class="candidatura-section">
        <div class="candidatura-container">
            <h1 class="section-title-form">Portal de Candidaturas</h1>

            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('candidaturas.store') }}" method="POST" class="mt-4">
                @csrf
                <div class="form-group">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" name="nome" id="nome" class="form-control" placeholder="Digite seu nome" required>
                </div>

                <div class="form-group mt-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Digite seu email" required>
                </div>

                <div class="form-group mt-3">
                    <label for="curriculo" class="form-label">Mensagem / Currículo:</label>
                    <textarea name="curriculo" id="curriculo" class="form-control" rows="5" placeholder="Fale sobre você e por que deseja se candidatar" required></textarea>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Enviar Candidatura</button>
                </div>
            </form>
        </div>
    </section>

    <script>
        const canvas = document.getElementById("particles");
        const ctx = canvas.getContext("2d");

        let particles = [];
        const total = 80;

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }

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
            resizeCanvas();
            particles = [];
            for (let i = 0; i < total; i++) {
                particles.push(new Particle());
            }
            animate();
        }

        window.addEventListener('resize', () => {
            resizeCanvas();
        });

        init();
    </script>
@endsection
