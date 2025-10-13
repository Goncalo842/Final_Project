@extends('layout.fe_settings')
@section('content')
    <style>
        :root {
            --primary-color: #8a4d00;
            --primary-light: #cc7a00;
            --secondary-color: #5a5a5a;
            --light-bg: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
            --card-bg: rgba(255, 255, 255, 0.96);
            --success-color: #2e7d32;
            --danger-color: #c62828;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--light-bg);
            position: relative;
            overflow-x: hidden;
            min-height: 100vh;
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .grades-container {
            width: 100%;
            max-width: 900px;
            margin: 60px auto;
            background: var(--card-bg);
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-left: 8px solid var(--primary-color);
            backdrop-filter: blur(5px);
        }

        .grades-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
        }

        .grades-title {
            color: var(--primary-color);
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.5px;
            position: relative;
            display: inline-block;
        }

        .grades-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .grades-subtitle {
            color: var(--secondary-color);
            margin: 15px 0 0;
            font-size: 16px;
            font-weight: 400;
        }

        .grades-table-container {
            overflow-x: auto;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .grades-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 600px;
        }

        .grades-table th {
            background-color: var(--primary-color);
            color: white;
            padding: 18px;
            text-align: left;
            font-weight: 500;
            position: sticky;
            top: 0;
        }

        .grades-table th:first-child {
            border-top-left-radius: 12px;
        }

        .grades-table th:last-child {
            border-top-right-radius: 12px;
        }

        .grades-table td {
            padding: 16px 18px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            background-color: white;
        }

        .grades-table tr:last-child td {
            border-bottom: none;
        }

        .grades-table tr:hover td {
            background-color: rgba(138, 77, 0, 0.03);
        }

        .grade-value {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 16px;
        }

        .grade-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 14px;
        }

        .grade-approved {
            background-color: rgba(46, 125, 50, 0.1);
            color: var(--success-color);
        }

        .grade-approved i {
            color: var(--success-color);
        }

        .grade-failed {
            background-color: rgba(198, 40, 40, 0.1);
            color: var(--danger-color);
        }

        .grade-failed i {
            color: var(--danger-color);
        }

        .no-grades {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .no-grades-icon {
            font-size: 50px;
            color: var(--primary-color);
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .no-grades-text {
            color: var(--secondary-color);
            font-size: 16px;
            margin-bottom: 20px;
        }

        .grade-details {
            margin-top: 40px;
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .grade-details-title {
            color: var(--primary-color);
            font-size: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .grade-details-title i {
            font-size: 24px;
        }

        @media (max-width: 768px) {
            .grades-container {
                padding: 30px 20px;
            }

            .grades-title {
                font-size: 26px;
            }

            .grades-table th,
            .grades-table td {
                padding: 12px 15px;
            }
        }
    </style>

    <canvas id="particles"></canvas>

    <div class="grades-container">
        <div class="grades-header">
            <h1 class="grades-title">Minhas Notas</h1>
            <p class="grades-subtitle">Consulte seu desempenho acadêmico</p>
        </div>

        @if ($grade->isEmpty())
            <div class="no-grades">
                <div class="no-grades-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <p class="no-grades-text">Ainda não há notas lançadas</p>
                <button class="btn btn-dark">
                    <i class="fas fa-sync-alt"></i> Atualizar
                </button>
            </div>
        @else
            @php
                $totalCadeiras = $grade->count();
                $cadeirasAprovadas = $grade->where('nota', '>=', 10)->count();
                $mediaNotas = $grade->avg('nota');
            @endphp

            <div class="grades-table-container">
                <table class="grades-table">
                    <thead>
                        <tr>
                            <th>Disciplina</th>
                            <th>Nota</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grade as $item)
                            <tr>
                                <td>{{ $item->disciplina_nome }}</td>
                                <td class="grade-value">{{ $item->nota ?? '—' }}</td>
                                <td>
                                    <span class="grade-status {{ $item->nota >= 10 ? 'grade-approved' : 'grade-failed' }}">
                                        <i
                                            class="fas {{ $item->nota >= 10 ? 'fa-check-circle' : 'fa-exclamation-circle' }}"></i>
                                        {{ $item->nota >= 10 ? 'Aprovado' : 'Reprovado' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="grade-details">
                <h3 class="grade-details-title">
                    <i class="fas fa-chart-line"></i> Resumo Acadêmico
                </h3>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                    <div>
                        <div style="font-size: 14px; color: var(--secondary-color); margin-bottom: 5px;">Média das Notas
                        </div>
                        <div style="font-size: 28px; font-weight: 700; color: var(--primary-color);">
                            {{ number_format($mediaNotas, 1, ',', '.') }}
                        </div>
                    </div>

                    <div>
                        <div style="font-size: 14px; color: var(--secondary-color); margin-bottom: 5px;">Cadeiras Aprovadas
                        </div>
                        <div style="font-size: 28px; font-weight: 700; color: var(--success-color);">
                            {{ $cadeirasAprovadas }}/{{ $totalCadeiras }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
