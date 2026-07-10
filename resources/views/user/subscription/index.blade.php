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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
            @foreach($plans as $index => $plan)
                @if($index == 0)
                    <!-- Basic -->
                    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm flex flex-col relative">
                        @if(auth()->user()->role === 'premium')
                        <div class="absolute top-0 right-0 -mr-2 -mt-2 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase">Aktif</div>
                        @endif
                        <h3 class="text-xl font-bold text-slate-900 font-heading">{{ $plan->name }}</h3>
                        <p class="text-slate-500 text-sm mt-2">Mulai tugas akhir.</p>
                        <div class="my-6">
                            @if($plan->price == 0)
                                <span class="text-4xl font-extrabold text-slate-900">Custom</span>
                            @else
                                <span class="text-4xl font-extrabold text-slate-900">Rp{{ number_format($plan->price/1000, 0, ',', '.') }}k</span>
                            @endif
                        </div>
                        <ul class="space-y-4 mb-8 flex-1">
                            @foreach($plan->features ?? [] as $feature)
                            <li class="flex items-center text-sm text-slate-600"><svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> {{ $feature }}</li>
                            @endforeach
                        </ul>
                        @if(auth()->user()->role === 'premium')
                        <button disabled class="block w-full text-center py-3 px-4 bg-green-600 text-white font-semibold rounded-xl cursor-not-allowed">Sudah Berlangganan</button>
                        @else
                        <form action="{{ route('user.subscription.checkout', $plan->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan_name" value="{{ $plan->name }}">
                            <input type="hidden" name="plan_price" value="{{ $plan->price }}">
                            <button type="submit" class="block w-full text-center py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold rounded-xl transition-colors">Pilih Paket</button>
                        </form>
                        @endif
                    </div>
                @elseif($index == 1)
                    <!-- Premium Bulanan -->
                    <div class="bg-blue-900 rounded-3xl p-8 border border-blue-800 shadow-xl shadow-blue-900/20 relative transform lg:-translate-y-4 flex flex-col">
                        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4">
                            <span class="bg-gradient-to-r from-blue-400 to-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Populer</span>
                        </div>
                        @if(auth()->user()->role === 'premium')
                        <div class="absolute top-0 left-0 -ml-2 -mt-2 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase z-10">Aktif</div>
                        @endif
                        <h3 class="text-xl font-bold text-white font-heading">{{ $plan->name }}</h3>
                        <p class="text-blue-200 text-sm mt-2">Untuk penelitian rutin.</p>
                        <div class="my-6">
                            @if($plan->price == 0)
                                <span class="text-4xl font-extrabold text-white">Custom</span>
                            @else
                                <span class="text-4xl font-extrabold text-white">Rp{{ number_format($plan->price/1000, 0, ',', '.') }}k</span>
                            @endif
                        </div>
                        <ul class="space-y-4 mb-8 flex-1">
                            @foreach($plan->features ?? [] as $feature)
                            <li class="flex items-center text-sm text-blue-50"><svg class="w-5 h-5 text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> {{ $feature }}</li>
                            @endforeach
                        </ul>
                        @if(auth()->user()->role === 'premium')
                        <button disabled class="block w-full text-center py-3 px-4 bg-green-600 text-white font-semibold rounded-xl cursor-not-allowed">Sudah Berlangganan</button>
                        @else
                        <form action="{{ route('user.subscription.checkout', $plan->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan_name" value="{{ $plan->name }}">
                            <input type="hidden" name="plan_price" value="{{ $plan->price }}">
                            <button type="submit" class="block w-full text-center py-3 px-4 bg-white hover:bg-blue-50 text-blue-900 font-semibold rounded-xl transition-colors shadow-sm">Pilih Paket</button>
                        </form>
                        @endif
                    </div>
                @elseif($index == 2)
                    <!-- Premium Tahunan -->
                    <div class="bg-gradient-to-b from-indigo-900 to-blue-900 rounded-3xl p-8 border border-indigo-800 shadow-xl shadow-indigo-900/20 relative transform lg:-translate-y-4 flex flex-col">
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
                            <span class="bg-gradient-to-r from-amber-400 to-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide shadow-md">Best Value</span>
                        </div>
                        @if(auth()->user()->role === 'premium')
                        <div class="absolute top-0 right-0 -mr-2 -mt-2 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase z-10">Aktif</div>
                        @endif
                        <h3 class="text-xl font-bold text-white font-heading">{{ $plan->name }}</h3>
                        <p class="text-indigo-200 text-sm mt-2">Hemat lebih banyak.</p>
                        <div class="my-6">
                            @if($plan->price == 0)
                                <span class="text-4xl font-extrabold text-white">Custom</span>
                            @else
                                <span class="text-4xl font-extrabold text-white">Rp{{ number_format($plan->price/1000, 0, ',', '.') }}k</span>
                            @endif
                        </div>
                        <ul class="space-y-4 mb-8 flex-1">
                            @foreach($plan->features ?? [] as $feature)
                            <li class="flex items-center text-sm text-indigo-50"><svg class="w-5 h-5 text-amber-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> {{ $feature }}</li>
                            @endforeach
                        </ul>
                        @if(auth()->user()->role === 'premium')
                        <button disabled class="block w-full text-center py-3 px-4 bg-green-600 text-white font-semibold rounded-xl cursor-not-allowed">Sudah Berlangganan</button>
                        @else
                        <form action="{{ route('user.subscription.checkout', $plan->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan_name" value="{{ $plan->name }}">
                            <input type="hidden" name="plan_price" value="{{ $plan->price }}">
                            <button type="submit" class="block w-full text-center py-3 px-4 bg-gradient-to-r from-amber-400 to-orange-500 hover:from-amber-500 hover:to-orange-600 text-white font-bold rounded-xl transition-colors shadow-sm">Pilih Tahunan</button>
                        </form>
                        @endif
                    </div>
                @else
                    <!-- Custom -->
                    <div class="bg-slate-900 rounded-3xl p-8 border border-slate-800 shadow-xl shadow-slate-900/20 flex flex-col relative">
                        @if(auth()->user()->role === 'premium')
                        <div class="absolute top-0 right-0 -mr-2 -mt-2 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase z-10">Aktif</div>
                        @endif
                        <h3 class="text-xl font-bold text-white font-heading">{{ $plan->name }}</h3>
                        <p class="text-slate-400 text-sm mt-2">Untuk institusi pendidikan.</p>
                        <div class="my-6">
                            @if($plan->price == 0)
                                <span class="text-4xl font-extrabold text-white">Custom</span>
                            @else
                                <span class="text-4xl font-extrabold text-white">Rp{{ number_format($plan->price/1000, 0, ',', '.') }}k</span>
                            @endif
                        </div>
                        <ul class="space-y-4 mb-8 flex-1">
                            @foreach($plan->features ?? [] as $feature)
                            <li class="flex items-center text-sm text-slate-300"><svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> {{ $feature }}</li>
                            @endforeach
                        </ul>
                        <a href="#" onclick="alert('Silakan hubungi kami via email.'); return false;" class="block w-full text-center py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors">Hubungi Kami</a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</x-user-layout>
