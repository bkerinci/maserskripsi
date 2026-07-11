<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

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
                    'discount_price' => null,
                    'promo' => null,
                    'duration_days' => 30,
                    'features' => ['Unlimited Project', 'Unlimited AI', 'Export DOCX', 'AI Citation']
                ]
            ]);
        }

        $user = auth()->user();
        $activePlan = null;
        if ($user->role === 'premium' && $user->active_plan_id) {
            $activePlan = SubscriptionPlan::find($user->active_plan_id);
        }

        $transactions = Transaction::where('user_id', $user->id)
            ->with('subscriptionPlan')
            ->latest()
            ->get();

        return view('user.subscription.index', compact('plans', 'activePlan', 'transactions'));
    }

    public function checkout(Request $request, $planId)
    {
        $user = auth()->user();
        $plan = SubscriptionPlan::findOrFail($planId);

        // Base price (gunakan harga diskon jika ada)
        $priceToPay = $plan->discount_price ?? $plan->price;
        $prorataDiscount = 0;

        // Hitung prorata jika ini adalah UPGRADE
        if ($user->role === 'premium' && $user->active_plan_id && $user->subscription_ends_at && Carbon::parse($user->subscription_ends_at)->isFuture()) {
            $currentPlan = SubscriptionPlan::find($user->active_plan_id);
            if ($currentPlan) {
                $currentPrice = $currentPlan->discount_price ?? $currentPlan->price;
                $targetPrice = $plan->discount_price ?? $plan->price;

                // Hanya upgrade (harga paket baru lebih tinggi dari paket saat ini)
                if ($targetPrice > $currentPrice) {
                    $remainingDays = Carbon::now()->diffInDays(Carbon::parse($user->subscription_ends_at), false);
                    if ($remainingDays > 0) {
                        $currentDuration = $currentPlan->duration_days ?: 30;
                        $valuePerDay = $currentPrice / $currentDuration;
                        $prorataDiscount = round($remainingDays * $valuePerDay);
                        $priceToPay = max(0, $targetPrice - $prorataDiscount);
                    }
                }
            }
        }

        // Jika harga akhir adalah 0 (penuh potongan prorata), aktivasi instan
        if ($priceToPay <= 0) {
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'amount' => 0,
                'status' => 'success',
                'payment_method' => 'prorata_discount',
            ]);

            $this->applySubscription($user, $plan);

            return redirect()->route('user.subscription.index')->with('success', 'Upgrade berhasil! Sisa masa aktif sebelumnya telah memotong harga paket baru Anda menjadi Rp 0.');
        }

        // Setup midtrans
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');

        // Buat transaksi di DB
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'amount' => $priceToPay,
            'status' => 'pending',
        ]);

        $params = array(
            'transaction_details' => array(
                'order_id' => 'TRX-' . $transaction->id . '-' . time(),
                'gross_amount' => (int) $priceToPay,
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
            $transaction->update(['status' => 'failed']);
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
        $transaction = Transaction::with('user')->find($transactionId);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transactionStatus = $notif->transaction_status;
        $type = $notif->payment_type;
        $fraudStatus = $notif->fraud_status;

        $transaction->update(['payment_method' => $type]);

        if ($transactionStatus == 'capture') {
            if ($type == 'credit_card') {
                if ($fraudStatus == 'challenge') {
                    $transaction->update(['status' => 'pending']);
                } else {
                    $transaction->update(['status' => 'success']);
                    $plan = SubscriptionPlan::find($transaction->subscription_plan_id);
                    if ($plan && $transaction->user) {
                        $this->applySubscription($transaction->user, $plan);
                    }
                }
            }
        } else if ($transactionStatus == 'settlement') {
            $transaction->update(['status' => 'success']);
            $plan = SubscriptionPlan::find($transaction->subscription_plan_id);
            if ($plan && $transaction->user) {
                $this->applySubscription($transaction->user, $plan);
            }
        } else if ($transactionStatus == 'pending') {
            $transaction->update(['status' => 'pending']);
        } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $transaction->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'Notification processed']);
    }

    public function success()
    {
        return redirect()->route('user.subscription.index')->with('success', 'Pembayaran berhasil! Akun Anda telah diupgrade.');
    }

    public function downloadInvoice(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('user.subscription.invoice', compact('transaction'));
        return $pdf->download('invoice-' . $transaction->id . '.pdf');
    }

    private function applySubscription($user, $plan)
    {
        $now = Carbon::now();
        $duration = $plan->duration_days ?: 30;

        if ($user->role !== 'premium') {
            // Langganan Baru
            $user->update([
                'role' => 'premium',
                'active_plan_id' => $plan->id,
                'next_plan_id' => null,
                'subscription_ends_at' => $now->addDays($duration),
            ]);
        } else {
            // Sudah Premium
            $currentPlan = SubscriptionPlan::find($user->active_plan_id);
            $currentPrice = $currentPlan ? ($currentPlan->discount_price ?? $currentPlan->price) : 0;
            $newPrice = $plan->discount_price ?? $plan->price;

            if ($newPrice > $currentPrice) {
                // UPGRADE: Berlaku instan, reset masa aktif baru
                $user->update([
                    'active_plan_id' => $plan->id,
                    'next_plan_id' => null,
                    'subscription_ends_at' => $now->addDays($duration),
                ]);
            } elseif ($plan->id == $user->active_plan_id) {
                // STACKING (Paket Sama): Perpanjang masa aktif yang ada
                $currentEndsAt = $user->subscription_ends_at ? Carbon::parse($user->subscription_ends_at) : $now;
                if ($currentEndsAt->isPast()) {
                    $currentEndsAt = $now;
                }
                $user->update([
                    'subscription_ends_at' => $currentEndsAt->addDays($duration),
                ]);
            } else {
                // DOWNGRADE (Paket Lebih Murah): Masuk antrean next_plan_id, perpanjang total masa aktif
                $currentEndsAt = $user->subscription_ends_at ? Carbon::parse($user->subscription_ends_at) : $now;
                if ($currentEndsAt->isPast()) {
                    $currentEndsAt = $now;
                }
                $user->update([
                    'next_plan_id' => $plan->id,
                    'subscription_ends_at' => $currentEndsAt->addDays($duration),
                ]);
            }
        }
    }
}
