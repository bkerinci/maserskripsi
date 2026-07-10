<x-user-layout>
    <x-slot name="header">
        Checkout Pembayaran
    </x-slot>

    <div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-900">Selesaikan Pembayaran Anda</h3>
            </div>
            <div class="p-6">
                <div class="mb-6 flex justify-between items-center border-b pb-4">
                    <div>
                        <p class="text-sm text-gray-500">Paket</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $plan->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Total Tagihan</p>
                        <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($plan->price, 0, ',', '.') }}</p>
                    </div>
                </div>

                <p class="text-sm text-gray-600 mb-6">
                    Silakan klik tombol di bawah ini untuk menampilkan jendela pembayaran yang aman. Anda dapat memilih metode pembayaran seperti Transfer Bank, E-Wallet (GoPay, OVO), Kartu Kredit, atau via minimarket.
                </p>

                <button id="pay-button" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Snap.js -->
    @if(config('services.midtrans.is_production'))
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    @endif

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    window.location.href = "{{ route('user.subscription.success') }}";
                },
                onPending: function(result){
                    alert("Menunggu pembayaran Anda!");
                    window.location.href = "{{ route('user.dashboard') }}";
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                },
                onClose: function(){
                    console.log('Jendela pembayaran ditutup sebelum menyelesaikan pembayaran.');
                }
            });
        };
    </script>
    @endpush
</x-user-layout>
