<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Letter;

class SaldoController extends Controller
{
    public function saldo()
    {
        return view('saldo');
    }

    public function recarregar(Request $request)
    {
        $request->validate([
            'valor' => 'required|numeric|min:1',
        ]);

        $user = auth()->user();
        $valor = $request->input('valor');

        $user->saldo += $valor;
        $user->save();

        return redirect()->back()->with('success', 'Recarga de R$ ' . number_format($valor, 2, ',', '.') . ' realizada com sucesso!');
    }

    public function adquirir($id)
    {
        $produto = Letter::findOrFail($id);
        $user = Auth::user();

        if ($user->saldo < $produto->preco) {
            return redirect()->back()->with('error', 'Saldo insuficiente para adquirir este produto.');
        }

        $user->saldo -= $produto->preco;
        $user->save();

        return redirect()->back()->with('success', 'Produto adquirido com sucesso!');
    }
}