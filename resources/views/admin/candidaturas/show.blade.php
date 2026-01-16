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
            margin: 0;
        }

        .card {
            background: var(--card-bg);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-left: 5px solid var(--primary-color);
        }

        .card h2 {
            color: var(--primary-color);
            margin-top: 0;
            font-size: 26px;
            margin-bottom: 25px;
            font-weight: 700;
        }

        .card p {
            color: #666;
            line-height: 1.6;
        }

        .main-panel {
            flex: 1;
            max-width: 900px;
        }

        dl dt {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        dl dd {
            margin: 0 0 20px 0;
            color: #333;
            font-size: 15px;
            line-height: 1.6;
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
        }

        .btn-warning {
            background: var(--primary-color);
            color: white;
        }

        .btn-warning:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(138, 77, 0, 0.3);
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 700;
            text-transform: capitalize;
            display: inline-block;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 2px solid #ffc107;
        }

        .status-accepted {
            background: #d4edda;
            color: #155724;
            border: 2px solid #28a745;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #dc3545;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 15px 30px;
            background: rgba(138, 77, 0, 0.02);
            padding: 25px;
            border-radius: 10px;
            border: 1px solid rgba(138, 77, 0, 0.1);
        }

        .action-buttons {
            margin-top: 30px;
            padding-top: 25px;
            border-top: 2px solid rgba(138, 77, 0, 0.1);
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
    </style>

    <canvas id="particles"></canvas>

    <main style="display:flex;gap:30px;padding:40px;max-width:1400px;margin:0 auto;">
        <aside style="width:300px;">
            <section class="card">
                <h2>Detalhes</h2>
                <p>Visualize todos os dados submetidos pelo candidato e tome uma decisão.</p>
            </section>
        </aside>

        <section class="main-panel">
            <div class="card">
                <h2>🎓 Candidatura #{{ $cand->id }}</h2>

                <dl class="info-grid">
                    <dt>Nome</dt>
                    <dd><strong>{{ $cand->nome }}</strong></dd>
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
                    <dd style="white-space:pre-wrap;background:white;padding:15px;border-radius:8px;border-left:3px solid var(--primary-color);">{{ $cand->motivacao }}</dd>
                    <dt>Status</dt>
                    <dd>
                        <span class="status-badge status-{{ $cand->status }}">
                        @if($cand->status === 'pending')
                            Pendente
                        @elseif($cand->status === 'accepted')
                            Aceite
                        @elseif($cand->status === 'rejected')
                            Rejeitado
                        @else
                            {{ ucfirst($cand->status) }}
                        @endif
                        </span>
                    </dd>
                    <dt>Enviado em</dt>
                    <dd>{{ $cand->created_at }}</dd>
                </dl>

                <div class="action-buttons">
                    @if ($cand->status === 'pending')
                        <form action="{{ route('candidaturas.accept', $cand->id) }}" method="POST"
                            style="display:inline-block;">@csrf<button
                                class="btn btn-warning">✓ Aceitar Candidatura</button></form>

                        <form action="{{ route('candidaturas.reject', $cand->id) }}" method="POST"
                            style="display:inline-block;">@csrf<button class="btn btn-warning">✗ Rejeitar Candidatura</button></form>
                    @endif

                    <a href="{{ route('admin.candidaturas.index') }}" class="btn btn-warning">
                        ← Voltar à Lista</a>
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
