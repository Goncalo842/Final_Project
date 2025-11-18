<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}