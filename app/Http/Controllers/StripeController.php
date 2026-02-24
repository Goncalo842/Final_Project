<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\User;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:5',
            'email' => 'required|email',
        ]);

        $user = auth()->user();
        $amount = (float) $request->amount;

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentIntent = PaymentIntent::create([
                'amount' => (int) ($amount * 100),
                'currency' => 'eur',
                'description' => 'Recarga de Saldo - €' . number_format($amount, 2, ',', '.'),
                'receipt_email' => $request->email,
                'metadata' => [
                    'user_id' => $user->id,
                    'amount' => $amount,
                ],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function success(Request $request)
    {
        $paymentIntentId = $request->query('payment_intent');

        if (!$paymentIntentId) {
            return redirect()->route('saldo.recarregar')
                ->with('error', 'Pagamento inválido.');
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            if ($paymentIntent->status !== 'succeeded') {
                return redirect()->route('saldo.recarregar')
                    ->with('error', 'Pagamento não foi concluído.');
            }

            $userId = $paymentIntent->metadata->user_id;
            $amount = (float) $paymentIntent->metadata->amount;

            $user = User::findOrFail($userId);
            $user->saldo += $amount;
            $user->save();

            return redirect()->route('saldo.recarregar')
                ->with('success', 'Recarga de €' . number_format($amount, 2, ',', '.') . ' realizada com sucesso! Novo saldo: €' . number_format($user->saldo, 2, ',', '.'));
        } catch (\Exception $e) {
            return redirect()->route('saldo.recarregar')
                ->with('error', 'Erro ao processar pagamento: ' . $e->getMessage());
        }
    }

    public function failure()
    {
        return redirect()->route('saldo.recarregar')
            ->with('error', 'Pagamento cancelado. Nenhuma cobrança foi feita.');
    }
}
