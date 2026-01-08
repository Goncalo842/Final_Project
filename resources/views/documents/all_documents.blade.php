<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Documentos da Escola</title>
    <style>
        body { font-family: DejaVu Sans, Arial, Helvetica, sans-serif; color: #222; }
        .page { padding: 28px; }
        .header { display:flex; justify-content:space-between; align-items:center; border-bottom:4px solid #f0e6d8; padding-bottom:12px; }
        .brand { display:flex; gap:12px; align-items:center; }
        .brand img { width:72px; height:72px; object-fit:contain; border-radius:8px; }
        .brand h2 { margin:0; color:#8a4d00; font-size:20px; }
        .meta { text-align:right; font-size:12px; color:#666; }
        h3 { color:#8a4d00; margin-top:20px; }
        .section { margin-top:12px; font-size:13px; }
        table { width:100%; border-collapse:collapse; margin-top:8px; }
        th, td { padding:8px; border:1px solid #eee; }
        .footer { margin-top:28px; font-size:12px; color:#666; border-top:1px dashed #eee; padding-top:12px; }
    </style>
</head>
<body>
<div class="page">
    <div class="header">
        <div class="brand">
            @if(file_exists(public_path('images/logo.png')))
                <img src="{{ public_path('images/logo.png') }}" alt="Logo">
            @else
                <div style="width:72px;height:72px;border-radius:8px;background:#f5f5f5;display:flex;align-items:center;justify-content:center;color:#bbb;font-weight:700">LOGO</div>
            @endif
            <div>
                <h2>Escola Superior de Tecnologia</h2>
                <div style="font-size:12px;color:#777;">Pacote de documentos</div>
            </div>
        </div>
        <div class="meta">
            <div>Emitido: {{ now()->format('d/m/Y') }}</div>
            <div>Aluno: {{ $user->name ?? $user->email }}</div>
        </div>
    </div>

    <h3>Datas importantes</h3>
    <div class="section">
        <ul>
            @foreach($importantDates as $d)
                <li>{{ $d }}</li>
            @endforeach
        </ul>
    </div>

    <h3>Férias</h3>
    <div class="section">
        <ul>
            @foreach($vacations as $v)
                <li>{{ $v }}</li>
            @endforeach
        </ul>
    </div>

    <h3>Avisos</h3>
    <div class="section">
        @foreach($notices as $n)
            <p><strong>{{ $n['title'] }}</strong><br>{{ $n['text'] }}</p>
        @endforeach
    </div>

    <h3>Faltas registadas</h3>
    <div class="section">
        @if($faltas->count() > 0)
            <table>
                <thead>
                    <tr><th>Data</th><th>Disciplina</th><th>Motivo</th></tr>
                </thead>
                <tbody>
                @foreach($faltas as $f)
                    <tr>
                        <td>{{ $f->data }}</td>
                        <td>{{ $f->disciplina_nome ?? '-' }}</td>
                        <td>{{ $f->motivo ?? '-' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Nenhuma falta registada.</p>
        @endif
    </div>

    <div class="footer">
        Documento gerado automaticamente pela Escola Superior de Tecnologia.
    </div>
</div>
</body>
</html>
