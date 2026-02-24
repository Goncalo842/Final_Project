<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        :root {
            --accent: #2b6cb0;
            --muted: #6b7280
        }

        body {
            font-family: Inter, Arial, Helvetica, sans-serif;
            color: #111;
            margin: 0;
            padding: 28px;
            background: #fff
        }

        .sheet {
            max-width: 760px;
            margin: 0 auto;
            border: 1px solid #eee;
            <!doctype html>
            <html>

            <head>
                <meta charset="utf-8">
                <title>{{ $title }}</title>
                <style>
                    body {
                        font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
                        color: #222;
                    }

                    .page {
                        padding: 28px;
                    }

                    .header {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        border-bottom: 4px solid #f0e6d8;
                        padding-bottom: 12px;
                    }

                    .brand {
                        display: flex;
                        gap: 12px;
                        align-items: center;
                    }

                    .brand img {
                        width: 72px;
                        height: 72px;
                        object-fit: contain;
                        border-radius: 8px;
                    }

                    .brand h2 {
                        margin: 0;
                        color: #8a4d00;
                        font-size: 20px;
                    }

                    .meta {
                        text-align: right;
                        font-size: 12px;
                        color: #666;
                    }

                    h3 {
                        color: #8a4d00;
                        margin-top: 20px;
                    }

                    .section {
                        margin-top: 12px;
                        font-size: 13px;
                    }

                    .footer {
                        margin-top: 28px;
                        font-size: 12px;
                        color: #666;
                        border-top: 1px dashed #eee;
                        padding-top: 12px;
                    }
                </style>
            </head>

            <body>
                <div class="page">
                    <div class="header">
                        <div class="brand">
                            @if (file_exists(public_path('images/logo.png')))
                                <img src="{{ public_path('images/logo.png') }}" alt="Logo">
                            @else
                                <div style="width:72px;height:72px;border-radius:8px;background:#f5f5f5;display:flex;align-items:center;justify-content:center;color:#bbb;font-weight:700">LOGO
                                </div>
                            @endif
                            <div>
                                <h2>Escola Superior de Tecnologia</h2>
                                <div style="font-size:12px;color:#777;">Plano Curricular</div>
                            </div>
                        </div>
                        <div class="meta">
                            <div>Emitido: {{

                                \Carbon\Carbon::parse($generated_at ?? now())->format('d/m/Y H:i')
                            }}</div>
                            <div>Referência: {{ $reference }}</div>
                        </div>
                    </div>

                    <div class="section">
                        <p>{{ $intro ?? 'Documento genérico de plano curricular.' }}</p>
                    </div>

                    <h3>Sobre o ISTP</h3>
                    <div class="section">
                        <p>O ISTP promove formação técnica superior com foco em empregabilidade, inovação e ligação ao tecido empresarial.</p>
                    </div>

                    <h3>Destaques</h3>
                    <div class="section">
                        <ul>
                            <li>Formação prática e aplicada.</li>
                            <li>Projetos em parceria com empresas.</li>
                            <li>Atualização curricular contínua.</li>
                        </ul>
                    </div>

                    <div class="section footer">
                        Observação: Documento.<br>
                        ISTP — Instituto Superior Técnico Profissional · Contacto: secretaria@istp.example · Telefone: +351 21 000 000
                    </div>
                </div>
            </body>

            </html>

            color: var(--muted);
            border-top: 1px dashed #eee;
            padding-top: 12px
        }

        .obs {
            margin-top: 12px;
            font-weight: 600
        }
    </style>
</head>

<body>
    <div class="sheet">
        <div class="brand">
            <div class="logo">ISTP</div>
            <div>
                <h1>{{ $title }}</h1>
                <div class="meta">Referência: {{ $reference }} | Gerado em: {{ $generated_at }}</div>
            </div>
        </div>

        <div class="intro">
            {{ $intro ?? 'Documento genérico de plano curricular.' }}
        </div>

        <div class="section">
            <h3>Sobre o ISTP</h3>
            <p>O ISTP é uma instituição que promove formação técnica superior com foco em empregabilidade, inovação e
                ligação ao tecido empresarial. Apostamos em metodologias práticas e projetos reais para formar
                profissionais prontos para o mercado.</p>
        </div>

        <div class="section">
            <h3>Destaques do CTeSP</h3>
            <ul class="highlights">
                <li>Formação orientada para desenvolvimento de competências práticas.</li>
                <li>Projetos integradores e contacto com empresas locais.</li>
                <li>Currículo atualizado com ênfase em tecnologias web e segurança.</li>
            </ul>
        </div>

        <div class="section obs">Observação: Documento.</div>

        <footer>
            ISTP — Instituto Superior Técnico Profissional · Contacto: secretaria@istp.example · Telefone: +351 21 000
            000
        </footer>
    </div>
</body>

</html>
