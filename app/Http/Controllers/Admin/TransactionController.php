<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'subscriptionPlan'])->latest()->paginate(10);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,success,failed,refunded',
        ]);

        $transaction = Transaction::findOrFail($id);
        $newStatus = $validated['status'];

        $transaction->update(['status' => $newStatus]);

        $user = $transaction->user;
        if ($user) {
            if ($newStatus === 'success') {
                $plan = $transaction->subscriptionPlan;
                if ($plan) {
                    $this->applySubscription($user, $plan);
                }
            } elseif ($newStatus === 'refunded' || $newStatus === 'failed') {
                // Downgrade ke user biasa jika refund atau gagal
                $user->update([
                    'role' => 'user',
                    'active_plan_id' => null,
                    'next_plan_id' => null,
                    'subscription_ends_at' => null,
                ]);
            }
        }

        return redirect()->route('admin.transactions.index')->with('success', 'Status transaksi #' . $id . ' berhasil diperbarui menjadi ' . ucfirst($newStatus));
    }

    public function destroy(string $id) {}

    private function applySubscription($user, $plan)
    {
        $now = \Carbon\Carbon::now();
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
            $currentPlan = \App\Models\SubscriptionPlan::find($user->active_plan_id);
            $currentPrice = $currentPlan ? ($currentPlan->discount_price ?? $currentPlan->price) : 0;
            $newPrice = $plan->discount_price ?? $plan->price;

            if ($newPrice > $currentPrice) {
                // UPGRADE
                $user->update([
                    'active_plan_id' => $plan->id,
                    'next_plan_id' => null,
                    'subscription_ends_at' => $now->addDays($duration),
                ]);
            } elseif ($plan->id == $user->active_plan_id) {
                // STACKING
                $currentEndsAt = $user->subscription_ends_at ? \Carbon\Carbon::parse($user->subscription_ends_at) : $now;
                if ($currentEndsAt->isPast()) {
                    $currentEndsAt = $now;
                }
                $user->update([
                    'subscription_ends_at' => $currentEndsAt->addDays($duration),
                ]);
            } else {
                // DOWNGRADE
                $currentEndsAt = $user->subscription_ends_at ? \Carbon\Carbon::parse($user->subscription_ends_at) : $now;
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
