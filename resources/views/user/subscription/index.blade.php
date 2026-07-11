<x-user-layout>
    <x-slot name="header">
        Upgrade ke Premium
    </x-slot>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="font-heading text-3xl font-extrabold text-slate-900">Pilih Paket yang Sesuai</h2>
            <p class="mt-4 text-lg text-slate-600">Didesain khusus untuk memenuhi kebutuhan mahasiswa hingga tingkat institusi.</p>
        </div>

        @if(session('success'))
            <div class="max-w-3xl mx-auto mb-8 bg-green-50 border-l-4 border-green-500 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-3xl mx-auto mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Informasi Langganan Aktif -->
        @if(auth()->user()->role === 'premium')
            <div class="max-w-4xl mx-auto mb-12 bg-gradient-to-r from-blue-700 to-indigo-800 text-white rounded-3xl p-8 shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 translate-x-10 -translate-y-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <span class="px-3 py-1 bg-white/20 text-xs font-semibold rounded-full uppercase tracking-wider">Langganan Aktif</span>
                        <h3 class="text-2xl font-bold mt-2 font-heading">
                            Paket {{ $activePlan->name ?? 'Premium' }}
                        </h3>
                        <p class="text-blue-100 text-sm mt-1">
                            Status: <span class="font-semibold text-green-400">Aktif</span>
                        </p>
                        @if(auth()->user()->subscription_ends_at)
                            <p class="text-blue-200 text-xs mt-4">
                                Berlaku sampai: <span class="font-semibold text-white">{{ \Carbon\Carbon::parse(auth()->user()->subscription_ends_at)->format('d F Y (H:i)') }}</span>
                            </p>
                        @endif
                        @if(auth()->user()->next_plan_id)
                            @php
                                $nextPlan = \App\Models\SubscriptionPlan::find(auth()->user()->next_plan_id);
                            @endphp
                            @if($nextPlan)
                                <p class="text-amber-300 text-xs mt-1 font-medium">
                                    Downgrade Terjadwal: Paket {{ $nextPlan->name }} (Akan aktif otomatis setelah paket saat ini berakhir)
                                </p>
                            @endif
                        @endif
                    </div>
                    <div class="shrink-0">
                        <span class="inline-block text-5xl">🎖️</span>
                    </div>
                </div>
            </div>
        @endif

        @php
            $userLimits = auth()->user()->getPlanLimits();
            $usedPrompts = auth()->user()->getUsedPromptsCount();
            $projectCount = auth()->user()->projects()->count();
            
            $promptLimitText = $userLimits['prompts'] >= 999999 ? 'Tak Terbatas' : $userLimits['prompts'] . ' / Bulan';
            $projectLimitText = $userLimits['projects'] >= 999999 ? 'Tak Terbatas' : $userLimits['projects'];
        @endphp

        <!-- Detail Penggunaan Kuota -->
        <div class="max-w-4xl mx-auto mb-12 bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 mb-6 font-heading flex items-center gap-2">
                <span>📊</span> Statistik Penggunaan Kuota Anda
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Paket Aktif -->
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Paket Saat Ini</p>
                    <p class="text-2xl font-bold text-slate-800 mt-2 font-heading">{{ $userLimits['name'] }}</p>
                    @if(auth()->user()->role === 'premium' && auth()->user()->subscription_ends_at)
                        <p class="text-xs text-slate-500 mt-2">
                            Berakhir: {{ \Carbon\Carbon::parse(auth()->user()->subscription_ends_at)->format('d M Y') }}
                        </p>
                    @else
                        <p class="text-xs text-slate-500 mt-2">Silakan pilih paket untuk menikmati fitur penuh.</p>
                    @endif
                </div>

                <!-- Kuota Project -->
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Jumlah Project Aktif</p>
                    <p class="text-2xl font-bold text-slate-800 mt-2 font-heading">
                        {{ $projectCount }} <span class="text-sm font-normal text-slate-400">/ {{ $projectLimitText }}</span>
                    </p>
                    <!-- Progress Bar -->
                    <div class="w-full bg-slate-200 rounded-full h-1.5 mt-3 overflow-hidden">
                        <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $userLimits['projects'] >= 999999 ? 0 : min(100, ($projectCount / $userLimits['projects']) * 100) }}%"></div>
                    </div>
                </div>

                <!-- Kuota AI Prompts -->
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">AI Prompt Terpakai</p>
                    <p class="text-2xl font-bold text-slate-800 mt-2 font-heading">
                        {{ $usedPrompts }} <span class="text-sm font-normal text-slate-400">/ {{ $promptLimitText }}</span>
                    </p>
                    <!-- Progress Bar -->
                    <div class="w-full bg-slate-200 rounded-full h-1.5 mt-3 overflow-hidden">
                        <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ $userLimits['prompts'] >= 999999 ? 0 : min(100, ($usedPrompts / $userLimits['prompts']) * 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid Paket -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-7xl mx-auto mb-16">
            @foreach($plans as $index => $plan)
                @php
                    $isCurrentActive = auth()->user()->role === 'premium' && auth()->user()->active_plan_id == $plan->id;
                    $isDowngradeScheduled = auth()->user()->role === 'premium' && auth()->user()->next_plan_id == $plan->id;
                    $hasDiscount = isset($plan->discount_price) && $plan->discount_price > 0;
                    $displayPrice = $hasDiscount ? $plan->discount_price : $plan->price;
                @endphp

                <!-- Card Layout based on Theme/Index -->
                <div class="rounded-3xl p-8 border flex flex-col relative shadow-sm transition-transform hover:-translate-y-1 {{ $index == 1 ? 'bg-blue-900 border-blue-800 text-white shadow-xl shadow-blue-900/20' : ($index == 2 ? 'bg-gradient-to-b from-indigo-900 to-blue-900 border-indigo-800 text-white shadow-xl' : 'bg-white border-slate-200') }}">
                    
                    @if($index == 1)
                        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4">
                            <span class="bg-gradient-to-r from-blue-400 to-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Populer</span>
                        </div>
                    @elseif($index == 2)
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
                            <span class="bg-gradient-to-r from-amber-400 to-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide shadow-md">Best Value</span>
                        </div>
                    @endif

                    @if($isCurrentActive)
                        <div class="absolute top-0 right-0 -mr-2 -mt-2 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase z-10">Aktif</div>
                    @elseif($isDowngradeScheduled)
                        <div class="absolute top-0 right-0 -mr-2 -mt-2 bg-amber-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase z-10">Antre</div>
                    @endif

                    <h3 class="text-xl font-bold font-heading {{ $index == 1 || $index == 2 ? 'text-white' : 'text-slate-900' }}">{{ $plan->name }}</h3>
                    <p class="text-xs mt-2 {{ $index == 1 || $index == 2 ? 'text-blue-200' : 'text-slate-500' }}">Durasi: {{ $plan->duration_days ?? 30 }} Hari</p>
                    
                    @if($plan->promo)
                        <div class="mt-2">
                            <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded {{ $index == 1 || $index == 2 ? 'bg-blue-800 text-blue-100 border border-blue-700' : 'bg-amber-100 text-amber-800' }}">
                                🏷️ {{ $plan->promo }}
                            </span>
                        </div>
                    @endif

                    <div class="my-6">
                        @if($plan->price == 0)
                            <span class="text-4xl font-extrabold {{ $index == 1 || $index == 2 ? 'text-white' : 'text-slate-900' }}">Custom</span>
                        @else
                            @if($hasDiscount)
                                <div class="flex flex-col">
                                    <span class="text-xs line-through {{ $index == 1 || $index == 2 ? 'text-blue-300' : 'text-slate-400' }}">
                                        Rp{{ number_format($plan->price, 0, ',', '.') }}
                                    </span>
                                    <span class="text-4xl font-extrabold {{ $index == 1 || $index == 2 ? 'text-white' : 'text-slate-900' }}">
                                        Rp{{ number_format($displayPrice/1000, 0, ',', '.') }}k
                                    </span>
                                </div>
                            @else
                                <span class="text-4xl font-extrabold {{ $index == 1 || $index == 2 ? 'text-white' : 'text-slate-900' }}">
                                    Rp{{ number_format($plan->price/1000, 0, ',', '.') }}k
                                </span>
                            @endif
                        @endif
                    </div>

                    <ul class="space-y-4 mb-8 flex-1">
                        @foreach($plan->features ?? [] as $feature)
                        <li class="flex items-center text-sm {{ $index == 1 || $index == 2 ? 'text-blue-50' : 'text-slate-600' }}">
                            <svg class="w-5 h-5 mr-3 {{ $index == 2 ? 'text-amber-400' : ($index == 1 ? 'text-blue-400' : 'text-blue-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg> 
                            {{ $feature }}
                        </li>
                        @endforeach
                    </ul>

                    @if($plan->price == 0)
                        <a href="#" onclick="alert('Silakan hubungi kami via email.'); return false;" class="block w-full text-center py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors">Hubungi Kami</a>
                    @else
                        @if($isCurrentActive)
                            <form action="{{ route('user.subscription.checkout', $plan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="block w-full text-center py-3 px-4 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-xl border border-white/20 transition-colors">Perpanjang (Stacking)</button>
                            </form>
                        @elseif($isDowngradeScheduled)
                            <button disabled class="block w-full text-center py-3 px-4 bg-amber-600 text-white font-semibold rounded-xl cursor-not-allowed">Sudah Dipesan</button>
                        @else
                            <form action="{{ route('user.subscription.checkout', $plan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="block w-full text-center py-3 px-4 font-semibold rounded-xl transition-colors shadow-sm {{ $index == 1 ? 'bg-white hover:bg-blue-50 text-blue-900' : ($index == 2 ? 'bg-gradient-to-r from-amber-400 to-orange-500 hover:from-amber-500 hover:to-orange-600 text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-800') }}">
                                    @if(auth()->user()->role === 'premium')
                                        @php
                                            $currentPlanObj = \App\Models\SubscriptionPlan::find(auth()->user()->active_plan_id);
                                            $isTargetMoreExpensive = $currentPlanObj ? ($displayPrice > ($currentPlanObj->discount_price ?? $currentPlanObj->price)) : false;
                                        @endphp
                                        @if($isTargetMoreExpensive)
                                            Upgrade (Prorata)
                                        @else
                                            Pilih Paket (Downgrade)
                                        @endif
                                    @else
                                        Pilih Paket
                                    @endif
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Riwayat Pembayaran (Payment History) -->
        <div class="max-w-6xl mx-auto bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
            <h3 class="font-heading text-xl font-bold text-slate-900 mb-6">Riwayat Pembayaran</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Transaksi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paket</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Pembayaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($transactions as $trx)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $trx->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $trx->subscriptionPlan->name ?? 'Premium Plan' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $trx->payment_method ? strtoupper($trx->payment_method) : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 py-0.5 inline-flex text-[10px] leading-5 font-semibold rounded-full {{ $trx->status === 'success' ? 'bg-green-100 text-green-800' : ($trx->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($trx->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $trx->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($trx->status === 'success')
                                    <a href="{{ route('user.subscription.invoice.download', $trx) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold flex items-center gap-1">
                                        📥 Unduh
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada riwayat transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-user-layout>
