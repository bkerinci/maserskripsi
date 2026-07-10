<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::latest()->paginate(10);
        return view('admin.subscription_plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.subscription_plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'features' => 'nullable|string'
        ]);

        if ($validated['features']) {
            $validated['features'] = array_map('trim', explode("\n", $validated['features']));
        } else {
            $validated['features'] = [];
        }

        SubscriptionPlan::create($validated);

        return redirect()->route('admin.subscription-plans.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        return view('admin.subscription_plans.edit', compact('plan'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'features' => 'nullable|string'
        ]);

        if ($validated['features']) {
            $validated['features'] = array_map('trim', explode("\n", $validated['features']));
        } else {
            $validated['features'] = [];
        }

        $plan = SubscriptionPlan::findOrFail($id);
        $plan->update($validated);

        return redirect()->route('admin.subscription-plans.index')->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $plan->delete();
        return redirect()->route('admin.subscription-plans.index')->with('success', 'Paket berhasil dihapus.');
    }
}
