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
            font-size: 24px;
            margin-bottom: 15px;
        }

        .card p {
            color: #666;
            line-height: 1.6;
        }

        .main-panel {
            flex: 1;
            max-width: 1200px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        th {
            background: var(--primary-color);
            color: #fff;
            padding: 16px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        th:first-child {
            text-align: center;
        }

        th:last-child {
            text-align: center;
        }

        td {
            background: white;
            padding: 14px 12px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            vertical-align: middle;
        }

        td:first-child {
            text-align: center;
            font-weight: 600;
            color: var(--primary-color);
        }

        td:last-child {
            text-align: center;
        }

        tbody tr {
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background: rgba(138, 77, 0, 0.02);
            transform: scale(1.01);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            font-size: 13px;
            white-space: nowrap;
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
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
            display: inline-block;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-accepted {
            background: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .alert-success {
            padding: 15px 20px;
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border: 2px solid #28a745;
            border-radius: 10px;
            margin-bottom: 20px;
            color: #155724;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2);
        }
    </style>

    <canvas id="particles"></canvas>

    <main style="display:flex;gap:30px;padding:40px;max-width:1600px;margin:0 auto;">
        <aside style="width:300px;">
            <section class="card">
                <h2>Candidaturas</h2>
                <p>Gerencie as candidaturas submetidas pelos alunos. Aceite ou rejeite conforme necessário.</p>
            </section>
        </aside>

        <section class="main-panel">
            <div class="card">
                @if (session('message'))
                    <div class="alert-success">
                        ✓ {{ session('message') }}
                    </div>
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
                                <td><strong>#{{ $c->id }}</strong></td>
                                <td><strong>{{ $c->nome }}</strong></td>
                                <td style="color: #666;">{{ $c->email }}</td>
                                <td>{{ $c->localidade }}</td>
                                <td>{{ $c->tipo_curso }}</td>
                                <td>
                                    <span class="status-badge status-{{ $c->status }}">
                                        @if($c->status === 'pending')
                                            Pendente
                                        @elseif($c->status === 'accepted')
                                            Aceite
                                        @elseif($c->status === 'rejected')
                                            Rejeitado
                                        @else
                                            {{ ucfirst($c->status) }}
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex;gap:8px;justify-content:center;flex-wrap:wrap;">
                                        <a href="{{ route('admin.candidaturas.show', $c->id) }}" class="btn btn-warning">Ver</a>
                                        @if ($c->status === 'pending')
                                            <form action="{{ route('candidaturas.accept', $c->id) }}" method="POST"
                                                style="display:inline-block;">@csrf<button
                                                    class="btn btn-warning">✓ Aceitar</button></form>
                                            <form action="{{ route('candidaturas.reject', $c->id) }}" method="POST"
                                                style="display:inline-block;">@csrf<button
                                                    class="btn btn-warning">✗ Rejeitar</button></form>
                                        @endif
                                    </div>
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
