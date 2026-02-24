<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

    public function edit($id)
    {
        $produto = Stock::findOrFail($id);
        return view('shop.letter_edit', compact('produto'));
    }

    public function update(Request $request, $id)
    {
        $produto = Stock::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'preco' => 'required|numeric',
            'imagem' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        if ($request->hasFile('imagem')) {
            $imagemPath = $request->file('imagem')->store('produtos', 'public');
            
            if ($produto->imagem && Storage::disk('public')->exists($produto->imagem)) {
                Storage::disk('public')->delete($produto->imagem);
            }
            $produto->imagem = $imagemPath;
        }

        $produto->nome = $request->nome;
        $produto->descricao = $request->descricao;
        $produto->preco = $request->preco;
        $produto->save();

        return redirect()->route('stock')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = Stock::findOrFail($id);
        $produto->delete();
        return redirect()->route('stock')->with('success', 'Produto removido com sucesso!');
    }
}
