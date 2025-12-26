<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Dashboard Kasir
        </h2>
    </x-slot>

    {{-- Ringkasan KPI --}}
    <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-3">
        {{-- Total Transaksi --}}
        <div class="flex items-center p-4 bg-white rounded-lg shadow">
            <div class="p-3 bg-blue-100 rounded-full">
                <i class="text-blue-600 fas fa-receipt"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Transaksi Saya</h3>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $myTransactionsCount }}</p>
            </div>
        </div>

        {{-- Total Omzet --}}
        <div class="flex items-center p-4 bg-white rounded-lg shadow">
            <div class="p-3 bg-green-100 rounded-full">
                <i class="text-green-600 fas fa-dollar-sign"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Pendapatan Saya</h3>
                <p class="mt-1 text-2xl font-bold text-green-600">
                    Rp {{ number_format($myRevenue, 0, ',', '.') }}
                </p>
            </div>
        </div>

        {{-- Persentase Pembayaran Lunas --}}
        @php
            $paidCount = $myRecentTransactions->where('payment_status', 'paid')->count();
            $pendingCount = $myRecentTransactions->where('payment_status', 'pending')->count();
            $failedCount = $myRecentTransactions->where('payment_status', 'failed')->count();
        @endphp
        <div class="p-4 bg-white rounded-lg shadow">
            <h3 class="text-sm font-medium text-gray-500">Status Transaksi Terbaru</h3>
            <div class="mt-2 space-y-1">
                <div class="flex justify-between text-xs text-gray-600">
                    <span>Lunas</span>
                    <span>{{ $paidCount }}</span>
                </div>
                <div class="w-full h-2 bg-gray-200 rounded-full">
                    <div class="h-2 bg-green-500 rounded-full" style="width: {{ $myRecentTransactions->count() ? ($paidCount/$myRecentTransactions->count())*100 : 0 }}%"></div>
                </div>

                <div class="flex justify-between mt-1 text-xs text-gray-600">
                    <span>Menunggu</span>
                    <span>{{ $pendingCount }}</span>
                </div>
                <div class="w-full h-2 bg-gray-200 rounded-full">
                    <div class="h-2 bg-yellow-500 rounded-full" style="width: {{ $myRecentTransactions->count() ? ($pendingCount/$myRecentTransactions->count())*100 : 0 }}%"></div>
                </div>

                <div class="flex justify-between mt-1 text-xs text-gray-600">
                    <span>Gagal</span>
                    <span>{{ $failedCount }}</span>
                </div>
                <div class="w-full h-2 bg-gray-200 rounded-full">
                    <div class="h-2 bg-red-500 rounded-full" style="width: {{ $myRecentTransactions->count() ? ($failedCount/$myRecentTransactions->count())*100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Transaksi Terbaru --}}
    <div class="p-4 bg-white rounded-lg shadow">
        <h3 class="mb-4 text-lg font-semibold">Transaksi Terbaru Saya</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-xs border divide-y divide-gray-200 rounded-lg sm:text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 text-xs font-medium text-center text-gray-500 sm:px-4">ID</th>
                        <th class="px-3 py-2 text-xs font-medium text-center text-gray-500 sm:px-4">Tanggal</th>
                        <th class="px-3 py-2 text-xs font-medium text-center text-gray-500 sm:px-4">Total</th>
                        <th class="px-3 py-2 text-xs font-medium text-center text-gray-500 sm:px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($myRecentTransactions as $trx)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 text-center sm:px-4">#{{ $trx->id }}</td>
                            <td class="px-3 py-2 text-center sm:px-4">{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                            <td class="px-3 py-2 text-center sm:px-4">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                            <td class="px-3 py-2 text-center sm:px-4">
                                @if($trx->payment_status === 'paid')
                                    <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Lunas</span>
                                @elseif($trx->payment_status === 'pending')
                                    <span class="px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Menunggu</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">Gagal</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-2 text-center text-gray-500">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
