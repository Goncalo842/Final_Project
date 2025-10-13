@extends('layout.fe_settings')
@section('content')
    @php
        $faltas = $faltas ?? collect();
    @endphp
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

        .subcard a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .subcard a:hover {
            color: var(--primary-light);
            text-decoration: underline;
        }

        .main-panel {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 75%;
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

        .absences {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border-left: 5px solid var(--primary-color);
            width: 100%;
            transition: transform 0.3s ease;
        }

        .absences:hover {
            transform: translateY(-3px);
        }

        .absences h2 {
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
            position: relative;
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
            transform: scale(1.01);
        }

        .disciplina {
            background-color: rgba(240, 224, 192, 0.3);
            font-weight: 500;
            position: relative;
        }

        .disciplina:hover {
            background-color: rgba(240, 224, 192, 0.5);
        }

        .justified-yes {
            color: #2e7d32;
            font-weight: 500;
        }

        .justified-no {
            color: #c62828;
            font-weight: 500;
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
            .absences {
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
                <h2><i class="fas fa-info-circle"></i> Informações</h2>

                <div class="subcard">
                    <h3><i class="fas fa-calendar-alt"></i> Datas importantes</h3>
                    <p>16-09-2025 - Início 1º Semestre</p>
                    <p>01-03-2026 - Fim 1º Semestre</p>
                    <p>05-03-2026 - Início 2º Semestre</p>
                    <p>10 / 31-03-2026 - Época de recursos</p>
                    <p>31-06-2026 - Fim 2º Semestre</p>
                    <p>10 / 30-09-2026 - Época de recursos</p>
                </div>

                <div class="subcard">
                    <h3><i class="fas fa-calendar-day"></i> Férias letivas</h3>
                    <p>21-12 / 03-01-2026 - Férias de natal</p>
                    <p>03/04-03-2026 - Férias de pascoa</p>
                </div>

                <div class="subcard">
                    <h3><i class="fas fa-bullhorn"></i> Avisos</h3>
                    <p>Sem avisos no momento.</p>
                </div>

                <div class="subcard">
                    <h3><i class="fas fa-file-alt"></i> Documentos</h3>
                    <p><a href="#"><i class="fas fa-external-link-alt"></i> Ver lista</a></p>
                </div>
            </section>

            <section class="card">
                <h2><i class="fas fa-user-tie"></i> Diretor de turma</h2>
                <div class="subcard">
                    <p><strong>Nome:</strong><br>Goncalo Queirós</p>
                    <p><strong>Atendimento:</strong><br>2ºfeira (14:00 h)</p>
                    <p><strong>Contacto:</strong><br>goncalo@gmail.com</p>
                </div>
            </section>
        </aside>

        <section class="main-panel">
            <div class="reader">
                <i class="fas fa-exclamation-circle"></i>
                <span>Atenção: Esta semana há alteração no horário.</span>
            </div>

            <div class="absences">
                <h2>Faltas</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Disciplina</th>
                            <th>Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faltas as $falta)
                            <tr>
                                <td>{{ $falta->data }}</td>
                                <td>{{ $falta->disciplina_nome }}</td>
                                <td>{{ $falta->motivo }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Nenhuma falta registada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="absences">
                <h2><i class="fas fa-calendar-week"></i> Horário desta semana</h2>
                <table>
                    <tr>
                        <th>Hora</th>
                        <th>Seg 19/5</th>
                        <th>Ter 20/5</th>
                        <th>Qua 21/5</th>
                        <th>Qui 22/5</th>
                        <th>Sex 23/5</th>
                        <th>Sáb 24/5</th>
                        <th>Dom 25/5</th>
                    </tr>
                    <tr>
                        <td>09:00</td>
                        <td rowspan="4" class="disciplina">LP</td>
                        <td></td>
                        <td></td>
                        <td rowspan="4" class="disciplina">PDM <br>(Apresentação)</td>
                        <td rowspan="4" class="disciplina">PSW <br>(Teste Prático)</td>
                        <td rowspan="4" class="disciplina">LI</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>10:00</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>11:00</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>12:00</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>13:00</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>14:00</td>
                        <td rowspan="4" class="disciplina">P</td>
                        <td></td>
                        <td rowspan="4" class="disciplina">PAM</td>
                        <td rowspan="2" class="disciplina">PWS</td>
                        <td rowspan="4" class="disciplina">PSW</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>15:00</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>16:00</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>17:00</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>18:00</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
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
