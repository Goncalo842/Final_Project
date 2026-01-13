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
            width: 100%;
            height: 100%;
            opacity: 0.8;
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

        .main-panel {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 75%;
        }

        .grades-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border-left: 5px solid var(--primary-color);
            transition: transform 0.3s ease;
        }

        .grades-card:hover {
            transform: translateY(-3px);
        }

        .grades-card h2 {
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
            text-align: center;
            font-weight: 500;
        }

        td {
            padding: 10px;
            text-align: center;
            border: 1px solid rgba(0, 0, 0, 0.05);
            background-color: white;
            transition: all 0.2s ease;
        }

        tr:hover td {
            background-color: rgba(138, 77, 0, 0.05);
        }

        .student-name {
            text-align: left;
            font-weight: 500;
        }

        .grade-input {
            width: 70px;
            padding: 8px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            text-align: center;
            transition: all 0.2s ease;
        }

        .grade-input:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(204, 122, 0, 0.1);
        }

        .disabled-input {
            background-color: #f0f0f0;
            color: #777;
            border: none;
            cursor: not-allowed;
        }

        .btn-orange {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            margin-top: 15px;
        }

        .btn-orange:hover {
            background-color: var(--primary-light);
        }

        .grades-actions {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 12px;
            gap: 8px;
        }

        .btn-orange--small {
            padding: 8px 12px;
            font-size: 14px;
            border-radius: 6px;
        }

        /* Header dropdown */
        .grades-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .grades-header-actions {
            position: relative;
        }

        .grades-toggle {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: var(--primary-color);
            padding: 6px;
            border-radius: 6px;
        }

        .grades-toggle:focus { outline: none; box-shadow: 0 0 0 3px rgba(138,77,0,0.12); }

        .grades-dropdown {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: white;
            border-radius: 8px;
            padding: 8px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            opacity: 0;
            transform: translateY(-8px) scale(0.98);
            transform-origin: top right;
            transition: opacity 220ms cubic-bezier(.2,.8,.2,1), transform 220ms cubic-bezier(.2,.8,.2,1);
            pointer-events: none;
            min-width: 220px;
            z-index: 30;
        }

        .grades-dropdown.show {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        .grades-dropdown a { display: block; text-decoration: none; }

        .grades-toggle .fa-chevron-down { transition: transform 200ms ease; }
        .grades-toggle[aria-expanded="true"] .fa-chevron-down { transform: rotate(180deg); }

        .download-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 6px;
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
        }

        .download-item:hover {
            background: rgba(138,77,0,0.06);
        }

        .reader {
            background-color: rgba(255, 251, 230, 0.9);
            border-left: 5px solid var(--primary-light);
            padding: 15px 20px;
            font-size: 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            animation: pulse 2s infinite;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(204, 122, 0, 0.3);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(204, 122, 0, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(204, 122, 0, 0);
            }
        }

        .reader i {
            color: var(--primary-light);
            font-size: 18px;
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
            .grades-card {
                padding: 15px;
            }

            table {
                font-size: 14px;
            }

            .grade-input {
                width: 60px;
                padding: 6px;
            }
        }
    </style>

    <canvas id="particles"></canvas>

    <main>
        <aside class="sidebar">
            <section class="card">
                <h2><i class="fas fa-info-circle"></i> Informações do Professor</h2>
                <div class="subcard">
                    <p><strong>Turma:</strong> {{ $turma->nome ?? 'DS' }}</p>
                    <p><strong>Ano Letivo:</strong> 2025/2026</p>
                    <p><strong>Disciplinas:</strong> {{ $disciplinas->count() }}</p>
                    <p><strong>Alunos:</strong> {{ $users->count() }}</p>
                </div>
            </section>

            <section class="card">
                <h2><i class="fas fa-calendar-alt"></i> Prazos</h2>
                <div class="subcard">
                    <p><strong>Lançamento de notas:</strong> Até 27/05</p>
                    <p><strong>Revisões:</strong> 16-20/06</p>
                    <p><strong>Conselhos de turma:</strong> 25/06</p>
                </div>
            </section>

            <section class="card">
                <h2><i class="fas fa-question-circle"></i> Ajuda</h2>
                <div class="subcard">
                    <p><a href="#"><i class="fas fa-external-link-alt"></i> Guia de lançamento</a></p>
                    <p><a href="#"><i class="fas fa-external-link-alt"></i> Critérios de avaliação</a></p>
                    <p><a href="#"><i class="fas fa-external-link-alt"></i> Contatar administração</a></p>
                </div>
            </section>
        </aside>

        <section class="main-panel">
            <div class="reader">
                <i class="fas fa-exclamation-circle"></i>
                <span>Atenção: As pautas da avaliação contínua devem ser submetidas até 27/05.</span>
            </div>

            <div class="grades-card">
                <div class="grades-header">
                    <h2><i class="fas fa-edit"></i> Lançamento de Notas</h2>
                    <div class="grades-header-actions">
                        <button class="grades-toggle" id="gradesToggle" aria-expanded="false" aria-controls="gradesDropdown">
                            <i class="fas fa-chevron-down"></i>
                        </button>

                        <div class="grades-dropdown" id="gradesDropdown" role="menu" aria-hidden="true">
                            <a href="{{ route('grades.download') }}" class="btn-orange btn-orange--small">
                                <i class="fas fa-download"></i> Descarregar Todas as Notas
                            </a>
                        </div>
                    </div>
                </div>

                <form action="{{ route('store.grade') }}" method="POST">
                    @csrf

                    <div style="overflow-x: auto;">
                        <table>
                            <thead>
                                <tr>
                                    <th>Aluno</th>
                                    @foreach ($disciplinas as $disciplina)
                                        <th>{{ $disciplina->nome }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="student-name">{{ $user->name }}</td>
                                        @foreach ($disciplinas as $disciplina)
                                            @php
                                                $existingGrade = $grades
                                                    ->where('user_id', $user->id)
                                                    ->where('disciplina_id', $disciplina->id)
                                                    ->first();
                                            @endphp
                                            <td>
                                                @if ($existingGrade && !is_null($existingGrade->nota))
                                                    <input type="number" value="{{ $existingGrade->nota }}" disabled
                                                        class="grade-input disabled-input" title="Nota já lançada" />
                                                @else
                                                    <input type="number"
                                                        name="grades[{{ $user->id }}][{{ $disciplina->id }}]"
                                                        min="0" max="20" step="0.1" class="grade-input"
                                                        placeholder="0-20" />
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn-orange">
                        <i class="fas fa-save"></i> Salvar Notas
                    </button>
                </form>
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

        document.querySelectorAll('.grade-input').forEach(input => {
            input.addEventListener('change', function() {
                const value = parseFloat(this.value);
                if (value < 0) {
                    this.value = 0;
                } else if (value > 20) {
                    this.value = 20;
                }
            });
        });

        // Dropdown toggle for grades actions
        const gradesToggle = document.getElementById('gradesToggle');
        const gradesDropdown = document.getElementById('gradesDropdown');

        if (gradesToggle && gradesDropdown) {
            gradesToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                const isShown = gradesDropdown.classList.toggle('show');
                gradesDropdown.setAttribute('aria-hidden', !isShown);
                gradesToggle.setAttribute('aria-expanded', isShown);
            });

            // close when clicking outside
            document.addEventListener('click', (e) => {
                if (!gradesDropdown.contains(e.target) && !gradesToggle.contains(e.target)) {
                    gradesDropdown.classList.remove('show');
                    gradesDropdown.setAttribute('aria-hidden', 'true');
                    gradesToggle.setAttribute('aria-expanded', 'false');
                }
            });
        }

        init();
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
