@extends('layout.fe_master')
@section('content')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css'>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
            background: var(--gradient-accent);
            background-size: 100% 100%;
            color: black;
            overflow-x: hidden;
        }

        .admission-hero {
            padding: 5rem 2rem;
            text-align: center;
            position: relative;
            backdrop-filter: blur(2px);
            margin-bottom: 3rem;
        }

        .hero-content {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 2.75rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-dark);
            margin-bottom: 2rem;
            font-weight: 400;
        }

        .admission-container {
            max-width: 1000px;
            margin: 0 auto 5rem;
            padding: 0 2rem;
            position: relative;
            z-index: 1;
        }

        .timeline {
            position: relative;
            padding-left: 50px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 4px;
            background: linear-gradient(to bottom, var(--primary-color), var(--primary-light));
            border-radius: 2px;
        }

        .timeline-step {
            position: relative;
            margin-bottom: 2.5rem;
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .timeline-step:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .timeline-step::before {
            content: '';
            position: absolute;
            left: -40px;
            top: 30px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--primary-color);
            border: 4px solid var(--white);
            box-shadow: 0 0 0 2px var(--primary-color);
        }

        .step-number {
            position: absolute;
            left: -35px;
            top: 26px;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
            z-index: 2;
        }

        .step-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .step-title i {
            margin-right: 0.8rem;
            color: var(--primary-color);
        }

        .step-content {
            font-size: 1.1rem;
            color: var(--text-medium);
            line-height: 1.7;
        }

        .step-content ul {
            padding-left: 1.5rem;
            margin: 1rem 0;
        }

        .step-content li {
            margin-bottom: 0.5rem;
        }

        .alert-box {
            background: #fff3e0;
            border-left: 4px solid var(--primary-color);
            padding: 1.5rem;
            margin: 2rem 0;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
        }

        .alert-title {
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .alert-title i {
            margin-right: 0.5rem;
        }

        .contact-card {
            background: var(--white);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-top: 3rem;
            box-shadow: var(--shadow-sm);
            text-align: center;
        }

        .contact-title {
            font-size: 1.5rem;
            color: var(--primary-dark);
            margin-bottom: 1.5rem;
        }

        .contact-info {
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .contact-link {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            display: inline-block;
        }

        .contact-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            transition: var(--transition);
            display: inline-block;
            margin-top: 1rem;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.25rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .timeline {
                padding-left: 30px;
            }

            .timeline::before {
                left: 10px;
            }

            .timeline-step::before {
                left: -25px;
            }

            .step-number {
                left: -20px;
            }

            .timeline-step {
                padding: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }

            .admission-hero {
                padding: 4rem 1.5rem;
            }

            .step-title {
                font-size: 1.3rem;
            }

            .step-content {
                font-size: 1rem;
            }
        }
    </style>

    <canvas id="particles"></canvas>

    <section class="admission-hero">
        <div class="hero-content">
            <h1 class="hero-title">Processo de Candidatura</h1>
            <p class="hero-subtitle">Tudo o que precisa saber para se candidatar aos nossos cursos no ano letivo 2025/2026
            </p>
        </div>
    </section>

    <div class="admission-container">
        <div class="timeline">
            <div class="timeline-step">
                <div class="step-number">1</div>
                <h3 class="step-title"><i class="fas fa-search"></i> Explore os Nossos Cursos</h3>
                <div class="step-content">
                    <p>Conheça a nossa oferta formativa e selecione o curso que melhor se adequa ao seu perfil e objetivos
                        profissionais:</p>
                    <ul>
                        <li>Licenciaturas em Engenharia Informática, Mecânica e Civil</li>
                        <li>Cursos Técnicos Superiores Profissionais</li>
                        <li>Pós-Graduações e Formações Avançadas</li>
                    </ul>
                </div>
            </div>

            <div class="timeline-step">
                <div class="step-number">2</div>
                <h3 class="step-title"><i class="fas fa-clipboard-check"></i> Verifique os Requisitos</h3>
                <div class="step-content">
                    <p>Cada curso tem requisitos específicos de admissão:</p>
                    <ul>
                        <li>Certificado de conclusão do ensino secundário ou equivalente</li>
                        <li>Provas de ingresso específicas para algumas licenciaturas</li>
                        <li>Curriculum Vitae atualizado para cursos pós-laborais</li>
                        <li>Portfólio para cursos de Design e Multimédia</li>
                    </ul>
                </div>
            </div>

            <div class="timeline-step">
                <div class="step-number">3</div>
                <h3 class="step-title"><i class="fas fa-file-alt"></i> Prepare a Documentação</h3>
                <div class="step-content">
                    <p>Documentação necessária para a candidatura:</p>
                    <ul>
                        <li>Documento de identificação (Cartão de Cidadão/Bilhete de Identidade ou Passaporte)</li>
                        <li>Certificado de Habilitações</li>
                        <li>Fotografia tipo passe (digital)</li>
                        <li>Comprovativo de residência</li>
                        <li>Comprovativo de pagamento da taxa de candidatura (50€)</li>
                    </ul>
                </div>
            </div>

            <div class="alert-box">
                <h4 class="alert-title"><i class="fas fa-exclamation-circle"></i> Período de Candidaturas</h4>
                <p>As candidaturas para o ano letivo 2025/2026 decorrem de <strong>1 de agosto a 30 de setembro</strong>.
                    Candidaturas fora deste período serão consideradas caso existam vagas disponíveis.</p>
            </div>

            <div class="timeline-step">
                <div class="step-number">4</div>
                <h3 class="step-title"><i class="fas fa-laptop"></i> Submissão da Candidatura</h3>
                <div class="step-content">
                    <p>Processo de candidatura online:</p>
                    <ol>
                        <li>Aceda ao nosso portal de candidaturas</li>
                        <li>Registe-se criando uma conta pessoal</li>
                        <li>Preencha o formulário com os seus dados</li>
                        <li>Anexe os documentos digitalizados em formato PDF</li>
                        <li>Efetue o pagamento da taxa de candidatura</li>
                        <li>Submeta a sua candidatura</li>
                    </ol>
                    <a href="{{ route('candidaturas.create') }}" class="btn-primary">Aceder ao Portal de Candidaturas</a>
                </div>
            </div>

            <div class="timeline-step">
                <div class="step-number">5</div>
                <h3 class="step-title"><i class="fas fa-calendar-check"></i> Prazos e Pagamentos</h3>
                <div class="step-content">
                    <p>Datas importantes a ter em conta:</p>
                    <ul>
                        <li><strong>1 de agosto:</strong> Abertura das candidaturas</li>
                        <li><strong>30 de setembro:</strong> Encerramento das candidaturas</li>
                        <li><strong>15 de outubro:</strong> Divulgação dos resultados</li>
                        <li><strong>31 de outubro:</strong> Prazo para matrículas</li>
                    </ul>
                    <p>A taxa de candidatura é de 50€ (não reembolsável).</p>
                </div>
            </div>

            <div class="timeline-step">
                <div class="step-number">6</div>
                <h3 class="step-title"><i class="fas fa-comments"></i> Entrevistas e Provas</h3>
                <div class="step-content">
                    <p>Para alguns cursos poderá ser necessário:</p>
                    <ul>
                        <li>Entrevista com a coordenação do curso</li>
                        <li>Prova de aptidão ou conhecimentos específicos</li>
                        <li>Análise de portfólio (cursos artísticos)</li>
                    </ul>
                    <p>Será contactado via email com todas as informações necessárias caso o seu curso exija estas etapas
                        adicionais.</p>
                </div>
            </div>

            <div class="timeline-step">
                <div class="step-number">7</div>
                <h3 class="step-title"><i class="fas fa-graduation-cap"></i> Matrícula e Inscrição</h3>
                <div class="step-content">
                    <p>Após aceitação da candidatura:</p>
                    <ol>
                        <li>Receberá um email com instruções para matrícula</li>
                        <li>Deverá confirmar a aceitação da vaga</li>
                        <li>Efetuar o pagamento da propina (ou primeira prestação)</li>
                        <li>Completar o processo de inscrição online</li>
                        <li>Participar na sessão de acolhimento</li>
                    </ol>
                    <p><strong>Nota:</strong> A não realização da matrícula dentro do prazo implica a perda da vaga.</p>
                </div>
            </div>

            <div class="contact-card">
                <h3 class="contact-title">Precisa de Ajuda?</h3>
                <p class="contact-info">Nossa equipa de admissões está disponível para esclarecer todas as suas dúvidas.</p>
                <p class="contact-info">
                    <i class="fas fa-phone-alt"></i> Telefone: <a href="tel:+351222333555" class="contact-link">+351 222 333
                        555</a>
                </p>
                <p class="contact-info">
                    <i class="fas fa-envelope"></i> Email: <a href="mailto:admissoes@istp-porto.pt"
                        class="contact-link">admissoes@istp-porto.pt</a>
                </p>
                <p class="contact-info">
                    <i class="fas fa-clock"></i> Horário: Seg-Sex 9h-18h | Sáb 9h-13h
                </p>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <h3>ISTP</h3>
                <p>Transformando ideias em inovação através da educação tecnológica de excelência.</p>
                <div class="social-icons-wrapper">
                    <ul class="social-icons-list">
                        <li class="icon instagram">
                            <span><i class="fab fa-instagram"></i></span>
                        </li>
                        <li class="icon github">
                            <span><i class="fab fa-github"></i></span>
                        </li>
                        <li class="icon youtube">
                            <span><i class="fab fa-youtube"></i></span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-column">
                <h3>Contato</h3>
                <p><i class="fas fa-phone"></i> +351 123 456 789</p>
                <p><i class="fas fa-envelope"></i> secretaria@istp.pt</p>
                <p><i class="fas fa-clock"></i> Seg - Sex, 9h - 18h</p>
            </div>
            <div class="footer-column">
                <h3>Endereço</h3>
                <p><i class="fas fa-map-marker-alt"></i> Rua da Tecnologia, 123</p>
                <p>Porto, Portugal</p>
                <p>Código 4000-000</p>
            </div>
            <div class="footer-column">
                <h3>Links Rápidos</h3>
                <a href="{{ url('courses') }}">Cursos</a>
                <a href="{{ url('info') }}">Candidatos</a>
                <a href="{{ url('contact') }}">Contacto</a>
                <a href="#">Eventos</a>
            </div>
        </div>
        <div class="copyright">
            <span>&copy; 2025 ISTP - Todos os direitos reservados.</span>
            <a href="https://www.livroreclamacoes.pt" target="_blank" class="complaint-book">
                <img src="{{ asset('images/livro.png') }}" alt="Livro de Reclamações"
                    style="width: 150px; height: auto;">
            </a>
        </div>
    </footer>

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
