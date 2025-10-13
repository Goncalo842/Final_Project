<?php

namespace App\Http\Controllers;

use App\Models\Pagamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagamentoController extends Controller
{
    public function pay()
    {
        $meses = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];

        $user = Auth::user();

        $pagamentos = Pagamento::where('user_id', $user->id)->get();
        $mesesPagos = $pagamentos->where('pago', true)->pluck('mes')->toArray();

        return view('settings.students.pay', compact('meses', 'mesesPagos'));
    }

    public function complete(Request $request)
    {
        $request->validate([
            'mes' => 'required|string',
            'numero_cartao' => 'required|string',
            'validade' => 'required|string',
            'cvv' => 'required|string',
        ]);

        $user = Auth::user();

        $pagamento = Pagamento::firstOrNew([
            'user_id' => $user->id,
            'mes' => $request->mes
        ]);

        $pagamento->pago = true;
        $pagamento->save();

        return back()->with('sucesso', "Pagamento do mês de {$request->mes} realizado com sucesso!");
    }
}
