@extends('layout.fe_settings')
@section('content')
    <div
        style="max-width:600px;margin:2rem auto;padding:2rem;background:white;border-radius:16px;box-shadow:0 5px 15px rgba(0,0,0,0.1);">
        <h2 style="margin-bottom:1rem;color:#8a4d00;">Adicionar Produto</h2>

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

        <form action="{{ route('letter.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom:1rem;">
                <label>Nome do Produto</label>
                <input type="text" name="nome"
                    style="width:100%;padding:0.75rem;border:1px solid #ccc;border-radius:8px;" required>
            </div>

            <div style="margin-bottom:1rem;">
                <label>Descrição</label>
                <textarea name="descricao" style="width:100%;padding:0.75rem;border:1px solid #ccc;border-radius:8px;" required></textarea>
            </div>

            <div style="margin-bottom:1rem;">
                <label>Preço (€)</label>
                <input type="number" step="0.01" name="preco"
                    style="width:100%;padding:0.75rem;border:1px solid #ccc;border-radius:8px;" required>
            </div>

            <div style="margin-bottom:1rem;">
                <label>Imagem do Produto</label>
                <input type="file" name="imagem" accept="image/*">
            </div>

            <button type="submit"
                style="padding:0.75rem 1.5rem;background:#8a4d00;color:white;border:none;border-radius:50px;font-weight:600;cursor:pointer;">
                Adicionar Produto
            </button>
        </form>
    </div>
@endsection
