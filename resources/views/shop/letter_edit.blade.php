@extends('layout.fe_settings')
@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #e3e2e2, #e3e2e2, #c4c4c4, #e3e2e2, #e3e2e2);
            font-family: 'Montserrat', sans-serif;
            position: relative;
            min-height: 100vh;
        }

        canvas#particles {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .letter-wrapper {
            position: relative;
            z-index: 1;
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .letter-wrapper label { display:block; margin-bottom:6px; font-weight:700; }
        .letter-wrapper input[type="text"], .letter-wrapper textarea, .letter-wrapper input[type="number"] {
            width:100%; padding:0.75rem; border:1px solid #ccc; border-radius:8px;
        }
    </style>

    <canvas id="particles"></canvas>

    <div class="letter-wrapper">
        <h2 style="margin-bottom:1rem;color:#8a4d00;">Editar Produto</h2>

        @if (session('success'))
            <div style="background:#d4edda;color:#155724;padding:1rem;border-radius:8px;margin-bottom:1rem;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background:#f8d7da;color:#721c24;padding:1rem;border-radius:8px;margin-bottom:1rem;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('stock.update', $produto->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-bottom:1rem;">
                <label>Nome do Produto</label>
                <input type="text" name="nome" value="{{ old('nome', $produto->nome) }}" required>
            </div>

            <div style="margin-bottom:1rem;">
                <label>Descrição</label>
                <textarea name="descricao" rows="4" required>{{ old('descricao', $produto->descricao) }}</textarea>
            </div>

            <div style="margin-bottom:1rem;">
                <label>Preço (€)</label>
                <input type="number" step="0.01" name="preco" value="{{ old('preco', $produto->preco) }}" required>
            </div>

            <div style="margin-bottom:1rem;">
                <label>Imagem do Produto (substituir)</label>
                <input type="file" name="imagem" accept="image/*">
                @if($produto->imagem)
                    <div style="margin-top:8px;"><img src="{{ asset('storage/'.$produto->imagem) }}" alt="imagem" style="max-width:180px;border-radius:8px;border:1px solid #eee;"/></div>
                @endif
            </div>

            <button type="submit" style="padding:0.75rem 1.5rem;background:#8a4d00;color:white;border:none;border-radius:50px;font-weight:600;cursor:pointer;">Guardar Alterações</button>
            <a href="{{ route('stock') }}" style="margin-left:12px;padding:0.75rem 1.2rem;background:#f3f3f3;color:#333;border-radius:50px;text-decoration:none;border:1px solid #e6e6e6;">Cancelar</a>
        </form>
    </div>

    <script>
        window.addEventListener('load', () => {
            const canvas = document.getElementById('particles');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            function resize() { canvas.width = window.innerWidth; canvas.height = window.innerHeight; }
            resize(); window.addEventListener('resize', resize);

            const particles = [];
            const total = 70;

            class Particle {
                constructor() { this.x = Math.random() * canvas.width; this.y = Math.random() * canvas.height; this.vx = (Math.random() - 0.5) * 1.2; this.vy = (Math.random() - 0.5) * 1.2; this.r = 2.6; }
                move() { this.x += this.vx; this.y += this.vy; if (this.x < 0 || this.x > canvas.width) this.vx *= -1; if (this.y < 0 || this.y > canvas.height) this.vy *= -1; }
                draw() { ctx.beginPath(); ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2); ctx.fillStyle = 'rgba(255,255,255,0.7)'; ctx.fill(); }
            }

            for (let i = 0; i < total; i++) particles.push(new Particle());

            function connect() {
                for (let a = 0; a < total; a++) {
                    for (let b = a + 1; b < total; b++) {
                        const dx = particles[a].x - particles[b].x; const dy = particles[a].y - particles[b].y; const dist = Math.sqrt(dx*dx + dy*dy);
                        if (dist < 130) { ctx.beginPath(); ctx.moveTo(particles[a].x, particles[a].y); ctx.lineTo(particles[b].x, particles[b].y); ctx.strokeStyle = `rgba(255,255,255,${0.35 * (1 - dist / 130)})`; ctx.stroke(); }
                    }
                }
            }

            function animate() { ctx.clearRect(0,0,canvas.width,canvas.height); for (const p of particles) { p.move(); p.draw(); } connect(); requestAnimationFrame(animate); }
            animate();
        });
    </script>
@endsection
