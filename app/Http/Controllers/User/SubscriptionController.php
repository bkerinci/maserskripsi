<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::all();
        // Fallback jika DB kosong
        if ($plans->isEmpty()) {
            $plans = collect([
                (object)[
                    'id' => 1,
                    'name' => 'Pro',
                    'price' => 49000,
                    'features' => ['Unlimited Project', 'Unlimited AI', 'Export DOCX', 'AI Citation']
                ]
            ]);
        }

        return view('user.subscription.index', compact('plans'));
    }

    public function checkout(Request $request, $planId)
    {
        // Setup midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');

        $user = auth()->user();
        
        // Cek fallback
        $plan = SubscriptionPlan::find($planId);
        if (!$plan) {
            $plan = (object)[
                'id' => $planId,
                'name' => $request->input('plan_name', 'Premium Plan'),
                'price' => $request->input('plan_price', 99000)
            ];
        }

        // Buat transaksi di DB
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $planId == 1 ? null : $planId,
            'amount' => $plan->price,
            'status' => 'pending',
        ]);

        $params = array(
            'transaction_details' => array(
                'order_id' => 'TRX-' . $transaction->id . '-' . time(),
                'gross_amount' => $plan->price,
            ),
            'customer_details' => array(
                'first_name' => $user->name,
                'email' => $user->email,
            ),
        );

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return view('user.subscription.checkout', compact('snapToken', 'plan', 'transaction'));
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        
        try {
            $notif = new \Midtrans\Notification();
        } catch (\Exception $e) {
            Log::error('Midtrans Callback Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

        $transactionId = explode('-', $notif->order_id)[1];
        $transaction = Transaction::find($transactionId);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transactionStatus = $notif->transaction_status;
        $type = $notif->payment_type;
        $fraudStatus = $notif->fraud_status;

        if ($transactionStatus == 'capture') {
            if ($type == 'credit_card') {
                if ($fraudStatus == 'challenge') {
                    $transaction->update(['status' => 'pending']);
                } else {
                    $transaction->update(['status' => 'success']);
                    $this->upgradeUser($transaction->user_id);
                }
            }
        } else if ($transactionStatus == 'settlement') {
            $transaction->update(['status' => 'success']);
            $this->upgradeUser($transaction->user_id);
        } else if ($transactionStatus == 'pending') {
            $transaction->update(['status' => 'pending']);
        } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $transaction->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'Notification processed']);
    }

    public function success()
    {
        return redirect()->route('user.dashboard')->with('success', 'Pembayaran berhasil! Akun Anda telah diupgrade ke Premium.');
    }

    private function upgradeUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->update(['role' => 'premium']);
        }
    }
}
