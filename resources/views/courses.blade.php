@extends('layout.fe_master')
@section('content')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css'>
    <style>
        :root {
            --color-licenciatura: #df7c04;
            --color-ctesp: #df7c04;
            --color-posgraduacao: #df7c04;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
            background: var(--gradient-accent);
            background-attachment: fixed;
            color: black;
            overflow-x: hidden;
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
        }

        .explore-header {
            padding: 2rem 0 1rem;
            backdrop-filter: blur(5px);
            margin-bottom: 2rem;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 2rem;
            padding-right: 2rem;
        }

        .page-title {
            text-align: center;
            font-size: 2.8rem;
            font-weight: 800;
            color: #9e5007;
            margin-bottom: 1rem;
            text-shadow: none;
            letter-spacing: -0.5px;
        }

        .page-subtitle {
            text-align: center;
            font-size: 1.1rem;
            color: var(--dark-gray);
            margin-bottom: 2rem;
            font-weight: 400;
        }

        .category-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin: 2rem 0;
        }

        .category-buttons a {
            padding: 1rem 2.5rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 50px;
            color: var(--dark);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 2px solid rgba(0, 0, 0, 0.05);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .category-buttons a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .category-buttons a:hover::before {
            left: 100%;
        }

        .category-buttons a:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border-color: #df7c04;
        }

        .category-buttons a.active {
            background: #df7c04;
            color: white;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 30px rgba(223, 124, 4, 0.3);
            border-color: #df7c04;
        }

        .category-buttons a i {
            margin-right: 0.5rem;
            font-size: 1rem;
        }

        .section {
            padding: 3rem 2rem;
            position: relative;
            display: none;
            margin-bottom: 2rem;
            width: 100%;
        }

        .section.active {
            display: block;
            animation: fadeInUp 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section[data-section="licenciatura"] {
            background: transparent;
        }

        .section[data-section="ctesp"] {
            background: rgb(255, 255, 255);
        }

        .section[data-section="posgraduacao"] {
            background: transparent;
        }

        .section h3 {
            font-size: 2.2rem;
            text-align: center;
            margin-bottom: 6rem;
            color: var(--dark);
            position: relative;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .section h3::after {
            content: "";
            display: block;
            width: 100px;
            height: 6px;
            background: linear-gradient(90deg, #df7c04, #ff8c42);
            position: absolute;
            left: 50%;
            top: 100%;
            margin-top: 1.5rem;
            transform: translateX(-50%);
            border-radius: 3px;
            box-shadow: 0 3px 15px rgba(223, 124, 4, 0.4);
        }

        .section h3::before {
            content: attr(data-count);
            position: absolute;
            left: 50%;
            top: 100%;
            margin-top: 3.5rem;
            transform: translateX(-50%);
            font-size: 0.75rem;
            color: white;
            background: linear-gradient(135deg, #df7c04, #ff8c42);
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2.5rem;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .card {
            background: white;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            border: 2px solid rgba(255, 255, 255, 0.8);
            opacity: 0;
            transform: translateY(30px);
        }

        .card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            border-color: #df7c04;
        }

        .section[data-section="licenciatura"] .card:hover {
            box-shadow: 0 25px 50px rgba(223, 124, 4, 0.3);
        }

        .section[data-section="ctesp"] .card:hover {
            box-shadow: 0 25px 50px rgba(223, 124, 4, 0.3);
        }

        .section[data-section="posgraduacao"] .card:hover {
            box-shadow: 0 25px 50px rgba(223, 124, 4, 0.3);
        }

        .card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(223, 124, 4, 0.03), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 1;
        }

        .card:hover::before {
            opacity: 1;
        }

        .card-image-wrapper {
            position: relative;
            overflow: hidden;
            height: 220px;
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
            filter: brightness(0.9) contrast(1.1);
        }

        .card:hover img {
            transform: scale(1.15) rotate(2deg);
            filter: brightness(1) contrast(1.2);
        }

        .card-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: linear-gradient(135deg, #df7c04, #ff8c42);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.75rem;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(223, 124, 4, 0.3);
            z-index: 2;
        }

        .card-content {
            padding: 2rem;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .card h4 {
            margin: 0 0 1rem;
            color: var(--dark);
            font-size: 1.35rem;
            transition: color 0.3s;
            position: relative;
            z-index: 1;
            font-weight: 700;
            line-height: 1.4;
        }

        .card:hover h4 {
            color: #df7c04;
        }

        .card p {
            margin: 0;
            color: var(--dark);
            opacity: 0.75;
            font-size: 0.95rem;
            line-height: 1.7;
            font-weight: 400;
        }

        .card-icon {
            position: absolute;
            bottom: 1.5rem;
            right: 1.5rem;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(223, 124, 4, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            opacity: 0;
        }

        .card:hover .card-icon {
            opacity: 1;
            transform: rotate(45deg);
        }

        .card-icon i {
            font-size: 1.2rem;
            color: #df7c04;
        }

        @media (max-width: 768px) {
            .explore-header {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .page-subtitle {
                font-size: 1rem;
            }

            .category-buttons a {
                padding: 0.8rem 1.5rem;
                font-size: 0.85rem;
            }

            .section {
                padding: 2rem 1rem;
            }

            .section h3 {
                font-size: 1.8rem;
                margin-bottom: 5rem;
            }

            .grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                gap: 1.5rem;
                padding: 0 1rem;
            }

            .card-image-wrapper {
                height: 180px;
            }
        }
    </style>

    <canvas id="particles"></canvas>

    <div class="content-wrapper">
        <section class="explore-header">
            <h1 class="page-title">Nossos Cursos</h1>
            <p class="page-subtitle">Explore nossa oferta formativa de excelência em tecnologia</p>

            <div class="category-buttons">
                <a href="#" class="filter-btn active" data-category="all">
                    <i class="fas fa-th"></i> Todos os Cursos
                </a>
                <a href="#" class="filter-btn" data-category="licenciatura">
                    <i class="fas fa-graduation-cap"></i> Licenciaturas
                </a>
                <a href="#" class="filter-btn" data-category="ctesp">
                    <i class="fas fa-certificate"></i> CTeSP
                </a>
                <a href="#" class="filter-btn" data-category="posgraduacao">
                    <i class="fas fa-user-graduate"></i> Pós-Graduações
                </a>
            </div>
        </section>

        <section class="section active" data-section="licenciatura">
            <h3 data-count="2 Cursos">Licenciaturas</h3>
            <div class="grid">
                <a href="{{ route('informatica') }}" class="card">
                    <div class="card-image-wrapper">
                        <img src="{{ asset('images/imagem15.jpg') }}" alt="Engenharia Informática">
                        <span class="card-badge">3 Anos</span>
                    </div>
                    <div class="card-content">
                        <h4>Engenharia Informática</h4>
                        <p>Formação avançada em desenvolvimento de software e sistemas computacionais</p>
                        <div class="card-icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
                <a href="{{ route('multimedia') }}" class="card">
                    <div class="card-image-wrapper">
                        <img src="{{ asset('images/imagem10.jpg') }}" alt="Engenharia Multimédia">
                        <span class="card-badge">3 Anos</span>
                    </div>
                    <div class="card-content">
                        <h4>Engenharia de Multimédia</h4>
                        <p>Criação de conteúdos digitais interativos e experiências imersivas</p>
                        <div class="card-icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <section class="section active" data-section="ctesp">
            <h3 data-count="7 Cursos">CTeSP</h3>
            <div class="grid">
                <a href="{{ route('cs') }}" class="card">
                    <div class="card-image-wrapper">
                        <img src="{{ asset('images/imagem20.jpg') }}" alt="Cibersegurança">
                        <span class="card-badge">2 Anos</span>
                    </div>
                    <div class="card-content">
                        <h4>Cibersegurança</h4>
                        <p>Proteção de sistemas e redes contra ameaças digitais avançadas</p>
                        <div class="card-icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
                <a href="{{ route('ria') }}" class="card">
                    <div class="card-image-wrapper">
                        <img src="{{ asset('images/imagem12.jpg') }}" alt="Robótica">
                        <span class="card-badge">2 Anos</span>
                    </div>
                    <div class="card-content">
                        <h4>Robótica e IA</h4>
                        <p>Desenvolvimento de sistemas inteligentes e autônomos de última geração</p>
                        <div class="card-icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
                <a href="{{ route('dmm') }}" class="card">
                    <div class="card-image-wrapper">
                        <img src="{{ asset('images/imagem18.jpg') }}" alt="Multimédia">
                        <span class="card-badge">2 Anos</span>
                    </div>
                    <div class="card-content">
                        <h4>Desenvolvimento Multimédia</h4>
                        <p>Criação de produtos digitais interativos e soluções criativas</p>
                        <div class="card-icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
                <a href="{{ route('dm') }}" class="card">
                    <div class="card-image-wrapper">
                        <img src="{{ asset('images/imagem13.jpeg') }}" alt="Mobile">
                        <span class="card-badge">2 Anos</span>
                    </div>
                    <div class="card-content">
                        <h4>Desenvolvimento Mobile</h4>
                        <p>Criação de aplicações nativas para smartphones e tablets</p>
                        <div class="card-icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
                <a href="{{ route('ig') }}" class="card">
                    <div class="card-image-wrapper">
                        <img src="{{ asset('images/imagem14.jpg') }}" alt="Informática">
                        <span class="card-badge">2 Anos</span>
                    </div>
                    <div class="card-content">
                        <h4>Informática de Gestão</h4>
                        <p>Integração estratégica de TI com gestão empresarial moderna</p>
                        <div class="card-icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
                <a href="{{ route('rs') }}" class="card">
                    <div class="card-image-wrapper">
                        <img src="{{ asset('images/imagem16.jpg') }}" alt="Redes">
                        <span class="card-badge">2 Anos</span>
                    </div>
                    <div class="card-content">
                        <h4>Redes e Sistemas</h4>
                        <p>Implementação e manutenção de infraestruturas de rede complexas</p>
                        <div class="card-icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
                <a href="{{ route('ds') }}" class="card">
                    <div class="card-image-wrapper">
                        <img src="{{ asset('images/imagem11.jpeg') }}" alt="Software">
                        <span class="card-badge">2 Anos</span>
                    </div>
                    <div class="card-content">
                        <h4>Desenvolvimento de Software</h4>
                        <p>Criação profissional de aplicações e sistemas informáticos</p>
                        <div class="card-icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <section class="section active" data-section="posgraduacao">
            <h3 data-count="2 Cursos">Pós-Graduações</h3>
            <div class="grid">
                <a href="{{ route('cloud') }}" class="card">
                    <div class="card-image-wrapper">
                        <img src="{{ asset('images/imagem17.jpg') }}" alt="Cloud">
                        <span class="card-badge">1 Ano</span>
                    </div>
                    <div class="card-content">
                        <h4>Cloud Computing</h4>
                        <p>Especialização avançada em tecnologias de nuvem e virtualização</p>
                        <div class="card-icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
                <a href="{{ route('business') }}" class="card">
                    <div class="card-image-wrapper">
                        <img src="{{ asset('images/imagem19.jpg') }}" alt="Business">
                        <span class="card-badge">1 Ano</span>
                    </div>
                    <div class="card-content">
                        <h4>Business Analytics</h4>
                        <p>Análise estratégica de dados para suporte à decisão empresarial</p>
                        <div class="card-icon">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>
        </section>
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
                <a href="{{ route('courses') }}">Cursos</a>
                <a href="{{ route('info') }}">Candidatos</a>
                <a href="{{ route('contact') }}">Contacto</a>
                <a href="{{ route('eventos') }}">Eventos</a>
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
                        ctx.strokeStyle = "rgba(255, 255, 255, 0.3)";
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

        window.addEventListener('resize', () => {
            resizeCanvas();
        });

        init();

        function animateCards(section) {
            const cards = section.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.classList.remove('show');
                setTimeout(() => {
                    card.classList.add('show');
                }, index * 100);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const sections = document.querySelectorAll('.section[data-section]');

            sections.forEach(section => {
                if (section.classList.contains('active')) {
                    animateCards(section);
                }
            });

            filterButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    const category = this.getAttribute('data-category');

                    sections.forEach(section => {
                        const sectionCategory = section.getAttribute('data-section');

                        if (category === 'all') {
                            section.classList.add('active');
                            setTimeout(() => animateCards(section), 50);
                        } else if (sectionCategory === category) {
                            section.classList.add('active');
                            setTimeout(() => animateCards(section), 50);
                        } else {
                            section.classList.remove('active');
                        }
                    });
                });
            });
        });
    </script>
@endsection
