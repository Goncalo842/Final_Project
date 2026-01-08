<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{
    public function show($id)
    {
        $produto = Stock::findOrFail($id);
        return view('products.show', compact('produto'));
    }

    public function index()
    {
        $produtos = Stock::all();
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
            'imagem' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        $imagemPath = null;
        if ($request->hasFile('imagem')) {
            $imagemPath = $request->file('imagem')->store('produtos', 'public');
        }

        Stock::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'preco' => $request->preco,
            'imagem' => $imagemPath,
        ]);

        return redirect()->route('stock')->with('success', 'Produto adicionado com sucesso!');
    }
}
