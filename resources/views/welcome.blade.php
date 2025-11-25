@extends('layout.fe_master')
@section('content')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css'>
    <style>
        :root {
            --gradient-accent: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
            --primary-color: #f87808;
            --primary-dark: #9e5007;
            --text-dark: #343a40;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            height: 100%;
            background: var(--gradient-accent);
            background-size: 100% 100%;
            animation: gradientAnimation 1s ease infinite;
            color: black;
            overflow-x: hidden;
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .banner {
            height: 94vh;
            background-size: 300% 100%;
            background-position: 0% 50%;
            padding: 22%;
            text-align: center;
            color: rgb(255, 255, 255);
        }

        .banner h1 {
            font-size: 50px;
            margin: 0;
            font-weight: 900;
            text-shadow:
        3px 3px 5px rgba(0, 0, 0, 0.7),
        6px 6px 10px rgba(0, 0, 0, 0.5),
        0px 0px 15px rgba(0, 0, 0, 0.3);
        }

        .banner p {
            font-size: 20px;
            margin: 20px 0;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
        }

        .about-section {
            padding: 8rem 5%;
            background-color: #fff;
            color: var(--text-dark);
            position: relative;
        }

        .section-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 3rem;
            color: var(--primary-color);
            position: relative;
            display: inline-block;
            left: 50%;
            transform: translateX(-50%);
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), transparent);
            border-radius: 2px;
        }

        .about-content {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
            align-items: center;
        }

        .about-text {
            flex: 1;
            min-width: 300px;
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .about-image {
            flex: 1;
            min-width: 300px;
            height: 400px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .about-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .about-image:hover img {
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }

            .about-content {
                flex-direction: column;
            }

            .about-image {
                width: 100%;
                height: 300px;
            }
        }

        h2 {
            color: #f87808;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .spline-banner-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 1000px;
            z-index: -1;
            overflow: hidden;
        }

        .spline-banner-bg spline-viewer {
            width: 100%;
            height: 105%;
        }

        .stats-section {
            padding: 5rem 5%;
            background-color: #fff;
            color: var(--text-dark);
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 2rem;
        }

        .stat-item {
            text-align: center;
            min-width: 200px;
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.2rem;
            color: var(--text-dark);
        }

        footer {
            background-color: #f5f5f5;
            padding: 4rem 5% 2rem;
            color: var(--text-dark);
            border-top: 1px solid #ddd;
            position: relative;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 3rem;
        }

        .footer-column {
            flex: 1;
            min-width: 200px;
        }

        .footer-column h3 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background-color: var(--primary-color);
        }

        .footer-column p,
        .footer-column a {
            margin-bottom: 1rem;
            color: var(--text-dark);
            line-height: 1.6;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-column a:hover {
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .copyright {
            text-align: center;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid #ddd;
            color: #777;
            font-size: 0.9rem;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
        }

        .complaint-book {
            position: absolute;
            right: 5%;
            bottom: 20px;
            display: inline-block;
        }

        .social-icons-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
        }

        .social-icons-list {
            display: inline-flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .social-icons-list .icon {
            background: #ffffff;
            border-radius: 50%;
            padding: 12px;
            margin: 8px;
            width: 42px;
            height: 42px;
            font-size: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .social-icons-list .instagram:hover {
            background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
            color: #ffffff;
        }

        .social-icons-list .github:hover {
            background: linear-gradient(45deg, #6e5494, #503873, #2b2a49);
            color: #ffffff;
        }

        .social-icons-list .youtube:hover {
            background: linear-gradient(45deg, #ff0000, #e62117, #cc0000);
            color: #ffffff;
        }

        #btnTopo {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 99;
            background-color: var(--primary-color);
            color: white;
            border: none;
            outline: none;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            display: none;
            transition: all 0.3s ease;
        }

        #btnTopo:hover {
            background-color: var(--primary-dark);
            transform: translateY(-3px);
        }

        .reviews-section {
            padding: 8rem 5%;
            background-color: #f2f2f2;
            color: var(--text-dark);
        }

        .reviews-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2.5rem;
        }

        .carousel {
            position: relative;
            overflow: hidden;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .carousel-track {
            display: flex;
            gap: 2.5rem;
            animation: scrollCarousel 30s linear infinite;
        }

        .review-card {
            flex: 0 0 350px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .review-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        @keyframes scrollCarousel {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .carousel-fade {
            position: absolute;
            top: 0;
            left: 0;
            width: 120px;
            height: 100%;
            pointer-events: none;
            background: linear-gradient(to right, #f2f2f2 0%, transparent 100%);
            z-index: 2;
        }

        .carousel-fade.right {
            left: auto;
            right: 0;
            background: linear-gradient(to left, #f2f2f2 0%, transparent 100%);
        }

        .carousel-track::after {
            content: "";
            display: flex;
            width: 100%;
        }

        .review-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f2f2f2;
            margin: 0 auto 1.5rem;
        }

        .review-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .review-text p {
            font-style: italic;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .review-text h4 {
            margin: 0.5rem 0 0;
            color: var(--primary-color);
            font-weight: 600;
        }

        .review-text span {
            font-size: 0.95rem;
            color: #555;
        }

        .review-stars {
            color: #f87808;
            margin-bottom: 0.8rem;
        }

        .review-stars i {
            margin: 0 2px;
            font-size: 1.1rem;
        }
    </style>

    <canvas id="particles"></canvas>

    <div class="spline-banner-bg">
        <script type="module" src="https://unpkg.com/@splinetool/viewer@1.9.96/build/spline-viewer.js"></script>
        <spline-viewer url="https://prod.spline.design/O7pPnNjyvqQmU34n/scene.splinecode"></spline-viewer>
    </div>

    <div class="banner">
        <h1>Bem-vindo ao ISTP</h1>
        <div class="button-wrap">
            <button class="liquid-glass-button"
                onclick="document.getElementById('sobre-istp').scrollIntoView({ behavior: 'smooth' })">
                <span>Saber mais</span>
            </button>
            <div class="button-shadow"></div>
        </div>
    </div>

    <section class="about-section" id="sobre-istp">
        <div class="section-container">
            <h2 class="section-title">Sobre o ISTP</h2>
            <div class="about-content">
                <div class="about-text">
                    <p>O Instituto Superior de Tecnologias do Porto (ISTP) é uma instituição de ensino superior comprometida
                        com a formação de profissionais altamente qualificados e preparados para os desafios do século XXI.
                    </p>
                    <p>Fundado com o objetivo de fomentar a inovação e o desenvolvimento tecnológico na região do Porto e em
                        Portugal, o ISTP oferece cursos que combinam teoria sólida com práticas de vanguarda.</p>
                    <p>Nosso campus está situado numa das cidades mais dinâmicas e culturais de Portugal, proporcionando um
                        ambiente inspirador para o aprendizado e a pesquisa.</p>
                </div>
                <div class="about-image">
                    <img src="{{ asset('images/faculdade.png') }}" alt="Campus do ISTP">
                </div>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="section-container">
            <h2 class="section-title">Nossos Números</h2>
            <div class="stats-container">
                <div class="stat-item">
                    <div class="stat-number">95%</div>
                    <div class="stat-label">Empregabilidade</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">350+</div>
                    <div class="stat-label">Alunos</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Parcerias</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">11</div>
                    <div class="stat-label">Cursos</div>
                </div>
            </div>
        </div>
    </section>

    <div class="spline-bg" style="height: 800px">
        <script type="module" src="https://unpkg.com/@splinetool/viewer@1.9.96/build/spline-viewer.js"></script>
        <spline-viewer url="https://prod.spline.design/O7pPnNjyvqQmU34n/scene.splinecode"></spline-viewer>
    </div>

    <section class="reviews-section">
        <div class="section-container">
            <h2 class="section-title">Avaliações dos Alunos</h2>
            <div class="carousel">
                <div class="carousel-fade"></div>
                <div class="carousel-track">
                    <div class="review-card">
                        <div class="review-photo">
                            <img src="{{ asset('images/default.png') }}" alt="Foto do aluno João Silva">
                        </div>
                        <div class="review-text">
                            <p>"O ISTP superou as minhas expectativas! O ambiente é moderno e os professores estão sempre
                                disponíveis para ajudar. Aprendi imenso no curso de Desenvolvimento de Software."</p>
                            <div class="review-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4>João Silva</h4>
                        </div>
                    </div>

                    <div class="review-card">
                        <div class="review-photo">
                            <img src="{{ asset('images/default.png') }}" alt="Foto da aluna Marta Costa">
                        </div>
                        <div class="review-text">
                            <p>"Graças ao ISTP, consegui o meu primeiro emprego na área logo após o estágio. Recomendo a
                                todos
                                que procuram uma formação prática e de qualidade."</p>
                            <div class="review-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4>Marta Costa</h4>
                        </div>
                    </div>

                    <div class="review-card">
                        <div class="review-photo">
                            <img src="{{ asset('images/default.png') }}" alt="Foto do aluno Ricardo Lopes">
                        </div>
                        <div class="review-text">
                            <p>"As parcerias do ISTP com empresas tecnológicas abriram portas incríveis para a minha
                                carreira. É
                                uma faculdade que realmente investe nos alunos."</p>
                            <div class="review-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4>Ricardo Lopes</h4>
                        </div>
                    </div>

                    <div class="review-card">
                        <div class="review-photo">
                            <img src="{{ asset('images/default.png') }}" alt="Foto da aluna Sofia Almeida">
                        </div>
                        <div class="review-text">
                            <p>"As aulas práticas e os projetos em grupo foram fundamentais para o meu desenvolvimento
                                profissional. Recomendo!"</p>
                            <div class="review-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4>Sofia Almeida</h4>
                        </div>
                    </div>
                </div>
                <div class="carousel-fade right"></div>
            </div>
        </div>
    </section>

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
        const track = document.querySelector('.carousel-track');
        if (track) {
            track.innerHTML += track.innerHTML;
        }

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

        const btnTopo = document.getElementById("btnTopo");

        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) {
                btnTopo.style.display = "block";
            } else {
                btnTopo.style.display = "none";
            }
        });

        btnTopo.addEventListener("click", () => {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    </script>
@endsection
