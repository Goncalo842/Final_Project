@extends('layout.fe_settings')
@section('content')
    <style>
        :root {
            --primary-color: #8a4d00;
            --primary-light: #cc7a00;
            --secondary-color: #5a5a5a;
            --light-bg: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
            --card-bg: rgba(255, 255, 255, 0.98);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--light-bg);
            position: relative;
            overflow-x: hidden;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
        }

        main {
            display: flex;
            padding: 25px;
            gap: 25px;
            width: 100%;
            max-width: none;
            margin: 0;
        }

        .sidebar {
            width: 25%;
            min-width: 300px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border-left: 5px solid var(--primary-color);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        }

        .card h2 {
            color: var(--primary-color);
            font-size: 18px;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(138, 77, 0, 0.2);
        }

        .stat-box {
            background: linear-gradient(135deg, rgba(138, 77, 0, 0.1), rgba(204, 122, 0, 0.05));
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 12px;
            border-left: 4px solid var(--primary-light);
        }

        .stat-label {
            font-size: 12px;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .subcard {
            margin-bottom: 15px;
        }

        .subcard h3 {
            font-size: 15px;
            color: var(--primary-light);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .subcard p {
            padding: 8px 0;
            margin: 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .subcard p:hover {
            background: rgba(138, 77, 0, 0.03);
            padding-left: 5px;
        }

        .subcard a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .main-panel {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 75%;
        }

        .data-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border-left: 5px solid var(--primary-color);
        }

        .data-card h2 {
            color: var(--primary-color);
            font-size: 18px;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(138, 77, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
        }

        th {
            background-color: var(--primary-color);
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 500;
        }

        td {
            padding: 10px;
            text-align: left;
            border: 1px solid rgba(0, 0, 0, 0.05);
            background-color: white;
        }

        tr:hover td {
            background-color: rgba(138, 77, 0, 0.05);
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-completed {
            background: #c6f6d5;
            color: #22543d;
        }

        .status-pending {
            background: #feebc8;
            color: #c05621;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #a0aec0;
        }

        @media (max-width: 1200px) {
            main {
                flex-direction: column;
            }

            .sidebar,
            .main-panel {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            main {
                padding: 15px;
            }

            .card,
            .data-card {
                padding: 15px;
            }

            table {
                font-size: 14px;
            }
        }
    </style>

    <canvas id="particles"></canvas>

    <main>
        <aside class="sidebar">
            <section class="card">
                <h2><i class="fas fa-chart-bar"></i> Estatísticas Principais</h2>

                <div class="stat-box">
                    <div class="stat-label">Total de Utilizadores</div>
                    <div class="stat-value">{{ $totalUsers }}</div>
                </div>

                <div class="stat-box">
                    <div class="stat-label">Faltas Registadas</div>
                    <div class="stat-value">{{ $totalFaltas }}</div>
                </div>

                <div class="stat-box">
                    <div class="stat-label">Disciplinas</div>
                    <div class="stat-value">{{ $totalDisciplinas }}</div>
                </div>

                <div class="stat-box">
                    <div class="stat-label">Produtos em Stock</div>
                    <div class="stat-value">{{ $totalStock }}</div>
                </div>

                <div class="stat-box">
                    <div class="stat-label">Pagamentos Pendentes</div>
                    <div class="stat-value" style="color: #c62828;">{{ $pagamentosPendentes }}</div>
                </div>
            </section>

            <section class="card">
                <h2><i class="fas fa-file-alt"></i> Ações Rápidas</h2>
                <div class="subcard">
                    <p><a href="{{ route('admin.candidaturas.index') }}"><i class="fas fa-file-signature"></i> Ver Candidaturas</a></p>
                    <p><a href="{{ route('stock') }}"><i class="fas fa-boxes"></i> Gerenciar Stock</a></p>
                    <p><a href="{{ route('products') }}"><i class="fas fa-store"></i> Ver Produtos</a></p>
                </div>
            </section>
        </aside>

        <section class="main-panel">
            <div class="data-card">
                <h2><i class="fas fa-users"></i> Últimos Utilizadores Registados</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Data Registo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimosUsers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="empty-state">Nenhum utilizador registado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="data-card">
                <h2><i class="fas fa-credit-card"></i> Últimos Pagamentos</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Aluno</th>
                            <th>Mês</th>
                            <th>Status</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ultimosPagamentos as $pagamento)
                            <tr>
                                <td>#{{ $pagamento->id }}</td>
                                <td>{{ $pagamento->name }}</td>
                                <td>{{ $pagamento->mes }}</td>
                                <td>
                                    @if($pagamento->pago)
                                        <span class="status-badge status-completed">✓ Pago</span>
                                    @else
                                        <span class="status-badge status-pending">⏱ Pendente</span>
                                    @endif
                                </td>
                                <td>{{ $pagamento->created_at ? \Carbon\Carbon::parse($pagamento->created_at)->format('d/m/Y') : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">Nenhum pagamento registado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($ultimosPagamentos->hasPages())
                    <div style="display: flex; justify-content: center; gap: 10px; margin-top: 20px; flex-wrap: wrap;">
                        @if($ultimosPagamentos->onFirstPage())
                            <button style="padding: 8px 12px; background: #e0e0e0; border: none; border-radius: 4px; cursor: not-allowed; color: #999;">← Anterior</button>
                        @else
                            <a href="{{ $ultimosPagamentos->previousPageUrl() }}" style="padding: 8px 12px; background: #cc7a00; color: white; border: none; border-radius: 4px; text-decoration: none; cursor: pointer;">← Anterior</a>
                        @endif

                        @foreach($ultimosPagamentos->getUrlRange(1, $ultimosPagamentos->lastPage()) as $page => $url)
                            @if($page == $ultimosPagamentos->currentPage())
                                <button style="padding: 8px 12px; background: #cc7a00; color: white; border: none; border-radius: 4px; cursor: default; font-weight: bold;">{{ $page }}</button>
                            @else
                                <a href="{{ $url }}" style="padding: 8px 12px; background: #f0f0f0; color: #333; border: 1px solid #ddd; border-radius: 4px; text-decoration: none; cursor: pointer;">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if($ultimosPagamentos->hasMorePages())
                            <a href="{{ $ultimosPagamentos->nextPageUrl() }}" style="padding: 8px 12px; background: #cc7a00; color: white; border: none; border-radius: 4px; text-decoration: none; cursor: pointer;">Próxima →</a>
                        @else
                            <button style="padding: 8px 12px; background: #e0e0e0; border: none; border-radius: 4px; cursor: not-allowed; color: #999;">Próxima →</button>
                        @endif
                    </div>

                    <div style="text-align: center; margin-top: 10px; font-size: 12px; color: #666;">
                        Página {{ $ultimosPagamentos->currentPage() }} de {{ $ultimosPagamentos->lastPage() }} ({{ $ultimosPagamentos->total() }} pagamentos)
                    </div>
                @endif
            </div>

            <div class="data-card">
                <h2><i class="fas fa-chart-pie"></i> Resumo Financeiro</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="stat-box">
                        <div class="stat-label">Pagamentos Efetuados</div>
                        <div class="stat-value">{{ $totalPagamentosPagos }}</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-label">Pagamentos Pendentes</div>
                        <div class="stat-value" style="color: #c62828;">{{ $pagamentosPendentes }}</div>
                    </div>
                </div>
            </div>
        </section>
    </main>

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
