@extends('layout.fe_master')
@section('content')
    <style>
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

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            color: var(--primary-color, #f87808);
            margin-bottom: 3rem;
        }

        .eventos-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .evento-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .evento-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .evento-titulo {
            font-size: 1.5rem;
            color: var(--primary-color, #f87808);
            margin-bottom: 1rem;
        }

        .evento-data,
        .evento-local {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .evento-descricao {
            font-size: 1rem;
            color: #555;
        }
    </style>

    <canvas id="particles"></canvas>

        <div class="container">
            <h1 class="section-title">Eventos</h1>
            <div class="eventos-container">
                @foreach ($eventos as $evento)
                    <div class="evento-card">
                        <h2 class="evento-titulo">{{ $evento['titulo'] }}</h2>
                        <p class="evento-data"><strong>Data:</strong> {{ $evento['data'] }}</p>
                        <p class="evento-local"><strong>Local:</strong> {{ $evento['local'] }}</p>
                        <p class="evento-descricao">{{ $evento['descricao'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

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