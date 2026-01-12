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

        .confirm-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 1.05rem;
        }

        .form-group input {
            width: 100%;
            padding: 18px 20px;
            border: 2px solid #e8e8e8;
            border-radius: 12px;
            font-size: 1.05rem;
            transition: var(--transition);
            background: white;
        }

        .form-group input:focus {
            border-color: var(--primary-light);
            outline: none;
            box-shadow: 0 0 0 3px rgba(204, 122, 0, 0.1);
            transform: translateY(-2px);
        }

        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            padding: 20px 30px;
            border-radius: 12px;
            color: white;
            font-weight: 500;
            animation: slideInRight 0.5s ease;
            display: flex;
            align-items: center;
        }

        .alert-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        }

        .alert-error {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
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
        }

        @media (max-width: 480px) {
            .saldo-value {
                font-size: 2.8rem;
            }

            .payment-methods h2 {
                font-size: 1.7rem;
            }

            .dashboard-container {
                padding: 20px 15px;
            }
        }
    </style>

    <canvas id="particles"></canvas>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle" style="margin-right: 10px;"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle" style="margin-right: 10px;"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="dashboard-container">
        <div class="left-panel">
            <div class="saldo-box">
                <h1>Saldo Atual</h1>
                <div class="saldo-value">{{ number_format(Auth::user()->saldo, 2, ',', '.') }} €</div>
                <p>Última atualização: {{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="right-panel">
            <div class="payment-methods">
                <h2>Recarregar Saldo via Stripe</h2>

                <form id="paymentForm">
                    @csrf

                    <div class="form-group">
                        <label for="amount">
                            <i class="fas fa-euro-sign" style="margin-right: 5px;"></i>
                            Valor da Recarga (€)
                        </label>
                        <input
                            type="number"
                            id="amount"
                            name="amount"
                            min="5"
                            step="0.01"
                            placeholder="Mínimo €5.00"
                            required
                        >
                        <small style="color: var(--text-light); font-size: 0.9rem; margin-top: 5px; display: block;">
                            Valor mínimo: €5.00
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope" style="margin-right: 5px;"></i>
                            Email
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ Auth::user()->email }}"
                            placeholder="seu@email.com"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="cardholder-name">
                            <i class="fas fa-user" style="margin-right: 5px;"></i>
                            Nome no Cartão
                        </label>
                        <input
                            type="text"
                            id="cardholder-name"
                            name="cardholder_name"
                            placeholder="Nome como está no cartão"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="card-element">
                            <i class="fas fa-credit-card" style="margin-right: 5px;"></i>
                            Informações do Cartão
                        </label>
                        <div id="card-element" style="padding: 12px; border: 1px solid #ddd; border-radius: 8px; background: white;"></div>
                        <div id="card-errors" role="alert" style="color: #e74c3c; font-size: 0.9rem; margin-top: 8px;"></div>
                    </div>

                    <button type="submit" class="confirm-btn" id="submit-btn">
                        <i class="fab fa-stripe" style="margin-right: 8px;"></i>
                        Pagar com Stripe
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ config("services.stripe.key") }}');
        const elements = stripe.elements();

        const cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#1a1a1a',
                    fontFamily: '"Montserrat", sans-serif',
                    '::placeholder': {
                        color: '#aab7c4',
                    },
                },
                invalid: {
                    color: '#e74c3c',
                    iconColor: '#e74c3c'
                }
            },
            hidePostalCode: true
        });

        cardElement.mount('#card-element');

        cardElement.on('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

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
            const paymentForm = document.getElementById('paymentForm');
            const amountInput = document.getElementById('amount');
            const emailInput = document.getElementById('email');
            const cardholderName = document.getElementById('cardholder-name');
            const submitBtn = document.getElementById('submit-btn');

            paymentForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const amount = parseFloat(amountInput.value);

                if (!amount || amount < 5) {
                    alert('Por favor, insira um valor mínimo de €5.00');
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processando...';

                try {
                    const response = await fetch('{{ route("stripe.checkout") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            amount: amount,
                            email: emailInput.value
                        })
                    });

                    const data = await response.json();

                    if (data.error) {
                        alert('Erro: ' + data.error);
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fab fa-stripe"></i> Pagar com Stripe';
                        return;
                    }

                    const {error, paymentIntent} = await stripe.confirmCardPayment(data.clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {
                                name: cardholderName.value,
                                email: emailInput.value
                            }
                        }
                    });

                    if (error) {
                        document.getElementById('card-errors').textContent = error.message;
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fab fa-stripe"></i> Pagar com Stripe';
                    } else if (paymentIntent.status === 'succeeded') {
                        window.location.href = '{{ route("payment.success") }}?payment_intent=' + paymentIntent.id;
                    }

                } catch (error) {
                    console.error('Error:', error);
                    alert('Erro ao processar pagamento. Tente novamente.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fab fa-stripe"></i> Pagar com Stripe';
                }
            });

            init();

            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateX(100px)';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endsection
