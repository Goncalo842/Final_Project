<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color:#222 }
        .page{padding:28px}
        .header{display:flex;justify-content:space-between;align-items:center;border-bottom:4px solid #f0e6d8;padding-bottom:12px}
        .brand{display:flex;gap:12px;align-items:center}
        .brand h2{margin:0;color:#8a4d00;font-size:20px}
        .meta{text-align:right;font-size:12px;color:#666}
        .section{margin-top:12px;font-size:13px}
        .footer{margin-top:28px;font-size:12px;color:#666;border-top:1px dashed #eee;padding-top:12px}
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <div class="brand">
                @if (file_exists(public_path('images/logo.png')))
                    <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="width:72px;height:72px;object-fit:contain;border-radius:8px">
                @else
                    <div style="width:72px;height:72px;border-radius:8px;background:#f5f5f5;display:flex;align-items:center;justify-content:center;color:#bbb;font-weight:700">LOGO</div>
                @endif
                <div>
                    <h2>Escola Superior de Tecnologia</h2>
                    <div style="font-size:12px;color:#777;">Guia de Lançamento</div>
                </div>
            </div>
            <div class="meta">
                <div>Emitido: {{ \Carbon\Carbon::parse($generated_at ?? now())->format('d/m/Y H:i') }}</div>
                <div>Referência: {{ $reference }}</div>
            </div>
        </div>

        <div class="section">
            <p>{{ $body }}</p>
        </div>

        <div class="section footer">
            Observação: Siga sempre os prazos indicados no painel docente.
        </div>
    </div>
</body>
</html>
