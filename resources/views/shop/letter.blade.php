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

    .products-wrapper {
        max-width: 1400px;
        margin: 4rem auto;
        padding: 0 2rem;
    }

    .top-actions {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 1.5rem;
    }

    .top-actions a {
        text-decoration: none;
        padding: 0.75rem 1.5rem;
        background: var(--primary-color);
        color: white;
        border-radius: 50px;
        font-weight: 600;
        transition: var(--transition);
    }

    .top-actions a:hover {
        background: var(--primary-light);
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .product-card {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: var(--transition);
        cursor: pointer;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }

    .product-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-bottom: 1px solid var(--text-light);
    }

    .product-content {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .product-description {
        color: var(--text-medium);
        font-size: 0.95rem;
        margin-bottom: 1rem;
        flex-grow: 1;
    }

    .product-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .product-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn {
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
        transition: var(--transition);
        cursor: pointer;
        flex: 1;
        text-align: center;
        padding: 0.75rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: var(--card-bg);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-light), var(--primary-color));
    }

    .btn-secondary {
        background: var(--text-light);
        color: var(--card-bg);
        border: none;
    }

    .btn-secondary:hover {
        background: var(--secondary-color);
    }
</style>

<canvas id="particles"></canvas>

<div class="products-wrapper">
    <div class="top-actions">
        <a href="{{ route('letter.create') }}"><i class="fas fa-plus"></i> Adicionar Produto</a>
    </div>

    <h1 style="color: var(--primary-color); font-weight: 800; margin-bottom: 2rem;">Nossos Produtos</h1>

    <div class="products-grid">
        @foreach($produtos as $produto)
            <div class="product-card">
                <a href="{{ route('letter.show', $produto->id) }}">
                    <img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome }}" class="product-image">
                    <div class="product-content">
                        <div class="product-title">{{ $produto->nome }}</div>
                        <div class="product-description">{{ $produto->descricao }}</div>
                        <div class="product-price">{{ $produto->preco }} €</div>
                    </div>
                </a>
            </div>
        @endforeach
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
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI*2);
            ctx.fillStyle = "#ffffff";
            ctx.fill();
        }
    }

    function connectParticles() {
        for(let a=0; a<total; a++){
            for(let b=a+1; b<total; b++){
                let dx = particles[a].x - particles[b].x;
                let dy = particles[a].y - particles[b].y;
                let distance = Math.sqrt(dx*dx + dy*dy);
                if(distance < 150){
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
        ctx.clearRect(0,0,canvas.width, canvas.height);
        for(let p of particles){ p.move(); p.draw(); }
        connectParticles();
        requestAnimationFrame(animate);
    }

    function initParticles(){
        for(let i=0;i<total;i++){ particles.push(new Particle()); }
        animate();
    }

    window.addEventListener('resize', ()=>{
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    });

    initParticles();
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
