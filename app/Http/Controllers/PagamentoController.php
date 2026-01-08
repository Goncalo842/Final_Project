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

    public function downloadReceipt($mes)
    {
        $user = Auth::user();

        $pagamento = Pagamento::where('user_id', $user->id)->where('mes', $mes)->first();

        if (!$pagamento || !$pagamento->pago) {
            return back()->with('sucesso', 'Comprovativo não disponível para esse mês.');
        }

        $data = [
            'user' => $user,
            'pagamento' => $pagamento,
            'mes' => $mes,
        ];

        $html = view('payments.receipt', $data)->render();

        if (class_exists(\Dompdf\Dompdf::class)) {
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"comprovativo_{$mes}.pdf\"",
            ]);
        }

        return back()->with('sucesso', 'Para gerar PDFs instale o Dompdf: execute `composer require dompdf/dompdf` ou `composer require barryvdh/laravel-dompdf`.');
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
