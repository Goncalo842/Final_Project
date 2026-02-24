@extends('layout.fe_master')

@section('content')
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css'>

    <style>
        * {
            margin: 0;
            padding: 0;
        }

        html, body {
            width: 100%;
            height: 100%;
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
        }

        #particles {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1;
            width: 100%;
            height: 100%;
            display: block;
        }

        body {
            background: var(--gradient-accent);
            background-attachment: fixed;
            color: black;
        }

        .auth-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .auth-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 3rem;
            max-width: 450px;
            width: 100%;
            backdrop-filter: blur(10px);
        }

        .auth-card h2 {
            color: #df7c04;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .form-group input,
        .form-group .input-group input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-group input:focus,
        .form-group .input-group input:focus {
            outline: none;
            border-color: #df7c04;
            box-shadow: 0 0 0 3px rgba(223, 124, 4, 0.1);
        }

        .form-group input::placeholder {
            color: #999;
        }

        .input-group {
            display: flex;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }

        .input-group input {
            border: none !important;
            flex: 1;
        }

        .input-group input:focus {
            box-shadow: none !important;
        }

        .input-group .toggle-password {
            border: none;
            background: #f8f9fa;
            color: #df7c04;
            cursor: pointer;
            padding: 0.875rem 1rem;
            transition: all 0.3s ease;
        }

        .input-group .toggle-password:hover {
            background: #e9ecef;
        }

        .input-group:focus-within {
            border-color: #df7c04;
            box-shadow: 0 0 0 3px rgba(223, 124, 4, 0.1);
        }

        .submit-btn {
            width: 100%;
            padding: 0.95rem;
            background: #df7c04;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(223, 124, 4, 0.3);
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .error-feedback {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: block;
        }

        .auth-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .auth-link p {
            color: #666;
            margin: 0;
        }

        .auth-link a {
            color: #df7c04;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .auth-link a:hover {
            color: #c85c03;
            text-decoration: underline;
        }

        .help-text {
            font-size: 0.85rem;
            color: #666;
            margin-top: 0.5rem;
        }

        @media (max-width: 768px) {
            .auth-card {
                padding: 2rem;
            }

            .auth-card h2 {
                font-size: 1.5rem;
            }
        }
    </style>

<canvas id="particles"></canvas>

<div class="auth-container">
        <div class="auth-card">
            <h2>
                <i class="fas fa-lock me-2"></i>Criar Nova Palavra-passe
            </h2>

            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle me-2"></i>Ocorreu um erro ao atualizar a palavra-passe.
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope me-2"></i>Endereço de Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', request()->email) }}"
                        placeholder="seu.email@example.com" required autofocus>
                    @error('email')
                        <span class="error-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-key me-2"></i>Palavra-passe
                    </label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" placeholder="Mínimo de 8 caracteres" required>
                        <button class="toggle-password" type="button" data-target="password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-feedback">{{ $message }}</span>
                    @enderror
                    <div class="help-text">
                        <i class="fas fa-info-circle me-1"></i>A palavra-passe deve conter pelo menos 8 caracteres
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">
                        <i class="fas fa-lock-alt me-2"></i>Confirmar Palavra-passe
                    </label>
                    <div class="input-group">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Repete a palavra-passe" required>
                        <button class="toggle-password" type="button" data-target="password_confirmation">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <span class="error-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-check-circle me-2"></i>Atualizar Palavra-passe
                </button>
            </form>

            <div class="auth-link">
                <p>
                    <a href="{{ route('login') }}">
                        <i class="fas fa-arrow-left me-1"></i>Voltar ao Login
                    </a>
                </p>
            </div>
        </div>
    </div>

<script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Particles animation
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
