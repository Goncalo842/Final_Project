@extends('layout.fe_master')
@section('content')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css'>
    <style>
        :root {
            --primary: #df7c04;
            --primary-color: #f87808;
            --light-orange: #ff9a3c;
            --light-gray: #f5f5f5;
            --dark: #333333;
            --white: #ffffff;
        }

        body {
            background: linear-gradient(135deg, #e0e0e0, #d0d0d0);
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
        }

        .explore-header {
            padding: 1.5rem 2rem 0.5rem;
            backdrop-filter: blur(5px);
            margin-bottom: 2rem;
        }

        .explore-header h2 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .category-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .category-buttons a {
            padding: 0.8rem 1.8rem;
            background: var(--white);
            border-radius: 2rem;
            color: var(--dark);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            border: 2px solid var(--light-gray);
        }

        .category-buttons a:hover,
        .category-buttons a.active {
            background: var(--primary);
            color: var(--white);
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(223, 124, 4, 0.2);
            border-color: var(--primary);
        }

        .section {
            padding: 3rem 1rem;
            position: relative;
        }

        .section:nth-child(3) {
            background: var(--white);
        }

        .section:not(:nth-child(3)) {
            background: transparent;
        }

        .section h3 {
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 2rem;
            color: var(--dark);
            position: relative;
        }

        .section h3::after {
            content: "";
            display: block;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--light-orange));
            margin: 1rem auto 0;
            border-radius: 2px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            border: none;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 30px rgba(223, 124, 4, 0.25);
        }

        .card::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--light-orange));
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.4s ease;
        }

        .card:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .card:hover img {
            transform: scale(1.08);
        }

        .card-content {
            padding: 1.5rem;
            text-align: center;
            position: relative;
        }

        .card h4 {
            margin: 0;
            color: var(--dark);
            font-size: 1.2rem;
            transition: color 0.3s;
            position: relative;
            z-index: 1;
        }

        .card:hover h4 {
            color: var(--primary);
        }

        .card p {
            margin: 0.8rem 0 0;
            color: var(--dark);
            opacity: 0.9;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                gap: 1.5rem;
            }

            .explore-programs h2 {
                font-size: 1.8rem;
            }

            .section h3 {
                font-size: 1.5rem;
            }
        }

        footer {
            background-color: #f5f5f5;
            padding: 4rem 5% 2rem;
            color: var(--text-dark);
            border-top: 1px solid #ddd;
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

        .footer-column p {
            margin-bottom: 1rem;
            color: var(--text-dark);
            line-height: 1.6;
        }

        .footer-column a {
            margin-bottom: 1rem;
            display: block;
            color: var(--text-dark);
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
        }

        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                gap: 2rem;
            }

            .footer-column {
                min-width: 100%;
            }

            .footer-column h3 {
                margin-bottom: 1rem;
            }
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
    </style>

    <canvas id="particles"></canvas>

    <div class="content-wrapper">
        <section class="explore-header">
            <div class="category-buttons">
                <a href="{{ route('courses') }}" class="active">Todos</a>
                <a href="{{ route('courses.licenciatura') }}">Licenciatura</a>
                <a href="{{ route('courses.ctesp') }}">CTeSP</a>
                <a href="{{ route('courses.posgraduacao') }}">Pós-Graduação</a>
            </div>
        </section>

        <section class="section">
            <h3>Licenciaturas</h3>
            <div class="grid">
                <a href="{{ route('informatica') }}" class="card">
                    <img src="{{ asset('images/imagem15.jpg') }}" alt="Engenharia Informática">
                    <div class="card-content">
                        <h4>Engenharia Informática</h4>
                        <p>Formação avançada em desenvolvimento de software e sistemas</p>
                    </div>
                </a>
                <a href="{{ route('multimedia') }}" class="card">
                    <img src="{{ asset('images/imagem10.jpg') }}" alt="Engenharia Multimédia">
                    <div class="card-content">
                        <h4>Engenharia de Multimédia</h4>
                        <p>Criação de conteúdos digitais interativos e imersivos</p>
                    </div>
                </a>
            </div>
        </section>

        <section class="section">
            <h3>CTeSP</h3>
            <div class="grid">
                <a href="{{ route('cs') }}" class="card">
                    <img src="{{ asset('images/imagem20.jpg') }}" alt="Cibersegurança">
                    <div class="card-content">
                        <h4>Cibersegurança</h4>
                        <p>Proteção de sistemas e redes contra ameaças digitais</p>
                    </div>
                </a>
                <a href="{{ route('ria') }}" class="card">
                    <img src="{{ asset('images/imagem12.jpg') }}" alt="Robótica">
                    <div class="card-content">
                        <h4>Robótica e IA</h4>
                        <p>Desenvolvimento de sistemas inteligentes e autônomos</p>
                    </div>
                </a>
                <a href="{{ route('dmm') }}" class="card">
                    <img src="{{ asset('images/imagem18.jpg') }}" alt="Multimédia">
                    <div class="card-content">
                        <h4>Desenvolvimento Multimédia</h4>
                        <p>Criação de produtos digitais interativos</p>
                    </div>
                </a>
                <a href="{{ route('dm') }}" class="card">
                    <img src="{{ asset('images/imagem13.jpeg') }}" alt="Mobile">
                    <div class="card-content">
                        <h4>Desenvolvimento Mobile</h4>
                        <p>Criação de aplicações para smartphones e tablets</p>
                    </div>
                </a>
                <a href="{{ route('ig') }}" class="card">
                    <img src="{{ asset('images/imagem14.jpg') }}" alt="Informática">
                    <div class="card-content">
                        <h4>Informática de Gestão</h4>
                        <p>Integração de TI com gestão empresarial</p>
                    </div>
                </a>
                <a href="{{ route('rs') }}" class="card">
                    <img src="{{ asset('images/imagem16.jpg') }}" alt="Redes">
                    <div class="card-content">
                        <h4>Redes e Sistemas</h4>
                        <p>Implementação e manutenção de infraestruturas de rede</p>
                    </div>
                </a>
                <a href="{{ route('ds') }}" class="card">
                    <img src="{{ asset('images/imagem11.jpeg') }}" alt="Software">
                    <div class="card-content">
                        <h4>Desenvolvimento de Software</h4>
                        <p>Criação de aplicações e sistemas informáticos</p>
                    </div>
                </a>
            </div>
        </section>

        <section class="section">
            <h3>Pós-Graduações</h3>
            <div class="grid">
                <a href="{{ route('cloud') }}" class="card">
                    <img src="{{ asset('images/imagem17.jpg') }}" alt="Cloud">
                    <div class="card-content">
                        <h4>Cloud Computing</h4>
                        <p>Especialização em tecnologias de nuvem e virtualização</p>
                    </div>
                </a>
                <a href="{{ route('business') }}" class="card">
                    <img src="{{ asset('images/imagem19.jpg') }}" alt="Business">
                    <div class="card-content">
                        <h4>Business Analytics</h4>
                        <p>Análise de dados para suporte à decisão empresarial</p>
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
                <a href="#">Cursos</a>
                <a href="#">Admissões</a>
                <a href="#">Bolsa de Estudos</a>
                <a href="#">Eventos</a>
            </div>
        </div>
        <div class="copyright">
            &copy; 2025 ISTP - Todos os direitos reservados.
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
    </script>
@endsection
