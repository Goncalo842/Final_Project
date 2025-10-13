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
        }

        main {
            display: flex;
            padding: 25px;
            gap: 25px;
            width: 100%;
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

        .box {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border-left: 5px solid var(--primary-color);
            width: 100%;
            transition: transform 0.3s ease;
        }

        .box:hover {
            transform: translateY(-3px);
        }

        .box h2 {
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
            transform: scale(1.01);
        }

        .disciplina {
            background-color: rgba(240, 224, 192, 0.3);
            font-weight: 500;
            position: relative;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .disciplina:hover {
            background-color: rgba(240, 224, 192, 0.5);
        }

        /* Modal */
        .modal-faltas {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-conteudo {
            background-color: white;
            width: 80%;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .modal-cabecalho {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .modal-cabecalho h2 {
            color: var(--primary-color);
            margin: 0;
        }

        .fechar-modal {
            font-size: 24px;
            cursor: pointer;
            color: #aaa;
            transition: color 0.2s ease;
        }

        .fechar-modal:hover {
            color: #333;
        }

        .lista-alunos {
            max-height: 300px;
            overflow-y: auto;
            margin: 15px 0;
        }

        .aluno-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .botoes-modal {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .botao {
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        .botao-primario {
            background-color: var(--primary-color);
            color: white;
        }

        .botao-primario:hover {
            background-color: var(--primary-light);
        }

        .botao-secundario {
            background-color: #f0f0f0;
            color: #333;
        }

        .botao-secundario:hover {
            background-color: #e0e0e0;
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
            .box {
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
                <h2>Informações</h2>

                <div class="subcard">
                    <h3>📅 Datas importantes</h3>
                    <p>16-09-2025 - Início 1º Semestre</p>
                    <p>01-03-2026 - Fim 1º Semestre</p>
                    <p>05-03-2026 - Início 2º Semestre</p>
                    <p>10 / 31-03-2026 - Época de recursos</p>
                    <p>31-06-2026 - Fim 2º Semestre</p>
                    <p>10 / 30-09-2026 - Época de recursos</p>
                </div>

                <div class="subcard">
                    <h3>📅 Férias letivas</h3>
                    <p>21-12 / 03-01-2026 - Natal</p>
                    <p>03/04-03-2026 - Páscoa</p>
                </div>

                <div class="subcard">
                    <h3>Avisos</h3>
                    <p>Reunião de docentes dia 30/05 às 10h.</p>
                </div>

                <div class="subcard">
                    <h3>Documentos</h3>
                    <p><a href="#">Plano curricular</a></p>
                    <p><a href="#">Regulamento interno</a></p>
                </div>
            </section>

            <section class="card">
                <h2>Diretor de turma</h2>
                <p><strong>Nome:</strong><br>Goncalo Queirós</p>
                <p><strong>Atendimento: </strong><br>2ºfeira (14:00 h)</p>
                <p><strong>Contacto: </strong><br>goncalo@gmail.com</p>
            </section>
        </aside>

        <section class="main-panel">
            <div class="reader">
                📢 Lembrete: As pautas da avaliação contínua devem ser submetidas até 27/05.
            </div>

            <div class="box">
                <h2>📝 Avaliações agendadas</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Turma</th>
                            <th>Disciplina</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>23/05/2025</td>
                            <td>DS 1ºAno</td>
                            <td>PSW</td>
                            <td>Teste prático</td>
                        </tr>
                        <tr>
                            <td>22/05/2025</td>
                            <td>DS 1ºAno</td>
                            <td>PDM</td>
                            <td>Apresentação</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="box">
                <h2>📆 Horário desta semana</h2>
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
                        <td rowspan="4" class="disciplina" data-horario="Segunda 09:00-12:00" data-id="1">LP</td>
                        <td></td>
                        <td></td>
                        <td rowspan="4" class="disciplina" data-horario="Quinta 09:00-12:00" data-id="2">PDM</td>
                        <td rowspan="4" class="disciplina" data-horario="Sexta 09:00-12:00" data-id="4">PSW</td>
                        <td rowspan="4" class="disciplina" data-horario="Sábado 09:00-12:00" data-id="5">LI</td>
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
                        <td rowspan="4" class="disciplina" data-horario="Segunda 14:00-17:00" data-id="7">P</td>
                        <td></td>
                        <td rowspan="4" class="disciplina" data-horario="Quarta 14:00-17:00" data-id="6">PAM</td>
                        <td rowspan="2" class="disciplina" data-horario="Quinta 14:00-15:00" data-id="3">PWS</td>
                        <td rowspan="4" class="disciplina" data-horario="Sexta 14:00-17:00" data-id="4">PSW</td>
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

    <div id="modalFaltas" class="modal-faltas">
        <div class="modal-conteudo">
            <div class="modal-cabecalho">
                <h2 id="tituloModal">Faltas - Disciplina</h2>
                <span class="fechar-modal" onclick="fecharModal()">×</span>
            </div>
            <p id="detalhesAula">Horário</p>
            <div id="listaAlunos" class="lista-alunos"></div>
            <div class="botoes-modal">
                <button class="botao botao-secundario" onclick="fecharModal()">Cancelar</button>
                <button class="botao botao-primario" id="guardarBtn">Guardar</button>
            </div>
        </div>
    </div>

    <script>
        let disciplinaIdSelecionada = null;

        function abrirModal(disciplina, horario, disciplinaId) {
            disciplinaIdSelecionada = disciplinaId;

            document.getElementById('tituloModal').textContent = `Faltas - ${disciplina}`;
            document.getElementById('detalhesAula').textContent = horario;

            const listaAlunos = document.getElementById('listaAlunos');
            listaAlunos.innerHTML = 'Carregando alunos...';

            fetch('/faltas/alunos')
                .then(res => res.json())
                .then(alunos => {
                    fetch(`/faltas/disciplina/${disciplinaId}`)
                        .then(res => res.json())
                        .then(faltas => {
                            listaAlunos.innerHTML = '';
                            alunos.forEach(aluno => {
                                const checked = faltas.includes(aluno.id) ? 'checked' : '';
                                const alunoItem = document.createElement('div');
                                alunoItem.className = 'aluno-item';
                                alunoItem.innerHTML = `
                                    <span>${aluno.name}</span>
                                    <input type="checkbox" class="falta-checkbox" data-user-id="${aluno.id}" ${checked}>
                                `;
                                listaAlunos.appendChild(alunoItem);
                            });
                        });
                })
                .catch(() => {
                    listaAlunos.innerHTML = 'Erro ao carregar alunos.';
                });

            document.getElementById('modalFaltas').style.display = 'block';
        }

        function fecharModal() {
            document.getElementById('modalFaltas').style.display = 'none';
        }

        function guardarFaltas() {
            if (!disciplinaIdSelecionada) {
                alert('Erro: Disciplina não selecionada');
                return;
            }

            const checkboxes = document.querySelectorAll('.falta-checkbox');
            const faltas = {};

            checkboxes.forEach(cb => {
                const userId = cb.getAttribute('data-user-id');
                if (cb.checked) {
                    faltas[userId] = true;
                }
            });

            fetch('/professor/faltas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        disciplina_id: disciplinaIdSelecionada,
                        faltas
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        fecharModal();
                    }
                })

                .catch(() => {
                    alert('Erro na comunicação com o servidor.');
                });
        }

        document.querySelectorAll('.disciplina').forEach(disciplina => {
            disciplina.addEventListener('click', function() {
                const nomeDisciplina = this.textContent.trim();
                const horario = this.getAttribute('data-horario');
                const disciplinaId = this.getAttribute('data-id');
                abrirModal(nomeDisciplina, horario, disciplinaId);
            });
        });

        document.getElementById('guardarBtn').addEventListener('click', guardarFaltas);
    </script>

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
            for (let i = 0; i < total; i++) particles.push(new Particle());
            animate();
        }

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });

        init();
    </script>
@endsection
