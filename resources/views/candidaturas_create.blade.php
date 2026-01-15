@extends('layout.fe_master')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        :root {
            --primary-color: #9a5501;
            --primary-light: #9a5501;
            --secondary-color: #5a5a5a;
            --light-bg: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
            --card-bg: rgba(255, 255, 255, 0.95);
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--light-bg);
            position: relative;
            overflow-x: hidden;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 0;
            pointer-events: none;
        }

        .candidatura-container {
            position: relative;
            z-index: 2;
            max-width: 900px;
            margin: 120px auto 60px;
            padding: 0 2rem;
        }

        .form-card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 50px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-left: 8px solid var(--primary-color);
            backdrop-filter: blur(5px);
        }

        .form-header {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }

        .form-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            box-shadow: 0 5px 15px rgba(223, 124, 4, 0.3);
            flex-shrink: 0;
        }

        .form-icon i {
            font-size: 35px;
            color: white;
        }

        .form-title {
            color: var(--primary-color);
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .form-subtitle {
            color: var(--secondary-color);
            margin: 5px 0 0;
            font-size: 16px;
        }

        .section-title {
            grid-column: 1 / -1;
            color: var(--primary-color);
            font-size: 18px;
            font-weight: 600;
            margin: 30px 0 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(223, 124, 4, 0.2);
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
            font-size: 20px;
        }

        .edit-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-weight: 600;
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-label i {
            margin-right: 8px;
            color: var(--primary-light);
            font-size: 16px;
        }

        .required {
            color: #e74c3c;
            margin-left: 4px;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            font-family: 'Montserrat', sans-serif;
            transition: all 0.3s;
            background-color: #f9f9f9;
            box-sizing: border-box;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(223, 124, 4, 0.1);
            background-color: #fff;
        }

        .form-input:hover,
        .form-select:hover {
            border-color: var(--primary-light);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        select.form-select {
            cursor: pointer;
            appearance: none;
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
        }

        .course-type-cards {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 15px;
        }

        .course-type-card {
            padding: 20px;
            border: 3px solid #e0e0e0;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .course-type-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(223, 124, 4, 0.15);
        }

        .course-type-card.active {
            border-color: var(--primary-color);
            background: rgba(223, 124, 4, 0.05);
            box-shadow: 0 10px 25px rgba(223, 124, 4, 0.2);
            border-width: 4px;
        }

        .course-type-card i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 10px;
            display: block;
        }

        .course-type-card h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--secondary-color);
            margin: 0 0 5px;
        }

        .course-type-card p {
            font-size: 13px;
            color: var(--secondary-color);
            opacity: 0.7;
            margin: 0;
        }

        .file-upload-wrapper {
            grid-column: 1 / -1;
            position: relative;
        }

        .file-upload-input {
            display: none;
        }

        .file-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            border: 3px dashed #e0e0e0;
            border-radius: 12px;
            background: #f9f9f9;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-label:hover {
            border-color: var(--primary-color);
            background: rgba(223, 124, 4, 0.03);
        }

        .file-upload-label.has-file {
            border-style: solid;
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.05);
        }

        .file-upload-label i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .file-upload-text strong {
            display: block;
            color: var(--secondary-color);
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .file-upload-text small {
            color: var(--secondary-color);
            opacity: 0.7;
            font-size: 13px;
        }

        .file-name-display {
            margin-top: 15px;
            padding: 12px 20px;
            background: rgba(40, 167, 69, 0.1);
            border: 2px solid #28a745;
            border-radius: 8px;
            display: none;
            align-items: center;
            gap: 10px;
            color: #155724;
            font-weight: 600;
        }

        .file-name-display i {
            color: #28a745;
            font-size: 20px;
        }

        .help-text {
            font-size: 13px;
            color: var(--secondary-color);
            opacity: 0.7;
            margin-top: 8px;
            font-style: italic;
        }

        .alert {
            grid-column: 1 / -1;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
        }

        .alert-success {
            background: rgba(212, 237, 218, 0.9);
            border-left: 4px solid #28a745;
            color: #155724;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.1);
        }

        .alert-danger {
            background: rgba(248, 215, 218, 0.9);
            border-left: 4px solid #dc3545;
            color: #721c24;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.1);
        }

        .alert i {
            font-size: 20px;
        }

        .form-actions {
            grid-column: 1 / -1;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid rgba(0, 0, 0, 0.05);
        }

        .btn {
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(223, 124, 4, 0.3);
        }

        .btn-secondary {
            background: #f0f0f0;
            color: var(--secondary-color);
            border: 2px solid #ddd;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
            border-color: #ccc;
        }

        @media (max-width: 768px) {
            .candidatura-container {
                padding: 0 1rem;
                margin: 100px auto 30px;
            }

            .form-card {
                padding: 30px 20px;
                border-left-width: 5px;
            }

            .edit-form {
                grid-template-columns: 1fr;
            }

            .course-type-cards {
                grid-template-columns: 1fr;
            }

            .form-header {
                flex-direction: column;
                text-align: center;
            }

            .form-icon {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <canvas id="particles"></canvas>

    <div class="candidatura-container">
        <div class="form-card">
            <div class="form-header">
                <div class="form-icon">
                    <i class="fas fa-file-signature"></i>
                </div>
                <div>
                    <h1 class="form-title">Candidatura ISTP</h1>
                    <p class="form-subtitle">Preencha o formulário para se candidatar</p>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <strong>Erro ao submeter candidatura:</strong>
                        <ul style="margin: 0.5rem 0 0; padding-left: 1.5rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('candidaturas.store') }}" method="POST" class="edit-form">
                @csrf

                <h3 class="section-title">
                    <i class="fas fa-user-circle"></i> Dados Pessoais
                </h3>

                <div class="form-group full-width">
                    <label class="form-label" for="nome">
                        <i class="fas fa-user"></i> Nome Completo <span class="required">*</span>
                    </label>
                    <input type="text" id="nome" name="nome" class="form-input" value="{{ old('nome') }}"
                        required placeholder="Digite o seu nome completo">
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">
                        <i class="fas fa-envelope"></i> Email <span class="required">*</span>
                    </label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}"
                        required placeholder="exemplo@email.com">
                </div>

                <div class="form-group">
                    <label class="form-label" for="telefone">
                        <i class="fas fa-phone"></i> Telefone <span class="required">*</span>
                    </label>
                    <input type="tel" id="telefone" name="telefone" class="form-input" value="{{ old('telefone') }}"
                        required placeholder="912 345 678" inputmode="numeric" maxlength="11">
                </div>

                <div class="form-group">
                    <label class="form-label" for="data_nascimento">
                        <i class="fas fa-calendar-alt"></i> Data de Nascimento <span class="required">*</span>
                    </label>
                    <input type="date" id="data_nascimento" name="data_nascimento" class="form-input"
                        value="{{ old('data_nascimento') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="nif">
                        <i class="fas fa-id-card"></i> NIF <span class="required">*</span>
                    </label>
                    <input type="text" id="nif" name="nif" class="form-input" value="{{ old('nif') }}"
                        required placeholder="000000000" maxlength="9" inputmode="numeric" pattern="\d{9}" title="NIF com 9 dígitos">
                </div>

                <div class="form-group full-width">
                    <label class="form-label" for="morada">
                        <i class="fas fa-map-marker-alt"></i> Morada <span class="required">*</span>
                    </label>
                    <input type="text" id="morada" name="morada" class="form-input" value="{{ old('morada') }}"
                        required placeholder="Rua, Número, Andar">
                </div>

                <div class="form-group">
                    <label class="form-label" for="codigo_postal">
                        <i class="fas fa-mail-bulk"></i> Código Postal <span class="required">*</span>
                    </label>
                    <input type="text" id="codigo_postal" name="codigo_postal" class="form-input" placeholder="0000-000"
                        value="{{ old('codigo_postal') }}" required inputmode="numeric" maxlength="8">
                </div>

                <div class="form-group">
                    <label class="form-label" for="localidade">
                        <i class="fas fa-city"></i> Localidade <span class="required">*</span>
                    </label>
                    <select id="localidade" name="localidade" class="form-select" required>
                        <option value="">Selecione a localidade...</option>
                        @php
                            $cidades = [
                                'Lisboa','Porto','Vila Nova de Gaia','Braga','Coimbra','Aveiro','Faro','Leiria','Setúbal',
                                'Viseu','Santarém','Évora','Castelo Branco','Beja','Bragança','Guarda','Portalegre',
                                'Viana do Castelo','Vila Real','Ponta Delgada','Funchal'
                            ];
                        @endphp
                        @foreach($cidades as $cidade)
                            <option value="{{ $cidade }}" @if(old('localidade') == $cidade) selected @endif>{{ $cidade }}</option>
                        @endforeach
                    </select>
                </div>

                <h3 class="section-title">
                    <i class="fas fa-graduation-cap"></i> Tipo de Curso
                </h3>

                <div class="course-type-cards">
                    <div class="course-type-card" data-type="licenciatura">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Licenciatura</h3>
                        <p>3 anos</p>
                    </div>
                    <div class="course-type-card" data-type="ctesp">
                        <i class="fas fa-certificate"></i>
                        <h3>CTeSP</h3>
                        <p>2 anos</p>
                    </div>
                    <div class="course-type-card" data-type="posgraduacao">
                        <i class="fas fa-user-graduate"></i>
                        <h3>Pós-Graduação</h3>
                        <p>1 ano</p>
                    </div>
                </div>

                <input type="hidden" id="tipo_curso" name="tipo_curso" value="{{ old('tipo_curso') }}" required>

                <div class="form-group full-width" id="curso-section" style="display: none;">
                    <label class="form-label" for="curso_id">
                        <i class="fas fa-book"></i> Curso Pretendido <span class="required">*</span>
                    </label>
                    <select id="curso_id" name="curso_id" class="form-select" required disabled>
                        <option value="">Selecione o curso...</option>
                    </select>
                    <p class="help-text">Selecione primeiro o tipo de curso acima</p>
                </div>

                <!-- Currículo section removed -->

                <h3 class="section-title">
                    <i class="fas fa-comment-dots"></i> Motivação
                </h3>

                <div class="form-group full-width">
                    <label class="form-label" for="motivacao">
                        <i class="fas fa-pen"></i> Por que deseja candidatar-se a este curso?
                    </label>
                    <textarea id="motivacao" name="motivacao" class="form-textarea"
                        placeholder="Partilhe as suas motivações para se candidatar...">{{ old('motivacao') }}</textarea>
                </div>

                <div class="form-actions">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Submeter Candidatura
                    </button>
                </div>
            </form>
        </div>
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
            particles.forEach(p => {
                p.move();
                p.draw();
            });
            connectParticles();
            requestAnimationFrame(animate);
        }

        function init() {
            for (let i = 0; i < total; i++) particles.push(new Particle());
            animate();
        }

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });

        init();

        const courseTypeCards = document.querySelectorAll('.course-type-card');
        const tipoCursoInput = document.getElementById('tipo_curso');
        const cursoSelect = document.getElementById('curso_id');
        const cursoSection = document.getElementById('curso-section');

        const cursos = {
            licenciatura: [{
                    id: 1,
                    nome: 'Engenharia Informática'
                },
                {
                    id: 2,
                    nome: 'Engenharia de Multimédia'
                }
            ],
            ctesp: [{
                    id: 3,
                    nome: 'Cibersegurança'
                },
                {
                    id: 4,
                    nome: 'Robótica e IA'
                },
                {
                    id: 5,
                    nome: 'Desenvolvimento Multimédia'
                },
                {
                    id: 6,
                    nome: 'Desenvolvimento Mobile'
                },
                {
                    id: 7,
                    nome: 'Informática de Gestão'
                },
                {
                    id: 8,
                    nome: 'Redes e Sistemas'
                },
                {
                    id: 9,
                    nome: 'Desenvolvimento de Software'
                }
            ],
            posgraduacao: [{
                    id: 10,
                    nome: 'Cloud Computing'
                },
                {
                    id: 11,
                    nome: 'Business Analytics'
                }
            ]
        };

        courseTypeCards.forEach(card => {
            card.addEventListener('click', function() {
                courseTypeCards.forEach(c => c.classList.remove('active'));
                this.classList.add('active');

                const tipo = this.dataset.type;
                tipoCursoInput.value = tipo;

                cursoSection.style.display = 'block';

                cursoSelect.innerHTML = '<option value="">Selecione o curso...</option>';
                cursos[tipo].forEach(curso => {
                    const option = document.createElement('option');
                    option.value = curso.id;
                    option.textContent = curso.nome;
                    cursoSelect.appendChild(option);
                });

                cursoSelect.disabled = false;
                cursoSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            });
        });

        // Format postal code as 0000-000
        const codigoPostalInput = document.getElementById('codigo_postal');
        if (codigoPostalInput) {
            codigoPostalInput.addEventListener('input', (e) => {
                let v = e.target.value.replace(/\D/g, '');
                if (v.length > 7) v = v.slice(0,7);
                if (v.length > 4) {
                    e.target.value = v.slice(0,4) + '-' + v.slice(4);
                } else {
                    e.target.value = v;
                }
            });
        }

        // Format telefone as groups of 3 digits (max 9 digits): 912 345 678
        const telefoneInput = document.getElementById('telefone');
        if (telefoneInput) {
            telefoneInput.addEventListener('input', (e) => {
                let digits = e.target.value.replace(/\D/g, '').slice(0,9);
                let parts = [];
                for (let i = 0; i < digits.length; i += 3) parts.push(digits.slice(i, i+3));
                e.target.value = parts.join(' ');
            });
        }

        // Ensure NIF only digits and max 9
        const nifInput = document.getElementById('nif');
        if (nifInput) {
            nifInput.addEventListener('input', (e) => {
                e.target.value = e.target.value.replace(/\D/g, '').slice(0,9);
            });
        }
    </script>
@endsection
