@extends('layout.fe_master')
@section('content')
    <style>
        :root {
            --primary-color: #ff6b00;
            --secondary-color: #fafafa;
            --accent-color: #ff9e40;
            --text-color: #333;
            --light-gray: #f5f5f5;
            --medium-gray: #e0e0e0;
            --dark-gray: #666;
            --gradient-accent: linear-gradient(135deg, #e3e2e2, #c4c4c4, #e3e2e2);
            --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            --hover-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background: var(--gradient-accent);
            min-height: 100vh;
            color: var(--text-color);
            overflow-x: hidden;
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 1;
            pointer-events: none;
        }

        .hero-section {
            padding: 80px 20px;
            text-align: center;
            margin-bottom: 50px;
            position: relative;
            overflow: hidden;
            z-index: 2;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--light-gray);
            opacity: 0.8;
            z-index: -1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--text-color);
            margin-bottom: 15px;
            letter-spacing: -1px;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--dark-gray);
            font-weight: 400;
            line-height: 1.6;
        }

        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 2;
        }

        .events-card-container {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            padding: 40px;
            margin-bottom: 40px;
            border: 1px solid var(--medium-gray);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--light-gray);
        }

        .section-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text-color);
            margin: 0;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -22px;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .events-count {
            background: var(--light-gray);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 1rem;
            color: var(--dark-gray);
            font-weight: 600;
            border: 1px solid var(--medium-gray);
        }

        .filter-section {
            margin-bottom: 30px;
        }

        .filter-title {
            font-size: 1rem;
            color: var(--dark-gray);
            margin-bottom: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 24px;
            border: 2px solid var(--medium-gray);
            background: white;
            color: var(--dark-gray);
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .filter-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        .filter-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.2);
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .event-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
            border: 1px solid var(--medium-gray);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .event-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--hover-shadow);
            border-color: var(--primary-color);
        }

        .event-card.past {
            opacity: 0.9;
            pointer-events: none;
        }

        .event-image {
            height: 200px;
            overflow: hidden;
            position: relative;
            background: var(--light-gray);
        }

        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .event-card:hover .event-image img {
            transform: scale(1.05);
        }

        .event-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(26, 26, 26, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .event-date {
            position: absolute;
            top: 15px;
            right: 15px;
            background: white;
            color: var(--text-color);
            padding: 10px 15px;
            border-radius: 10px;
            text-align: center;
            z-index: 2;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--medium-gray);
        }

        .event-date .day {
            font-size: 1.3rem;
            font-weight: 800;
            display: block;
            line-height: 1;
            color: var(--primary-color);
        }

        .event-date .month {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            color: var(--dark-gray);
        }

        .event-content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .event-title {
            font-size: 1.3rem;
            color: var(--text-color);
            margin-bottom: 12px;
            font-weight: 700;
            line-height: 1.4;
            min-height: 60px;
        }

        .event-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            font-size: 0.9rem;
            color: var(--dark-gray);
        }

        .event-meta-item i {
            color: var(--primary-color);
            width: 16px;
            text-align: center;
        }

        .event-description {
            color: var(--dark-gray);
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 0.95rem;
            flex-grow: 1;
        }

        .event-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid var(--light-gray);
            margin-top: auto;
        }

        .event-price {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--primary-color);
        }

        .event-price.free {
            color: #27ae60;
        }

        .btn-primary {
            padding: 10px 24px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-primary:hover {
            background: #e65c00;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.3);
        }

        .btn-primary:disabled,
        .btn-primary.ended {
            background: var(--medium-gray);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .countdown-section {
            background: var(--light-gray);
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--medium-gray);
        }

        .countdown-title {
            font-size: 1.5rem;
            margin-bottom: 25px;
            color: var(--text-color);
            font-weight: 600;
        }

        .countdown {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .countdown-item {
            text-align: center;
        }

        .countdown-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            line-height: 1;
            margin-bottom: 5px;
            font-family: 'Courier New', monospace;
        }

        .countdown-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--dark-gray);
            font-weight: 600;
        }

        @media (max-width: 1200px) {
            .events-grid {
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-section {
                padding: 60px 15px;
            }

            .events-card-container {
                padding: 25px;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .events-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .countdown {
                flex-wrap: wrap;
                gap: 15px;
            }

            .countdown-number {
                font-size: 2rem;
            }

            .filter-buttons {
                gap: 8px;
            }

            .filter-btn {
                padding: 8px 16px;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .events-card-container {
                padding: 20px;
            }

            .section-title {
                font-size: 1.6rem;
            }

            .countdown-number {
                font-size: 1.8rem;
            }
        }
    </style>
    <br>
    <br>
    <br>
    <canvas id="particles"></canvas>

    <div class="main-container">
        <div class="events-card-container">
            <section class="upcoming-events">
                <div class="section-header">
                    <h2 class="section-title">Próximos Eventos</h2>
                    <div class="events-count" id="upcoming-count">3 eventos</div>
                </div>

                <div class="filter-section">
                    <div class="filter-title">Filtrar por categoria:</div>
                    <div class="filter-buttons">
                        <button class="filter-btn active" data-filter="all">Todos</button>
                        <button class="filter-btn" data-filter="ia">Inteligência Artificial</button>
                        <button class="filter-btn" data-filter="robotica">Robótica</button>
                        <button class="filter-btn" data-filter="mobile">Desenvolvimento Mobile</button>
                        <button class="filter-btn" data-filter="chatbot">Chatbots</button>
                        <button class="filter-btn" data-filter="web">Desenvolvimento Web</button>
                    </div>
                </div>

                <div class="countdown-section">
                    <h3 class="countdown-title" id="next-event-title">Próximo: Workshop de Inteligência Artificial</h3>
                    <div class="countdown">
                        <div class="countdown-item">
                            <div class="countdown-number" id="days">05</div>
                            <div class="countdown-label">Dias</div>
                        </div>
                        <div class="countdown-item">
                            <div class="countdown-number" id="hours">12</div>
                            <div class="countdown-label">Horas</div>
                        </div>
                        <div class="countdown-item">
                            <div class="countdown-number" id="minutes">30</div>
                            <div class="countdown-label">Minutos</div>
                        </div>
                        <div class="countdown-item">
                            <div class="countdown-number" id="seconds">45</div>
                            <div class="countdown-label">Segundos</div>
                        </div>
                    </div>
                </div>

                <div class="events-grid" id="upcoming-events-grid">
                    <div class="event-card" data-category="ia" data-date="2025-02-15 14:00:00">
                        <div class="event-date">
                            <span class="day">15</span>
                            <span class="month">FEV</span>
                        </div>
                        <div class="event-image">
                            <img src="https://images.unsplash.com/photo-1677442136019-21780ecad995?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80"
                                alt="Workshop de Inteligência Artificial">
                        </div>
                        <div class="event-content">
                            <h3 class="event-title">Workshop de Inteligência Artificial</h3>
                            <div class="event-meta">
                                <div class="event-meta-item"><i class="fas fa-clock"></i><span>14:00</span></div>
                                <div class="event-meta-item"><i class="fas fa-map-marker-alt"></i><span>ISTP - Laboratório
                                        de IA</span></div>
                                <div class="event-meta-item spots-left">
                                    <i class="fas fa-users"></i>
                                    <span>30 vagas restantes</span>
                                </div>
                            </div>
                            <p class="event-description">Aprenda fundamentos de IA, Machine Learning e Deep Learning.
                                Projetos práticos com Python, TensorFlow e redes neurais.</p>
                            <div class="event-footer">
                                <div class="event-price">€ 25,00</div>
                                <div class="event-actions">
                                    <button class="btn-primary register-btn" data-event-id="1" data-initial-spots="30">
                                        <i class="fas fa-ticket-alt"></i>
                                        INSCREVER
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="event-card" data-category="robotica" data-date="2025-02-20 10:00:00">
                        <div class="event-date">
                            <span class="day">20</span>
                            <span class="month">FEV</span>
                        </div>
                        <div class="event-image">
                            <img src="https://images.unsplash.com/photo-1485827404703-89b55fcc595e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80"
                                alt="Workshop de Robótica">
                        </div>
                        <div class="event-content">
                            <h3 class="event-title">Workshop de Robótica e Automação</h3>
                            <div class="event-meta">
                                <div class="event-meta-item"><i class="fas fa-clock"></i><span>10:00</span></div>
                                <div class="event-meta-item"><i class="fas fa-map-marker-alt"></i><span>ISTP - Lab de
                                        Robótica</span></div>
                                <div class="event-meta-item spots-left">
                                    <i class="fas fa-users"></i>
                                    <span>25 vagas restantes</span>
                                </div>
                            </div>
                            <p class="event-description">Construa e programe robôs com Arduino e Raspberry Pi. Aprenda sobre
                                sensores, motores e automação industrial.</p>
                            <div class="event-footer">
                                <div class="event-price">€ 30,00</div>
                                <div class="event-actions">
                                    <button class="btn-primary register-btn" data-event-id="2" data-initial-spots="25">
                                        <i class="fas fa-ticket-alt"></i>
                                        INSCREVER
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="event-card" data-category="mobile" data-date="2025-02-25 15:30:00">
                        <div class="event-date">
                            <span class="day">25</span>
                            <span class="month">FEV</span>
                        </div>
                        <div class="event-image">
                            <img src="https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80"
                                alt="Desenvolvimento Mobile">
                        </div>
                        <div class="event-content">
                            <h3 class="event-title">Desenvolvimento de Apps Mobile</h3>
                            <div class="event-meta">
                                <div class="event-meta-item"><i class="fas fa-clock"></i><span>15:30</span></div>
                                <div class="event-meta-item"><i class="fas fa-map-marker-alt"></i><span>ISTP - Sala de
                                        Informática</span></div>
                                <div class="event-meta-item spots-left">
                                    <i class="fas fa-users"></i>
                                    <span>35 vagas restantes</span>
                                </div>
                            </div>
                            <p class="event-description">Crie apps para Android e iOS com React Native e Flutter. Workshop
                                prático com publicação na Play Store e App Store.</p>
                            <div class="event-footer">
                                <div class="event-price free">GRATUITO</div>
                                <div class="event-actions">
                                    <button class="btn-primary register-btn" data-event-id="3" data-initial-spots="35">
                                        <i class="fas fa-ticket-alt"></i>
                                        INSCREVER
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="events-card-container">
            <section class="past-events">
                <div class="section-header">
                    <h2 class="section-title">Eventos Passados</h2>
                    <div class="events-count" id="past-count">2 eventos</div>
                </div>

                <div class="events-grid" id="past-events-grid">
                    <div class="event-card past">
                        <div class="event-date">
                            <span class="day">18</span>
                            <span class="month">JAN</span>
                        </div>
                        <div class="event-image">
                            <img src="https://images.unsplash.com/photo-1531746790731-6c087fecd65a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80"
                                alt="Workshop de Chatbots">
                            <div class="event-overlay">REALIZADO</div>
                        </div>
                        <div class="event-content">
                            <h3 class="event-title">Criação de Chatbots com IA</h3>
                            <div class="event-meta">
                                <div class="event-meta-item"><i class="fas fa-calendar-check"></i><span>18/01/2025</span>
                                </div>
                                <div class="event-meta-item"><i class="fas fa-map-marker-alt"></i><span>ISTP - Auditório
                                        Principal</span></div>
                            </div>
                            <p class="event-description">Workshop sobre desenvolvimento de chatbots inteligentes usando
                                NLP, DialogFlow e integração com plataformas de mensagens.</p>
                            <div class="event-footer">
                                <button class="btn-primary ended" disabled><i class="fas fa-check-circle"></i>
                                    CONCLUÍDO</button>
                            </div>
                        </div>
                    </div>

                    <div class="event-card past">
                        <div class="event-date">
                            <span class="day">12</span>
                            <span class="month">JAN</span>
                        </div>
                        <div class="event-image">
                            <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80"
                                alt="Programação Web Avançada">
                            <div class="event-overlay">REALIZADO</div>
                        </div>
                        <div class="event-content">
                            <h3 class="event-title">Programação Web Avançada</h3>
                            <div class="event-meta">
                                <div class="event-meta-item"><i class="fas fa-calendar-check"></i><span>12/01/2025</span>
                                </div>
                                <div class="event-meta-item"><i class="fas fa-map-marker-alt"></i><span>ISTP - Lab de
                                        Desenvolvimento</span></div>
                            </div>
                            <p class="event-description">Workshop intensivo sobre frameworks modernos: React, Vue.js,
                                Node.js e APIs RESTful. Projetos práticos full-stack.</p>
                            <div class="event-footer">
                                <button class="btn-primary ended" disabled><i class="fas fa-check-circle"></i>
                                    CONCLUÍDO</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        const canvas = document.getElementById("particles");
        const ctx = canvas.getContext("2d");

        const resizeCanvas = () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        };
        resizeCanvas();

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

        function initParticles() {
            particles = [];
            for (let i = 0; i < total; i++) {
                particles.push(new Particle());
            }
            animate();
        }

        window.addEventListener('resize', resizeCanvas);

        document.addEventListener('DOMContentLoaded', function() {
            const upGrid = document.getElementById('upcoming-events-grid');
            const filterBtns = document.querySelectorAll('.filter-btn');
            const countEl = document.getElementById('upcoming-count');
            const registerBtns = document.querySelectorAll('.register-btn:not(.ended):not([disabled])');

            document.querySelectorAll('#upcoming-events-grid .event-card').forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            filterBtns.forEach(button => {
                button.addEventListener('click', function() {
                    filterBtns.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    const filter = this.dataset.filter;
                    let visibleCount = 0;

                    upGrid.querySelectorAll('.event-card').forEach(card => {
                        const category = card.dataset.category;
                        const isVisible = (filter === 'all' || category === filter);

                        if (isVisible) {
                            card.style.display = 'flex';
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                            visibleCount++;
                        } else {
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(20px)';
                            setTimeout(() => {
                                card.style.display = 'none';
                            }, 300);
                        }
                    });

                    countEl.textContent = `${visibleCount} evento${visibleCount !== 1 ? 's' : ''}`;
                    updateCountdown();
                });
            });

            registerBtns.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const spotsEl = this.closest('.event-card').querySelector('.spots-left span');

                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> PROCESSANDO...';
                    this.disabled = true;

                    setTimeout(() => {
                        let currentSpots = parseInt(this.dataset.initialSpots) || 1;

                        if (spotsEl && currentSpots > 0) {
                            currentSpots--;
                            this.dataset.initialSpots = currentSpots;

                            if (currentSpots > 0) {
                                spotsEl.textContent = `${currentSpots} vagas restantes`;
                                this.innerHTML =
                                    '<i class="fas fa-check-circle"></i> INSCRITO';
                                this.classList.add('ended');
                                this.style.background = '#27ae60';
                                showNotification('Inscrição realizada com sucesso!');
                            } else {
                                spotsEl.textContent = 'ESGOTADO';
                                this.textContent = 'ESGOTADO';
                                this.disabled = true;
                                this.classList.remove('ended');
                                this.style.background = 'var(--medium-gray)';
                                showNotification('Inscrição realizada! Evento esgotado.');
                            }
                        } else {
                            this.innerHTML = '<i class="fas fa-check-circle"></i> INSCRITO';
                            this.classList.add('ended');
                            this.style.background = '#27ae60';
                            showNotification('Inscrição realizada com sucesso!');
                        }
                    }, 1500);
                });
            });

            function updateCountdown() {
                const visibleCards = Array.from(upGrid.querySelectorAll('.event-card')).filter(card => card.style
                    .display !== 'none');
                const titleEl = document.getElementById('next-event-title');
                const timeEls = {
                    days: document.getElementById('days'),
                    hours: document.getElementById('hours'),
                    minutes: document.getElementById('minutes'),
                    seconds: document.getElementById('seconds')
                };

                if (visibleCards.length === 0) {
                    titleEl.textContent = '';
                    Object.values(timeEls).forEach(el => el.textContent = '00');
                    return;
                }

                let nextEventTime = Infinity;
                let nextEventTitle = '';

                visibleCards.forEach(card => {
                    const eventDateStr = card.dataset.date;
                    const eventDate = new Date(eventDateStr);
                    const diff = eventDate.getTime() - new Date().getTime();

                    if (diff > 0 && diff < nextEventTime) {
                        nextEventTime = diff;
                        const fullTitle = card.querySelector('.event-title').textContent;
                        nextEventTitle = fullTitle.length > 30 ? fullTitle.substring(0, 30) + '...' :
                            fullTitle;
                    }
                });

                if (nextEventTime !== Infinity) {
                    titleEl.textContent = `Próximo: ${nextEventTitle}`;

                    const distance = nextEventTime;
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    timeEls.days.textContent = days.toString().padStart(2, '0');
                    timeEls.hours.textContent = hours.toString().padStart(2, '0');
                    timeEls.minutes.textContent = minutes.toString().padStart(2, '0');
                    timeEls.seconds.textContent = seconds.toString().padStart(2, '0');
                } else {
                    titleEl.textContent = '';
                    Object.values(timeEls).forEach(el => el.textContent = '00');
                }
            }

            function showNotification(message) {
                const notification = document.createElement('div');
                notification.style.cssText = `
                position: fixed; top: 20px; right: 20px; background: #27ae60; color: white;
                padding: 15px 25px; border-radius: 10px; z-index: 10000;
                box-shadow: 0 5px 15px rgba(0,0,0,0.2); transform: translateX(150%);
                transition: transform 0.3s ease; font-weight: 600;
            `;
                notification.innerHTML = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.style.transform = 'translateX(0)';
                }, 100);
                setTimeout(() => {
                    notification.style.transform = 'translateX(150%)';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }

            initParticles();
            updateCountdown();
            setInterval(updateCountdown, 1000);
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
@endsection