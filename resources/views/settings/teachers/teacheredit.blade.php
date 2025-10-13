@extends('layout.fe_settings')

@section('content')
    <style>
        :root {
            --primary-color: #8a4d00;
            --primary-light: #cc7a00;
            --secondary-color: #5a5a5a;
            --light-bg: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
            --card-bg: rgba(255, 255, 255, 0.92);
        }

        body {
            background: var(--light-bg);
            position: relative;
            overflow-x: hidden;
            min-height: 100vh;
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .profile-edit-container {
            width: 100%;
            max-width: 900px;
            margin: 60px auto;
            background: var(--card-bg);
            border-radius: 16px;
            padding: 50px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-left: 8px solid var(--primary-color);
            backdrop-filter: blur(5px);
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
            position: relative;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-right: 30px;
            background-color: #e3e2e2;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 40px;
            font-weight: bold;
        }

        .profile-title {
            color: var(--primary-color);
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .profile-subtitle {
            color: var(--secondary-color);
            margin: 5px 0 0;
            font-size: 16px;
            font-weight: 400;
        }

        .edit-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .form-section-title {
            grid-column: 1 / -1;
            color: var(--primary-color);
            font-size: 18px;
            font-weight: 600;
            margin: 10px 0 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }

        .form-section-title i {
            margin-right: 10px;
            font-size: 20px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            font-weight: 600;
            color: var(--secondary-color);
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .form-label i {
            margin-right: 8px;
            color: var(--primary-light);
            font-size: 16px;
        }

        .form-input {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
            background-color: #f9f9f9;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.03);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(204, 122, 0, 0.1);
            background-color: #fff;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 13px;
            margin-top: 8px;
            display: flex;
            align-items: center;
        }

        .invalid-feedback i {
            margin-right: 5px;
            font-size: 14px;
        }

        .form-actions {
            grid-column: 1 / -1;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding-top: 30px;
        }

        .btn {
            border-radius: 8px;
            transition: all 0.3s;
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(138, 77, 0, 0.2);
        }

        .btn-secondary {
            background: #f0f0f0;
            color: var(--secondary-color);
            border: 1px solid #ddd;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
        }

        .alert-success {
            background: rgba(212, 237, 218, 0.9);
            padding: 15px 20px;
            border-left: 4px solid #28a745;
            margin-bottom: 30px;
            border-radius: 4px;
            color: #155724;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 10px;
            grid-column: 1 / -1;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 38px;
            cursor: pointer;
            color: var(--secondary-color);
            opacity: 0.6;
            transition: opacity 0.3s;
        }

        .password-toggle:hover {
            opacity: 1;
        }

        @media (max-width: 768px) {
            .edit-form {
                grid-template-columns: 1fr;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .profile-avatar {
                margin-right: 0;
                margin-bottom: 20px;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>

    <canvas id="particles"></canvas>

    <div class="profile-edit-container">
        <div class="profile-header">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="profile-title">Editar Perfil</h1>
                <p class="profile-subtitle">Atualize suas informações pessoais</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('user.update') }}" method="POST" class="edit-form">
            @csrf
            @method('PUT')

            <h3 class="form-section-title">
                <i class="fas fa-user-circle"></i> Informações Pessoais
            </h3>

            <div class="form-group">
                <label class="form-label" for="name">
                    <i class="fas fa-user"></i> Nome Completo
                </label>
                <input type="text" id="name" name="name" class="form-input @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}" required maxlength="50">
                @error('name')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="email">
                    <i class="fas fa-envelope"></i> Email
                </label>
                <input type="email" id="email" name="email" class="form-input @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}" required maxlength="255">
                @error('email')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="birth_date">
                    <i class="fas fa-birthday-cake"></i> Data de Nascimento
                </label>
                <input type="date" id="birth_date" name="birth_date"
                    class="form-input @error('birth_date') is-invalid @enderror"
                    value="{{ old('birth_date', $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d') : '') }}">
                @error('birth_date')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <h3 class="form-section-title">
                <i class="fas fa-lock"></i> Segurança
            </h3>

            <div class="form-group">
                <label class="form-label" for="password">
                    <i class="fas fa-key"></i> Nova Senha (opcional)
                </label>
                <input type="password" id="password" name="password"
                    class="form-input @error('password') is-invalid @enderror">
                <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                @error('password')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">
                    <i class="fas fa-key"></i> Confirmar Senha
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input">
                <i class="fas fa-eye password-toggle" id="togglePasswordConfirmation"></i>
            </div>

            <div class="form-actions">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>&nbsp;Salvar Alterações
                </button>
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

        const togglePassword = document.querySelector('#togglePassword');
        const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
        const password = document.querySelector('#password');
        const passwordConfirmation = document.querySelector('#password_confirmation');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });

        togglePasswordConfirmation.addEventListener('click', function() {
            const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmation.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });

        const birthDateInput = document.getElementById('birth_date');
        if (birthDateInput) {
            birthDateInput.addEventListener('change', function() {
                const birthDate = new Date(this.value);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();

                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                console.log('Age:', age);
            });
        }

        init();
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
