@extends('layout.fe_settings')
@section('content')
    <style>
        :root {
            --gradient-accent: linear-gradient(135deg,
                    #e3e2e2,
                    #e3e2e2,
                    #c4c4c4,
                    #e3e2e2,
                    #e3e2e2);
            --primary-color: #8a4d00;
            --primary-light: #cc7a00;
            --card-bg: rgba(255, 255, 255, 0.98);
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--gradient-accent);
            position: relative;
            overflow-x: hidden;
            min-height: 100vh;
        }

        .card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border-left: 5px solid var(--primary-color);
        }

        .main-panel {
            padding: 20px
        }

        dl dt {
            font-weight: 700;
            color: #555
        }

        dl dd {
            margin: 0 0 12px 0
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
        }
    </style>

    <canvas id="particles"></canvas>

    <main style="display:flex;gap:20px;padding:20px;">
        <aside style="width:260px;">
            <section class="card">
                <h2>Detalhes</h2>
                <p>Visualize os dados submetidos pelo candidato.</p>
            </section>
        </aside>

        <section class="main-panel">
            <div class="card">
                <h2>Detalhes da Candidatura #{{ $cand->id }}</h2>

                <dl style="display:grid;grid-template-columns:1fr 2fr;gap:8px 20px;">
                    <dt>Nome</dt>
                    <dd>{{ $cand->nome }}</dd>
                    <dt>Email</dt>
                    <dd>{{ $cand->email }}</dd>
                    <dt>Telefone</dt>
                    <dd>{{ $cand->telefone }}</dd>
                    <dt>Data de Nascimento</dt>
                    <dd>{{ $cand->data_nascimento }}</dd>
                    <dt>NIF</dt>
                    <dd>{{ $cand->nif }}</dd>
                    <dt>Morada</dt>
                    <dd>{{ $cand->morada }}</dd>
                    <dt>Código Postal</dt>
                    <dd>{{ $cand->codigo_postal }}</dd>
                    <dt>Localidade</dt>
                    <dd>{{ $cand->localidade }}</dd>
                    <dt>Tipo Curso</dt>
                    <dd>{{ $cand->tipo_curso }}</dd>
                    <dt>Curso ID</dt>
                    <dd>{{ $cand->curso_id }}</dd>
                    <dt>Motivação</dt>
                    <dd style="white-space:pre-wrap;">{{ $cand->motivacao }}</dd>
                    <dt>Status</dt>
                    <dd>{{ ucfirst($cand->status) }}</dd>
                    <dt>Enviado em</dt>
                    <dd>{{ $cand->created_at }}</dd>
                </dl>

                <div style="margin-top:16px;">
                    @if ($cand->status === 'pending')
                        <form action="{{ route('candidaturas.accept', $cand->id) }}" method="POST"
                            style="display:inline-block;margin-right:8px;">@csrf<button
                                class="btn btn-primary">Aceitar</button></form>

                        <form action="{{ route('candidaturas.reject', $cand->id) }}" method="POST"
                            style="display:inline-block;">@csrf<button class="btn btn-secondary">Rejeitar</button></form>
                    @endif

                    <a href="{{ route('admin.candidaturas.index') }}" class="btn btn-secondary"
                        style="margin-left:12px;">Voltar</a>
                </div>
            </div>
        </section>
    </main>

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
                this.alpha = Math.random() * 0.4 + 0.1;
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
                ctx.fillStyle = `#ffffff`;
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
                        ctx.strokeStyle = `#ffffff`;
                        ctx.lineWidth = 1;
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

        window.addEventListener('resize', resizeCanvas);

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        init();
    </script>
@endsection
