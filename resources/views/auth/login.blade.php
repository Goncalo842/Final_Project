@extends('layout.fe_master')
@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

        :root {
            --primary-color: #f87808;
            --primary-light: #ff9a3c;
            --primary-dark: #9e5007;
            --text-dark: #333;
            --text-light: #fff;
        }

        body {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: #ccc;
            overflow-x: hidden;
            font-family: 'Montserrat', sans-serif;
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 40px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .login-container h1 {
            text-align: center;
            color: var(--text-dark);
            margin-bottom: 40px;
            font-size: 28px;
            font-weight: 600;
            position: relative;
        }

        .login-container h1::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), transparent);
            border-radius: 3px;
        }

        .input-group {
            position: relative;
            margin-bottom: 40px;
        }

        .form-control {
            width: 100%;
            padding: 10px 0;
            border: none;
            border-bottom: 2px solid #ddd;
            background: transparent;
            font-size: 16px;
            color: var(--text-dark);
            outline: none;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            box-shadow: none;
            border-bottom: 2px solid #ddd;
        }

        .form-label {
            position: absolute;
            top: 10px;
            left: 0;
            color: #777;
            font-size: 16px;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .form-control:not(:placeholder-shown) + .form-label,
        .form-control:focus:not(:placeholder-shown) + .form-label {
            top: -15px;
            font-size: 12px;
            color: var(--primary-color);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: var(--text-light);
            border: none;
            width: 100%;
            padding: 16px;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(248, 120, 8, 0.3);
            margin-top: 20px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 7px 20px rgba(248, 120, 8, 0.4);
        }

        .login-footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
            font-size: 14px;
        }

        .login-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #ff6b6b;
            font-size: 0.8em;
            margin-top: -30px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }

        @media (max-width: 500px) {
            .login-container {
                width: 90%;
                margin: 50px auto;
                padding: 30px 20px;
            }
        }
    </style>

    <canvas id="particles"></canvas>

    <div class="login-container">
        <h1>Entrar</h1>
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="input-group">
                <input required name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder=" ">
                <label for="exampleInputEmail1" class="form-label">Email</label>
            </div>
            @error('email')
                <div class="error-message">Email inválido</div>
            @enderror

            <div class="input-group">
                <input required name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder=" ">
                <label for="exampleInputPassword1" class="form-label">Palavra passe</label>
            </div>
            @error('password')
                <div class="error-message">Password inválida</div>
            @enderror

            <button type="submit" class="btn-login">Entrar</button>

            <div class="login-footer">
                Não tem uma conta? <a href="{{ route('register') }}">Registe-se aqui</a>
            </div>
        </form>
    </div>

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
@endsection