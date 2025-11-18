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
            --shadow-lg: 0 15px 30px rgba(0, 0, 0, 0.2);
            --border-radius: 16px;
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
        }

        .saldo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 80vh;
            padding: 20px;
        }

        .saldo-box {
            background: var(--card-bg);
            box-shadow: var(--shadow-lg);
            border-radius: var(--border-radius);
            padding: 40px;
            text-align: center;
            margin-bottom: 30px;
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .saldo-box:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .saldo-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
        }

        .saldo-box h1 {
            font-size: 1.5rem;
            color: var(--text-medium);
            margin-bottom: 15px;
            font-weight: 500;
        }

        .saldo-value {
            font-size: 3.5rem;
            color: var(--primary-color);
            font-weight: 700;
            margin: 10px 0;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
        }

        .saldo-box p {
            font-size: 1rem;
            color: var(--text-light);
        }

        .payment-methods {
            background: var(--card-bg);
            box-shadow: var(--shadow-md);
            border-radius: var(--border-radius);
            padding: 30px;
            width: 100%;
            max-width: 600px;
            transition: var(--transition);
        }

        .payment-methods:hover {
            box-shadow: var(--shadow-lg);
        }

        .payment-methods h2 {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
        }

        .payment-options {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .payment-option {
            display: flex;
            align-items: center;
            padding: 18px 20px;
            background: #f9f9f9;
            border-radius: 12px;
            cursor: pointer;
            transition: var(--transition);
            border: 2px solid transparent;
        }

        .payment-option:hover {
            background: #f0f0f0;
            transform: translateX(5px);
            border-color: var(--primary-light);
        }

        .payment-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-light);
            color: white;
            border-radius: 50%;
            margin-right: 15px;<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
            font-size: 1.2rem;
        }

        .payment-info {
            flex-grow: 1;
            text-align: left;
        }

        .payment-info h3 {
            font-size: 1.2rem;
            color: var(--text-dark);
            margin-bottom: 5px;
            font-weight: 600;
        }

        .payment-info p {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .payment-arrow {
            color: var(--primary-color);
            font-size: 1.2rem;
            transition: var(--transition);
        }

        .payment-option:hover .payment-arrow {
            transform: translateX(5px);
        }

        .amount-selector {
            margin-top: 25px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 12px;
            display: none;
        }

        .amount-selector.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        .amount-selector h3 {
            font-size: 1.2rem;
            color: var(--text-dark);
            margin-bottom: 15px;
            text-align: center;
        }

        .amount-options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .amount-option {
            padding: 12px;
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 500;
        }

        .amount-option:hover {
            border-color: var(--primary-light);
        }

        .amount-option.selected {
            background: var(--primary-light);
            color: white;
            border-color: var(--primary-light);
        }

        .custom-amount {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .custom-amount input {
            flex-grow: 1;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .custom-amount input:focus {
            border-color: var(--primary-light);
            outline: none;
        }

        .confirm-btn {
            width: 100%;
            padding: 15px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .confirm-btn:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .saldo-box {
                padding: 30px 20px;
            }

            .saldo-value {
                font-size: 2.8rem;
            }

            .payment-methods {
                padding: 20px;
            }

            .amount-options {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    <canvas id="particles"></canvas>

    <div class="saldo-container">
        <div class="saldo-box">
            <h1>Saldo Atual</h1>
            <div class="saldo-value">{{ number_format(Auth::user()->saldo, 2, ',', '.') }} €</div>
            <p>Última atualização: {{ now()->format('d/m/Y H:i') }}</p>
        </div>

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

            let selectedMethod = null;
            let selectedAmount = null;

            paymentOptions.forEach(option => {
                option.addEventListener('click', function() {
                    selectedMethod = this.getAttribute('data-method');
                    selectedMethodInput.value = selectedMethod;

                    amountSelector.classList.add('active');

                    amountOptions.forEach(opt => opt.classList.remove('selected'));
                    customAmountInput.value = '';
                    selectedAmount = null;
                });
            });

            amountOptions.forEach(option => {
                option.addEventListener('click', function() {
                    amountOptions.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                    customAmountInput.value = '';
                    selectedAmount = this.getAttribute('data-amount');
                    selectedAmountInput.value = selectedAmount;
                });
            });

            customAmountInput.addEventListener('input', function() {
                amountOptions.forEach(opt => opt.classList.remove('selected'));
                selectedAmount = this.value;
                selectedAmountInput.value = selectedAmount;
            });

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
            });

            init();
        });
    </script>

@endsection