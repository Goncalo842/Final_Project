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

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden
        }

        th {
            background: var(--primary-color);
            color: #fff;
            padding: 12px;
            text-align: left
        }

        td {
            background: white;
            padding: 10px;
            border: 1px solid rgba(0, 0, 0, 0.05)
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
                <h2>Admin — Candidaturas</h2>
                <p>Lista de candidaturas submetidas. Aceite ou rejeite conforme necessário.</p>
            </section>
        </aside>

        <section class="main-panel">
            <div class="card">
                @if (session('message'))
                    <div style="padding:10px;background:#e6ffe6;border:1px solid #8fd18f;margin-bottom:10px;">
                        {{ session('message') }}</div>
                @endif

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Localidade</th>
                            <th>Curso</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($candidaturas as $c)
                            <tr>
                                <td>{{ $c->id }}</td>
                                <td>{{ $c->nome }}</td>
                                <td>{{ $c->email }}</td>
                                <td>{{ $c->localidade }}</td>
                                <td>{{ $c->tipo_curso }}</td>
                                <td>{{ ucfirst($c->status) }}</td>
                                <td>
                                    <a href="{{ route('admin.candidaturas.show', $c->id) }}" class="btn btn-secondary"
                                        style="margin-right:6px;">Ver</a>
                                    @if ($c->status === 'pending')
                                        <form action="{{ route('candidaturas.accept', $c->id) }}" method="POST"
                                            style="display:inline-block;margin-right:6px;">@csrf<button
                                                class="btn btn-primary">Aceitar</button></form>
                                        <form action="{{ route('candidaturas.reject', $c->id) }}" method="POST"
                                            style="display:inline-block;">@csrf<button
                                                class="btn btn-secondary">Rejeitar</button></form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
