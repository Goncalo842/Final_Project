<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Stock;

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

    public function adquirir(Request $request, $id)
    {
        $produto = Stock::findOrFail($id);
        $user = Auth::user();
        $quantidade = $request->input('quantity', 1);
        $totalPrice = $produto->preco * $quantidade;

        if ($user->saldo < $totalPrice) {
            return redirect()->back()->with('error', 'Não tem saldo suficiente para esta compra. Necessita de ' . number_format($totalPrice, 2) . '€');
        }

        $user->saldo -= $totalPrice;
        $user->save();

        return redirect()->back()->with('success', 'Compra efetuada com sucesso! Total: ' . number_format($totalPrice, 2) . '€');
    }
}
