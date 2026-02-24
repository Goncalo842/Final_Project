<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprovativo de Pagamento - {{ $mes }}</title>
    <style>
        @page { margin: 20mm }
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color: #2b2b2b; background: #fff; }
        .paper { max-width: 800px; margin: 0 auto; padding: 28px; border: 1px solid #e6e6e6; box-shadow: 0 4px 18px rgba(0,0,0,0.04); }
        .top { display:flex; justify-content: space-between; align-items: center; }
        .brand { display:flex; align-items:center; gap:16px; }
        .brand img { width:86px; height:86px; object-fit:contain; border-radius:8px; }
        .brand h2 { margin:0; font-size:20px; color:#8a4d00; letter-spacing:0.5px; }
        .meta { text-align:right; font-size:12px; color:#666; }

        .title { margin-top:20px; display:flex; justify-content:space-between; align-items:center; }
        .title h1 { margin:0; font-size:22px; color:#333; }
        .badge { background: #eaf6f1; color:#1b6b49; padding:6px 10px; border-radius:6px; font-weight:700; }

        .info { margin-top:18px; display:flex; justify-content:space-between; gap:20px; }
        .info .left, .info .right { width:48%; }
        .info table { width:100%; border-collapse:collapse; }
        .info td { padding:8px 6px; vertical-align:top; }
        .info .label { color:#777; width:35%; }
        .info .value { color:#111; font-weight:600; }

        .amount { margin-top:22px; padding:18px; background:linear-gradient(90deg,#fff7ef,#fff4eb); border-left:6px solid #f6b267; border-radius:8px; display:flex; justify-content:space-between; align-items:center; }
        .amount .left { font-size:14px; color:#555; }
        .amount .right { font-size:20px; color:#8a4d00; font-weight:800; }

        .footer { margin-top:26px; display:flex; justify-content:space-between; align-items:center; font-size:12px; color:#666; }
        .small { font-size:11px; color:#999; }

        @media print { .paper { box-shadow:none; border-color:#ddd } }
    </style>
</head>
<body>
    <div class="paper">
        <div class="top">
            <div class="brand">
                @if(file_exists(public_path('images/imagem2.jpeg')))
                    <img src="{{ public_path('images/imagem2.jpeg') }}" alt="">
                @else
                    <div style="width:86px;height:86px;border-radius:8px;background:#f5f5f5;display:flex;align-items:center;justify-content:center;color:#bbb;font-weight:700">LOGO</div>
                @endif
                <div>
                    <h2>Escola Superior de Tecnologia</h2>
                    <div class="small">Comprovativo de Pagamento Oficial</div>
                </div>
            </div>

            <div class="meta">
                <div>Emitido em: {{ now()->format('d/m/Y') }}</div>
                <div>Ref: PGT-{{ $pagamento->id }}</div>
            </div>
        </div>

        <div class="title">
            <h1>Comprovativo — {{ $mes }}</h1>
            <div class="badge">Pago</div>
        </div>

        <div class="info">
            <div class="left">
                <table>
                    <tr>
                        <td class="label">Nome</td>
                        <td class="value">{{ $user->name ?? $user->email }}</td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td class="value">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td class="label">Aluno</td>
                        <td class="value">#{{ $user->id }}</td>
                    </tr>
                </table>
            </div>

            <div class="right">
                <table>
                    <tr>
                        <td class="label">Mês</td>
                        <td class="value">{{ $mes }}</td>
                    </tr>
                    <tr>
                        <td class="label">Data de pagamento</td>
                        <td class="value">{{ $pagamento->updated_at ? $pagamento->updated_at->format('d/m/Y H:i') : $pagamento->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Referência</td>
                        <td class="value">PGT-{{ $pagamento->id }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="amount">
            <div class="left">Pagamento referente a propina mensal</div>
            <div class="right">220,00 €</div>
        </div>

        <div class="footer">
            <div>Assinado digitalmente pela Escola Superior de Tecnologia</div>
            <div class="small">Este comprovativo é um documento gerado eletronicamente e válido sem assinatura física.</div>
        </div>
    </div>
</body>
</html>
