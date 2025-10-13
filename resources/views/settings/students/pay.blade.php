@extends('layout.fe_settings')
@section('content')
    <style>
        :root {
            --primary-color: #8a4d00;
            --primary-light: #cc7a00;
            --secondary-color: #5a5a5a;
            --light-bg: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
            --card-bg: rgba(255, 255, 255, 0.98);
            --text-dark: #1a1a1a;
            --text-medium: #4a4a4a;
            --text-light: #7a7a7a;
            --shadow-sm: 0 3px 10px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 8px 20px rgba(0, 0, 0, 0.15);
            --border-radius: 16px;
            --transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        body {
            font-family: 'Montserrat', sans-serif;
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

        .payment-wrapper {
            max-width: 1200px;
            margin: 4rem auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 2rem;
            align-items: start;
        }

        .payment-sidebar {
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 2.5rem;
            box-shadow: var(--shadow-sm);
            border-left: 6px solid var(--primary-color);
            animation: slideInLeft 0.8s ease-out;
        }

        .payment-main {
            border-left: #9e5007 5px solid;
            background: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 2.5rem;
            box-shadow: var(--shadow-sm);
            animation: fadeInUp 0.8s ease-out;
        }

        .payment-header {
            margin-bottom: 2.5rem;
            text-align: left;
        }

        .payment-title {
            font-size: 2.75rem;
            font-weight: 800;
            color: var(--primary-color);
            margin: 0;
            line-height: 1.2;
            position: relative;
        }

        .payment-title::after {
            content: '';
            position: absolute;
            bottom: -0.75rem;
            left: 0;
            width: 80px;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
            border-radius: 3px;
        }

        .payment-subtitle {
            font-size: 1.25rem;
            color: var(--text-medium);
            margin-top: 1rem;
            font-weight: 400;
        }

        .card-preview {
            width: 100%;
            max-width: 400px;
            margin: 0 auto 2rem;
            perspective: 1000px;
        }

        .card-inner {
            position: relative;
            width: 100%;
            height: 220px;
            transition: transform 0.8s;
            transform-style: preserve-3d;
            border-radius: 15px;
            box-shadow: var(--shadow-md);
        }

        .front,
        .back {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 15px;
            backface-visibility: hidden;
            background: linear-gradient(135deg, #000000, #9e5007);
            color: white;
            padding: 20px;
            box-sizing: border-box;
        }

        .front {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .front img {
            width: 50px;
        }

        .card-number {
            font-size: 1.4em;
            letter-spacing: 2px;
            word-spacing: 5px;
            margin: 15px 0;
        }

        .card-holder,
        .card-exp {
            font-size: 0.9em;
        }

        .card-bottom {
            display: flex;
            justify-content: space-between;
        }

        .back {
            transform: rotateY(180deg);
            display: flex;
            flex-direction: column;
        }

        .strip {
            background: black;
            height: 40px;
            margin: 20px -20px;
        }

        .ccv {
            background: white;
            color: black;
            padding: 5px;
            width: 80px;
            text-align: center;
            border-radius: 5px;
            margin-left: auto;
        }

        .flipped {
            transform: rotateY(180deg);
        }

        .payment-history {
            margin-bottom: 2rem;
        }

        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid var(--text-light);
            transition: var(--transition);
        }

        .history-item:hover {
            background: rgba(138, 77, 0, 0.05);
            transform: translateX(5px);
        }

        .history-item:last-child {
            border-bottom: none;
        }

        .history-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .status-paid {
            background: rgba(46, 125, 50, 0.15);
            color: #2e7d32;
        }

        .status-pending {
            background: rgba(198, 40, 40, 0.15);
            color: #c62828;
        }

        .payment-form {
            margin-top: 2rem;
        }

        .form-step {
            display: none;
            animation: slideInRight 0.6s ease-out;
        }

        .form-step.active {
            display: block;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-medium);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 1rem;
            border: 1px solid var(--text-light);
            border-radius: 8px;
            font-size: 1rem;
            background: #f8f9fa;
            transition: var(--transition);
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(204, 122, 0, 0.15);
            background: var(--card-bg);
        }

        .card-input-container {
            position: relative;
        }

        .card-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 1.2rem;
        }

        .payment-method-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .payment-method-option {
            background: #f8f9fa;
            border: 2px solid var(--text-light);
            border-radius: 10px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .payment-method-option:hover,
        .payment-method-option.active {
            border-color: var(--primary-light);
            background: rgba(204, 122, 0, 0.1);
            transform: scale(1.02);
        }

        .payment-method-option i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        .btn {
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            transition: var(--transition);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: var(--card-bg);
            border: none;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background: var(--text-light);
            color: var(--card-bg);
            border: none;
        }

        .btn-secondary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        .payment-alert {
            background: rgba(212, 237, 218, 0.95);
            padding: 1rem 1.5rem;
            border-left: 5px solid #28a745;
            border-radius: 8px;
            margin-bottom: 2rem;
            color: #155724;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: var(--shadow-sm);
            animation: fadeIn 0.5s ease-out;
        }

        .payment-alert.error {
            background: rgba(248, 215, 218, 0.95);
            border-left-color: #dc3545;
            color: #721c24;
        }

        .payment-summary {
            background: rgba(138, 77, 0, 0.1);
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary-color);
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            font-size: 1rem;
            color: var(--text-medium);
            margin-bottom: 0.5rem;
        }

        .summary-total {
            font-weight: 700;
            font-size: 1.15rem;
            color: var(--primary-color);
            padding-top: 0.75rem;
            margin-top: 0.75rem;
        }

        .file-upload {
            border: 2px dashed var(--text-light);
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            margin-top: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .file-upload:hover {
            border-color: var(--primary-light);
            background: rgba(204, 122, 0, 0.1);
            transform: scale(1.01);
        }

        .file-upload i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 0.75rem;
        }

        .file-upload p {
            margin: 0;
            color: var(--text-medium);
            font-size: 1rem;
        }

        .file-name {
            margin-top: 0.75rem;
            font-size: 0.9rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        .bank-info {
            background: rgba(248, 249, 250, 0.95);
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary-color);
        }

        .bank-info-item {
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .bank-info-label {
            font-weight: 600;
            color: var(--text-medium);
            margin-right: 0.5rem;
        }

        .semester-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--text-light);
            padding-bottom: 0.5rem;
        }

        .semester-tab {
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            background: #f8f9fa;
            border: 1px solid var(--text-light);
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
        }

        .semester-tab.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .semester-content {
            display: none;
        }

        .semester-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @media (max-width: 992px) {
            .payment-wrapper {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .payment-wrapper {
                padding: 0 1.5rem;
                margin: 2rem auto;
            }

            .payment-title {
                font-size: 2rem;
            }

            .payment-subtitle {
                font-size: 1.1rem;
            }

            .payment-method-container {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .card-preview {
                max-width: 350px;
            }
        }

        @media (max-width: 576px) {

            .payment-sidebar,
            .payment-main {
                padding: 1.5rem;
            }

            .payment-title {
                font-size: 1.75rem;
            }

            .history-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .semester-tabs {
                flex-direction: column;
            }

            .card-preview {
                max-width: 300px;
            }

            .card-number {
                font-size: 1.2em;
            }
        }
    </style>

    <canvas id="particles"></canvas>

    <div class="payment-wrapper">
        <aside class="payment-sidebar">
            <div class="payment-header">
                <h1 class="payment-title">Histórico</h1>
                <p class="payment-subtitle">Acompanhe o status das suas mensalidades</p>
            </div>

            <div class="semester-tabs">
                <div class="semester-tab active" data-semester="1">1º Semestre</div>
                <div class="semester-tab" data-semester="2">2º Semestre</div>
            </div>

            <div class="payment-history">
                <div class="semester-content active" data-semester="1">
                    @foreach (['Setembro', 'Outubro', 'Novembro', 'Dezembro', 'Janeiro', 'Fevereiro'] as $mes)
                        <div class="history-item">
                            <div>
                                <span>{{ $mes }}</span><br>
                                <span class="summary-total">220 €</span>
                            </div>
                            <div>
                                @if (in_array($mes, $mesesPagos))
                                    <span class="history-status status-paid">
                                        <i class="fas fa-check-circle"></i> Pago
                                    </span>
                                @else
                                    <span class="history-status status-pending">
                                        <i class="fas fa-exclamation-circle"></i> Pendente
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="semester-content" data-semester="2">
                    @foreach (['Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto'] as $mes)
                        <div class="history-item">
                            <div>
                                <span>{{ $mes }}</span><br>
                                <span class="summary-total">220 €</span>
                            </div>
                            <div>
                                @if (in_array($mes, $mesesPagos))
                                    <span class="history-status status-paid">
                                        <i class="fas fa-check-circle"></i> Pago
                                    </span>
                                @else
                                    <span class="history-status status-pending">
                                        <i class="fas fa-exclamation-circle"></i> Pendente
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </aside>

        <main class="payment-main">
            <div class="payment-header">
                <h1 class="payment-title">Pagamento de Propinas</h1>
                <p class="payment-subtitle">Efetue o pagamento de forma rápida e segura</p>
            </div>

            @if (session('sucesso'))
                <div class="payment-alert">
                    <i class="fas fa-check-circle"></i> {{ session('sucesso') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="payment-alert error">
                    <i class="fas fa-exclamation-circle"></i>
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form id="paymentForm" method="POST" action="{{ route('complete') }}" class="payment-form"
                enctype="multipart/form-data">
                @csrf

                <div class="form-step active" id="step1">
                    <div class="form-group">
                        <label class="form-label" for="month">Mês a ser pago</label>
                        <select class="form-select" name="mes" id="month" required>
                            <option value="">-- Selecione um mês --</option>
                            @foreach ($meses as $mes)
                                @if (!in_array($mes, $mesesPagos))
                                    <option value="{{ $mes }}">{{ $mes }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="payment-summary">
                        <div class="summary-item">
                            <span>Propina:</span>
                            <span>220 €</span>
                        </div>
                        <div class="summary-total">
                            <span>Total a pagar:</span>
                            <span>220 €</span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-primary" id="nextBtn">
                            <i class="fas fa-arrow-right"></i> Continuar
                        </button>
                    </div>
                </div>

                <div class="form-step" id="step2">
                    <div class="form-group">
                        <label class="form-label">Método de Pagamento</label>
                        <div class="payment-method-container">
                            <label>
                                <input type="radio" name="payment_method" value="digital_card" checked hidden>
                                <div class="payment-method-option active">
                                    <i class="fas fa-credit-card"></i>
                                    <div>Cartão Digital</div>
                                </div>
                            </label>
                            <label>
                                <input type="radio" name="payment_method" value="bank_transfer" hidden>
                                <div class="payment-method-option">
                                    <i class="fas fa-university"></i>
                                    <div>Transferência Bancária</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div id="digitalCardForm">
                        <div class="card-preview">
                            <div class="card-inner" id="cardInner">
                                <div class="front">
                                    <div class="type"><i class="fas fa-credit-card"></i></div>
                                    <div class="card-number" id="cardNumber">**** **** **** ****</div>
                                    <div class="card-bottom">
                                        <div>
                                            <div class="card-holder">NOME NO CARTÃO</div>
                                            <div class="card-holder" id="cardName"></div>
                                        </div>
                                        <div>
                                            <div class="card-exp">VALIDADE</div>
                                            <div class="card-exp" id="cardDate">MM/AA</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="back">
                                    <div class="strip"></div>
                                    <div class="ccv" id="cardCVV">***</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="card_number">Número do Cartão</label>
                            <div class="card-input-container">
                                <input type="text" class="form-input" id="card_number" name="numero_cartao"
                                    placeholder="1234 5678 9012 3456" required>
                                <i class="fas fa-credit-card card-icon"></i>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label class="form-label" for="expiry_date">Validade</label>
                                <input type="text" class="form-input" id="expiry_date" name="validade"
                                    placeholder="MM/AA" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="cvv">CVV</label>
                                <div class="card-input-container">
                                    <input type="text" class="form-input" id="cvv" name="cvv"
                                        placeholder="123" required>
                                    <i class="fas fa-lock card-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="card_name">Nome no Cartão</label>
                            <input type="text" class="form-input" id="card_name" name="card_name"
                                placeholder="Como no cartão" required>
                        </div>
                    </div>

                    <div id="bankTransferForm" style="display: none;">
                        <div class="bank-info">
                            <h4 style="margin: 0 0 1rem; color: var(--primary-color); font-weight: 700;">Dados Bancários
                            </h4>
                            <div class="bank-info-item">
                                <span class="bank-info-label">Titular:</span> Escola Superior de Tecnologia
                            </div>
                            <div class="bank-info-item">
                                <span class="bank-info-label">IBAN:</span> PT50 0000 0000 0000 0000 0000 0
                            </div>
                            <div class="bank-info-item">
                                <span class="bank-info-label">SWIFT/BIC:</span> BBPIPTPL
                            </div>
                            <div class="bank-info-item">
                                <span class="bank-info-label">Valor:</span> 220 €
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Comprovativo de Transferência</label>
                            <div class="file-upload" id="fileUploadArea">
                                <i class="fas fa-file-upload"></i>
                                <p>Arraste ou clique para selecionar o comprovativo</p>
                                <div class="file-name" id="fileName"></div>
                                <input type="file" id="payment_proof" name="payment_proof"
                                    accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" id="backBtn">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Finalizar
                        </button>
                    </div>
                </div>
            </form>
        </main>
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

        const cardInner = document.getElementById('cardInner');
        const cardNumber = document.getElementById('cardNumber');
        const cardName = document.getElementById('cardName');
        const cardDate = document.getElementById('cardDate');
        const cardCVV = document.getElementById('cardCVV');

        const inputNumber = document.getElementById('card_number');
        const inputName = document.getElementById('card_name');
        const inputDate = document.getElementById('expiry_date');
        const inputCVV = document.getElementById('cvv');

        inputNumber.addEventListener('input', () => {
            let value = inputNumber.value.replace(/\D/g, '').substring(0, 16);
            value = value.replace(/(.{4})/g, '$1 ').trim();
            cardNumber.textContent = value || '**** **** **** ****';
        });

        inputName.addEventListener('input', () => {
            cardName.textContent = inputName.value.toUpperCase() || '';
        });

        inputDate.addEventListener('input', () => {
            let value = inputDate.value.replace(/\D/g, '').substring(0, 4);
            if (value.length >= 3) value = value.substring(0, 2) + '/' + value.substring(2);
            cardDate.textContent = value || 'MM/AA';
        });

        inputCVV.addEventListener('focus', () => {
            cardInner.classList.add('flipped');
        });

        inputCVV.addEventListener('blur', () => {
            cardInner.classList.remove('flipped');
        });

        inputCVV.addEventListener('input', () => {
            cardCVV.textContent = inputCVV.value || '###';
        });

        document.querySelectorAll('.semester-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.semester-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.semester-content').forEach(c => c.classList.remove('active'));

                this.classList.add('active');
                const semester = this.getAttribute('data-semester');
                document.querySelector(`.semester-content[data-semester="${semester}"]`).classList.add(
                    'active');
            });
        });

        document.getElementById('nextBtn').addEventListener('click', function() {
            const monthSelect = document.getElementById('month');
            if (monthSelect.value === '') {
                alert('Por favor, selecione um mês antes de continuar.');
                return;
            }

            document.getElementById('step1').classList.remove('active');
            document.getElementById('step2').classList.add('active');
            document.getElementById('step2').scrollIntoView({
                behavior: 'smooth'
            });
        });

        document.getElementById('backBtn').addEventListener('click', function() {
            document.getElementById('step2').classList.remove('active');
            document.getElementById('step1').classList.add('active');
            document.getElementById('step1').scrollIntoView({
                behavior: 'smooth'
            });
        });

        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const digitalCardForm = document.getElementById('digitalCardForm');
                const bankTransferForm = document.getElementById('bankTransferForm');
                const options = document.querySelectorAll('.payment-method-option');

                options.forEach(opt => opt.classList.remove('active'));
                this.parentElement.querySelector('.payment-method-option').classList.add('active');

                if (this.value === 'digital_card') {
                    digitalCardForm.style.display = 'block';
                    bankTransferForm.style.display = 'none';
                } else {
                    digitalCardForm.style.display = 'none';
                    bankTransferForm.style.display = 'block';
                }
            });
        });

        document.getElementById('card_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '');
            if (value.length > 0) {
                value = value.match(new RegExp('.{1,4}', 'g')).join(' ');
            }
            e.target.value = value;
        });

        document.getElementById('expiry_date').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });

        const fileUploadArea = document.getElementById('fileUploadArea');
        const fileInput = document.getElementById('payment_proof');
        const fileName = document.getElementById('fileName');

        fileUploadArea.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                fileName.textContent = e.target.files[0].name;
                fileUploadArea.style.borderColor = 'var(--primary-color)';
            }
        });

        fileUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileUploadArea.style.borderColor = 'var(--primary-light)';
            fileUploadArea.style.backgroundColor = 'rgba(204, 122, 0, 0.1)';
        });

        fileUploadArea.addEventListener('dragleave', () => {
            fileUploadArea.style.borderColor = 'var(--text-light)';
            fileUploadArea.style.backgroundColor = '';
        });

        fileUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            fileUploadArea.style.borderColor = 'var(--text-light)';
            fileUploadArea.style.backgroundColor = '';

            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                fileName.textContent = e.dataTransfer.files[0].name;
                fileUploadArea.style.borderColor = 'var(--primary-color)';
            }
        });

        init();
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
