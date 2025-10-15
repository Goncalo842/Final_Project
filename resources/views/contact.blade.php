@extends('layout.fe_master')
@section('content')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css'>
    <style>
        :root {
            --primary-color: #f87808;
            --primary-light: #ff9a3c;
            --primary-dark: #9e5007;
            --text-dark: #2d3748;
            --text-medium: #4a5568;
            --text-light: #718096;
            --light-bg: #fcfaf8;
            --white: #ffffff;
            --gray-light: #f9f5f1;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.12);
            --border-radius: 12px;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
            line-height: 1.6;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
            opacity: 0.8;
        }

        .contact-hero {
            padding: 6rem 2rem;
            text-align: center;
            color: white;
            clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
            margin-bottom: 3rem;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-title {
            font-size: 2.75rem;
            font-weight: 700;
            color: #9e5007;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: #343a40;
            margin-bottom: 2rem;
            font-weight: 400;
        }

        .cta-button {
            display: inline-block;
            background-color: white;
            color: var(--primary-dark);
            padding: 0.75rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            box-shadow: var(--shadow-md);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .contact-container {
            max-width: 1200px;
            margin: 0 auto 5rem;
            padding: 0 2rem;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 1rem;
            position: relative;
        }

        .section-title:after {
            content: '';
            position: absolute;
            width: 60px;
            height: 4px;
            background: var(--primary-color);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .section-subtitle {
            color: var(--text-medium);
            max-width: 600px;
            margin: 0 auto;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .contact-card {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            border-top: 4px solid var(--primary-color);
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .card-header {
            padding: 1.5rem;
            display: flex;
            align-items: center;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: white;
            background: var(--primary-color);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            color: var(--primary-dark);
        }

        .card-body {
            padding: 1.5rem;
        }

        .contact-info {
            margin-bottom: 1.5rem;
        }

        .info-label {
            font-size: 0.875rem;
            color: var(--text-light);
            margin-bottom: 0.25rem;
            font-weight: 500;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 500;
        }

        .info-value a {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .info-value a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .map-section {
            max-width: 1200px;
            margin: 0 auto 5rem;
            padding: 0 2rem;
        }

        .map-container {
            height: 400px;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .contact-form-section {
            background: var(--white);
            padding: 4rem 2rem;
            margin-bottom: 5rem;
        }

        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            padding: 2.5rem;
        }

        .form-title {
            font-size: 1.75rem;
            color: var(--primary-dark);
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #f0e9e2;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(248, 120, 8, 0.1);
        }

        textarea.form-control {
            min-height: 150px;
        }

        .submit-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.875rem 2rem;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
        }

        .submit-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .contact-hours {
            background: var(--gray-light);
            padding: 2rem;
            border-radius: var(--border-radius);
            margin-top: 2rem;
        }

        .hours-title {
            font-size: 1.25rem;
            color: var(--primary-dark);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .hours-list {
            list-style: none;
            padding: 0;
        }

        .hours-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .hours-item:last-child {
            border-bottom: none;
        }

        .day {
            font-weight: 500;
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
            .contact-hero {
                padding: 4rem 1.5rem;
                clip-path: polygon(0 0, 100% 0, 100% 95%, 0 100%);
            }

            .hero-title {
                font-size: 2.25rem;
            }

            .form-container {
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .contact-hero {
                clip-path: polygon(0 0, 100% 0, 100% 97%, 0 100%);
            }

            .hero-title {
                font-size: 2rem;
            }

            .card-header {
                flex-direction: column;
                text-align: center;
            }

            .card-icon {
                margin: 0 auto 1rem;
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

    <section class="contact-hero">
        <div class="hero-content">
            <h1 class="hero-title">Contacte o ISTP Porto</h1>
            <p class="hero-subtitle">Estamos aqui para responder a todas as suas questões. Utilize os nossos canais de
                contacto ou visite-nos nas nossas instalações.</p>
        </div>
    </section>

    <div class="contact-container">
        <div class="contact-grid">
            <div class="contact-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 class="card-title">Localização</h3>
                </div>
                <div class="card-body">
                    <div class="contact-info">
                        <div class="info-label">Instituição</div>
                        <div class="info-value">ISTP – Instituto Superior de Tecnologias do Porto</div>
                    </div>
                    <div class="contact-info">
                        <div class="info-label">Morada</div>
                        <div class="info-value">4050-037 Porto, Portugal</div>
                    </div>
                    <div class="contact-info">
                        <div class="info-label">Transportes</div>
                        <div class="info-value">Metro: Combatentes <br>Autocarros: 300, 701, 505, 606</div>
                    </div>
                </div>
            </div>

            <div class="contact-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3 class="card-title">Contactos</h3>
                </div>
                <div class="card-body">
                    <div class="contact-info">
                        <div class="info-label">Telefone Geral</div>
                        <div class="info-value"><a href="tel:+351222333444">+351 222 333 444</a></div>
                    </div>
                    <div class="contact-info">
                        <div class="info-label">Apoio ao Estudante</div>
                        <div class="info-value"><a href="tel:+351222333555">+351 222 333 555</a></div>
                    </div>
                    <div class="contact-info">
                        <div class="info-label">Telefone</div>
                        <div class="info-value"><a href="tel:+351222333666">+351 222 333 666</a></div>
                    </div>
                </div>
            </div>

            <div class="contact-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3 class="card-title">Email</h3>
                </div>
                <div class="card-body">
                    <div class="contact-info">
                        <div class="info-label">Geral</div>
                        <div class="info-value"><a href="mailto:geral@istp-porto.pt">geral@istp-porto.pt</a></div>
                    </div>
                    <div class="contact-info">
                        <div class="info-label">Admissões</div>
                        <div class="info-value"><a href="mailto:admissoes@istp-porto.pt">admissoes@istp-porto.pt</a></div>
                    </div>
                    <div class="contact-info">
                        <div class="info-label">Suporte Técnico</div>
                        <div class="info-value"><a
                                href="mailto:suporte.tecnico@istp-porto.pt">suporte.tecnico@istp-porto.pt</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="contact-form-section">
        <div class="form-container">
            <h3 class="form-title">Envie-nos uma Mensagem</h3>
            <form>
                <div class="form-group">
                    <label for="name" class="form-label">Nome Completo</label>
                    <input type="text" id="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="subject" class="form-label">Assunto</label>
                    <input type="text" id="subject" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="message" class="form-label">Mensagem</label>
                    <textarea id="message" class="form-control" required></textarea>
                </div>
                <div class="form-group" style="text-align: center;">
                    <button type="submit" class="submit-btn">Enviar Mensagem</button>
                </div>
            </form>

            <div class="contact-hours">
                <h4 class="hours-title">Horário de Atendimento</h4>
                <ul class="hours-list">
                    <li class="hours-item">
                        <span class="day">Segunda a Sexta</span>
                        <span class="time">09:00 - 18:00</span>
                    </li>
                    <li class="hours-item">
                        <span class="day">Sábado</span>
                        <span class="time">09:00 - 13:00</span>
                    </li>
                    <li class="hours-item">
                        <span class="day">Domingo</span>
                        <span class="time">Encerrado</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section class="map-section">
        <div class="section-header">
            <h3 class="section-title">Como Chegar</h3>
            <p class="section-subtitle">Visite-nos no coração da cidade do Porto, com excelentes acessos e transportes
                públicos.</p>
        </div>

        <div class="map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.4974627828546!2d-8.613847584679883!3d41.14673797929637!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd24644c3bf40281%3A0x6f7b9b4e82e7d5e!2sInstituto%20Superior%20de%20Tecnologias%20do%20Porto%20(ISTP)!5e0!3m2!1spt-PT!2spt!4v1690912300000!5m2!1spt-PT!2spt"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
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
                <a href="#">Cursos</a>
                <a href="#">Candidatos</a>
                <a href="#">Contacto</a>
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
                        ctx.strokeStyle = "#ffffff";
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
            for (let i = 0; i < total; i++) {
                particles.push(new Particle());
            }
            animate();
        }

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });

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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
