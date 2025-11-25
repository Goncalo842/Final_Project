@extends('layout.fe_settings')
@section('content')
    <style>
        :root {
            --primary-color: #8a4d00;
            --primary-light: #cc7a00;
            --primary-gradient: linear-gradient(135deg, #8a4d00 0%, #cc7a00 50%, #ff9a3d 100%);
            --secondary-color: #5a5a5a;
            --light-bg: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
            --card-bg: rgba(255, 255, 255, 0.98);
            --glass-bg: rgba(255, 255, 255, 0.15);
            --glass-border: rgba(255, 255, 255, 0.2);
            --text-dark: #1a1a1a;
            --text-medium: #4a4a4a;
            --text-light: #7a7a7a;
            --shadow-sm: 0 4px 20px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 8px 30px rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 15px 40px rgba(0, 0, 0, 0.15);
            --border-radius: 20px;
            --transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--light-bg);
            position: relative;
            overflow-x: hidden;
            min-height: 100vh;
            color: var(--text-dark);
        }

        canvas#particles {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            min-height: 100vh;
            align-items: start;
        }

        /* Left Side - Saldo */
        .left-panel {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .saldo-box {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            box-shadow: var(--shadow-lg);
            border-radius: var(--border-radius);
            padding: 50px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
            border: 1px solid var(--glass-border);
        }

        .saldo-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: var(--primary-gradient);
        }

        .saldo-box::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            opacity: 0;
            transition: var(--transition);
        }

        .saldo-box:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .saldo-box:hover::after {
            opacity: 1;
        }

        .saldo-box h1 {
            font-size: 1.4rem;
            color: var(--text-medium);
            margin-bottom: 20px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .saldo-value {
            font-size: 4rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-weight: 800;
            margin: 15px 0;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.1);
            position: relative;
            display: inline-block;
        }

        .saldo-value::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 10%;
            width: 80%;
            height: 3px;
            background: var(--primary-gradient);
            border-radius: 3px;
            transform: scaleX(0);
            transition: transform 0.5s ease;
        }

        .saldo-box:hover .saldo-value::after {
            transform: scaleX(1);
        }

        .saldo-box p {
            font-size: 0.95rem;
            color: var(--text-light);
            margin-top: 15px;
        }

        /* Right Side - Pagamento */
        .right-panel {
            display: flex;
            flex-direction: column;
        }

        .payment-methods {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            box-shadow: var(--shadow-md);
            border-radius: var(--border-radius);
            padding: 40px 35px;
            transition: var(--transition);
            border: 1px solid var(--glass-border);
            position: relative;
            overflow: hidden;
        }

        .payment-methods::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--primary-gradient);
            opacity: 0.3;
        }

        .payment-methods:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-5px);
        }

        .payment-methods h2 {
            font-size: 2rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 700;
            position: relative;
        }

        .payment-methods h2::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }

        .payment-options {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .payment-option {
            display: flex;
            align-items: center;
            padding: 25px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 16px;
            cursor: pointer;
            transition: var(--transition);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .payment-option::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.7s ease;
        }

        .payment-option:hover::before {
            left: 100%;
        }

        .payment-option:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateX(10px);
            border-color: var(--primary-light);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .payment-icon {
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-gradient);
            color: white;
            border-radius: 50%;
            margin-right: 20px;
            font-size: 1.4rem;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(138, 77, 0, 0.3);
            position: relative;
            z-index: 2;
        }

        .payment-option:hover .payment-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 6px 20px rgba(138, 77, 0, 0.4);
        }

        .payment-info {
            flex-grow: 1;
            text-align: left;
            position: relative;
            z-index: 2;
        }

        .payment-info h3 {
            font-size: 1.3rem;
            color: var(--text-dark);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .payment-info p {
            font-size: 0.95rem;
            color: var(--text-light);
        }

        .payment-arrow {
            color: var(--primary-color);
            font-size: 1.3rem;
            transition: var(--transition);
            position: relative;
            z-index: 2;
        }

        .payment-option:hover .payment-arrow {
            transform: translateX(8px);
            color: var(--primary-light);
        }

        .amount-selector {
            margin-top: 35px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 16px;
            display: none;
            border: 1px solid rgba(255,255,255,0.3);
            animation: slideUp 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        .amount-selector::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-gradient);
        }

        .amount-selector.active {
            display: block;
        }

        .amount-selector h3 {
            font-size: 1.4rem;
            color: var(--text-dark);
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
        }

        .amount-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .amount-option {
            padding: 18px 12px;
            background: white;
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
            font-size: 1.1rem;
            position: relative;
            overflow: hidden;
        }

        .amount-option::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 0;
            background: var(--primary-gradient);
            transition: height 0.3s ease;
            z-index: -1;
        }

        .amount-option:hover {
            border-color: var(--primary-light);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .amount-option:hover::before {
            height: 100%;
        }

        .amount-option.selected {
            background: var(--primary-light);
            color: white;
            border-color: var(--primary-light);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(138, 77, 0, 0.3);
        }

        .custom-amount {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .custom-amount input {
            flex-grow: 1;
            padding: 18px 20px;
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            font-size: 1.05rem;
            transition: var(--transition);
            background: white;
        }

        .custom-amount input:focus {
            border-color: var(--primary-light);
            outline: none;
            box-shadow: 0 0 0 3px rgba(204, 122, 0, 0.1);
            transform: translateY(-2px);
        }

        .confirm-btn {
            width: 100%;
            padding: 20px;
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.15rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(138, 77, 0, 0.3);
            letter-spacing: 0.5px;
        }

        .confirm-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.7s ease;
        }

        .confirm-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(138, 77, 0, 0.4);
        }

        .confirm-btn:hover::before {
            left: 100%;
        }

        .confirm-btn:active {
            transform: translateY(0);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        /* Loading animation for buttons */
        .loading {
            position: relative;
            pointer-events: none;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 1024px) {
            .dashboard-container {
                grid-template-columns: 1fr;
                gap: 30px;
                max-width: 600px;
            }

            .left-panel, .right-panel {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 30px 15px;
                gap: 25px;
            }

            .saldo-box {
                padding: 40px 25px;
            }

            .saldo-value {
                font-size: 3.2rem;
            }

            .payment-methods {
                padding: 30px 20px;
            }

            .amount-options {
                grid-template-columns: repeat(2, 1fr);
            }

            .payment-option {
                padding: 20px;
            }

            .payment-icon {
                width: 50px;
                height: 50px;
                margin-right: 15px;
            }
        }

        @media (max-width: 480px) {
            .saldo-value {
                font-size: 2.8rem;
            }

            .amount-options {
                grid-template-columns: 1fr;
            }

            .payment-methods h2 {
                font-size: 1.7rem;
            }

            .payment-info h3 {
                font-size: 1.2rem;
            }

            .dashboard-container {
                padding: 20px 15px;
            }
        }
    </style>

    <canvas id="particles"></canvas>

    <div class="dashboard-container">
        <!-- Left Side - Saldo -->
        <div class="left-panel">
            <div class="saldo-box">
                <h1>Saldo Atual</h1>
                <div class="saldo-value">{{ number_format(Auth::user()->saldo, 2, ',', '.') }} €</div>
                <p>Última atualização: {{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <!-- Right Side - Pagamento -->
        <div class="right-panel">
            <div class="payment-methods">
                <h2>Escolha um Método de Pagamento</h2>
                <div class="payment-options">
                    <div class="payment-option" data-method="paypal">
                        <div class="payment-icon">
                            <i class="fab fa-paypal"></i>
                        </div>
                        <div class="payment-info">
                            <h3>PayPal</h3>
                            <p>Pagamento rápido e seguro</p>
                        </div>
                        <div class="payment-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>

                    <div class="payment-option" data-method="credit_card">
                        <div class="payment-icon">
                            <i class="far fa-credit-card"></i>
                        </div>
                        <div class="payment-info">
                            <h3>Cartão de Crédito</h3>
                            <p>Visa, Mastercard, American Express</p>
                        </div>
                        <div class="payment-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>

                    <div class="payment-option" data-method="bank_transfer">
                        <div class="payment-icon">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="payment-info">
                            <h3>Transferência Bancária</h3>
                            <p>Transferência direta para a sua conta</p>
                        </div>
                        <div class="payment-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </div>

                <div class="amount-selector" id="amountSelector">
                    <h3>Selecione o valor para recarregar</h3>
                    <div class="amount-options">
                        <div class="amount-option" data-amount="10">10 €</div>
                        <div class="amount-option" data-amount="25">25 €</div>
                        <div class="amount-option" data-amount="50">50 €</div>
                        <div class="amount-option" data-amount="75">75 €</div>
                        <div class="amount-option" data-amount="100">100 €</div>
                        <div class="amount-option" data-amount="200">200 €</div>
                    </div>
                    <div class="custom-amount">
                        <input type="number" id="customAmount" placeholder="Outro valor (€)" min="5" step="0.01">
                    </div>
                    <form method="POST" action="{{ route('saldo.recarregar') }}" id="paymentForm">
                        @csrf
                        <input type="hidden" name="method" id="selectedMethod">
                        <input type="hidden" name="valor" id="selectedAmount">
                        <button type="submit" class="confirm-btn">Confirmar Recarga</button>
                    </form>
                </div>
            </div>
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

        document.addEventListener('DOMContentLoaded', function() {
            const paymentOptions = document.querySelectorAll('.payment-option');
            const amountSelector = document.getElementById('amountSelector');
            const amountOptions = document.querySelectorAll('.amount-option');
            const customAmountInput = document.getElementById('customAmount');
            const selectedMethodInput = document.getElementById('selectedMethod');
            const selectedAmountInput = document.getElementById('selectedAmount');
            const paymentForm = document.getElementById('paymentForm');
            const confirmBtn = document.querySelector('.confirm-btn');

            let selectedMethod = null;
            let selectedAmount = null;

            // Add visual feedback for selected payment method
            paymentOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selection from all options
                    paymentOptions.forEach(opt => {
                        opt.style.borderColor = 'transparent';
                        opt.style.background = 'rgba(255, 255, 255, 0.7)';
                    });

                    // Add selection to clicked option
                    this.style.borderColor = 'var(--primary-light)';
                    this.style.background = 'rgba(255, 255, 255, 0.9)';

                    selectedMethod = this.getAttribute('data-method');
                    selectedMethodInput.value = selectedMethod;

                    amountSelector.classList.add('active');

                    amountOptions.forEach(opt => opt.classList.remove('selected'));
                    customAmountInput.value = '';
                    selectedAmount = null;

                    // Update button state
                    updateConfirmButton();
                });
            });

            amountOptions.forEach(option => {
                option.addEventListener('click', function() {
                    amountOptions.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                    customAmountInput.value = '';
                    selectedAmount = this.getAttribute('data-amount');
                    selectedAmountInput.value = selectedAmount;

                    updateConfirmButton();
                });
            });

            customAmountInput.addEventListener('input', function() {
                amountOptions.forEach(opt => opt.classList.remove('selected'));
                selectedAmount = this.value;
                selectedAmountInput.value = selectedAmount;

                updateConfirmButton();
            });

            function updateConfirmButton() {
                if (selectedMethod && selectedAmount && selectedAmount >= 5) {
                    confirmBtn.style.opacity = '1';
                    confirmBtn.style.cursor = 'pointer';
                } else {
                    confirmBtn.style.opacity = '0.7';
                    confirmBtn.style.cursor = 'not-allowed';
                }
            }

            paymentForm.addEventListener('submit', function(e) {
                if (!selectedMethod) {
                    e.preventDefault();
                    alert('Por favor, selecione um método de pagamento.');
                    return;
                }

                if (!selectedAmount || selectedAmount < 5) {
                    e.preventDefault();
                    alert('Por favor, selecione um valor válido (mínimo 5€).');
                    return;
                }

                // Add loading state
                confirmBtn.classList.add('loading');
                confirmBtn.innerHTML = 'Processando...';
            });

            init();
            updateConfirmButton();
        });
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endsection