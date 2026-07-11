<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'premium') {
            // Cek apakah masa aktif langganan sudah habis
            if ($user->subscription_ends_at && $user->subscription_ends_at->isPast()) {
                // Jika ada paket downgrade/next plan yang dijadwalkan
                if ($user->next_plan_id) {
                    $nextPlan = \App\Models\SubscriptionPlan::find($user->next_plan_id);
                    if ($nextPlan) {
                        $user->update([
                            'active_plan_id' => $nextPlan->id,
                            'next_plan_id' => null,
                            'subscription_ends_at' => now()->addDays($nextPlan->duration_days ?: 30),
                        ]);
                    } else {
                        // Jika plan tidak ditemukan, turunkan ke user biasa
                        $user->update([
                            'role' => 'user',
                            'active_plan_id' => null,
                            'next_plan_id' => null,
                        ]);
                    }
                } else {
                    // Tidak ada paket berikutnya, kembalikan ke user biasa
                    $user->update([
                        'role' => 'user',
                        'active_plan_id' => null,
                        'next_plan_id' => null,
                    ]);
                }
            }
        }

        return $next($request);
    }
}
