<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Letter;

class LetterController extends Controller
{
    public function show($id)
    {
        $produto = Letter::findOrFail($id);
        return view('products.show', compact('produto'));
    }

    function letter() {
        $produtos = Letter::all();
        return view('shop.letter', compact('produtos'));
    }

    public function create()
    {
        return view('shop.letter_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric',
            'imagem' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagemPath = null;
        if ($request->hasFile('imagem')) {
            $imagemPath = $request->file('imagem')->store('produtos', 'public');
        }

        // Criando o registro no banco de dados
        Letter::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'imagem' => $imagemPath, // Caminho da imagem salvo no banco
        ]);

        // Redirecionando com uma mensagem de sucesso
        return redirect()->route('letter')->with('success', 'Produto adicionado com sucesso!');
    }
}
