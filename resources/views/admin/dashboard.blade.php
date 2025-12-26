<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Dashboard Admin
        </h2>
    </x-slot>

    {{-- Ringkasan Statistik --}}
    <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="flex items-center p-4 bg-white rounded-lg shadow">

            <div class="p-3 bg-blue-100 rounded-full">
                <i class="text-blue-600 fas fa-tags"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Kategori</h3>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $categoriesCount }}</p>
            </div>
        </div>

        <div class="flex items-center p-4 bg-white rounded-lg shadow">

            <div class="p-3 bg-purple-100 rounded-full">
                <i class="text-purple-600 fas fa-box-open"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Produk</h3>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $productsCount }}</p>
            </div>
        </div>

        <div class="flex items-center p-4 bg-white rounded-lg shadow">

            <div class="p-3 bg-yellow-100 rounded-full">
                <i class="text-yellow-600 fas fa-receipt"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Transaksi</h3>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $transactionsCount }}</p>
            </div>
        </div>

        <div class="flex items-center p-4 bg-white rounded-lg shadow">

            <div class="p-3 bg-green-100 rounded-full">
                <i class="text-green-600 fas fa-dollar-sign"></i>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-medium text-gray-500">Total Pendapatan</h3>
                <p class="mt-1 text-2xl font-bold text-green-600">
                    Rp {{ number_format($totalRevenue,0,',','.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- Top Produk Terlaris --}}
    <div class="p-4 mb-6 bg-white rounded-lg shadow">
        <h3 class="mb-4 text-lg font-semibold">Top 5 Produk Terlaris</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-xs border divide-y divide-gray-200 rounded-lg sm:text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-2 py-2 font-semibold text-left text-gray-600 sm:px-4">Produk</th>
                        <th class="px-2 py-2 font-semibold text-left text-gray-600 sm:px-4">Terjual</th>
                        <th class="px-2 py-2 font-semibold text-left text-gray-600 sm:px-4">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($topProducts as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 py-2 sm:px-4">{{ $product->name }}</td>
                            <td class="px-2 py-2 sm:px-4">{{ $product->total_sold }}</td>
                            <td class="px-2 py-2 sm:px-4">Rp {{ number_format($product->total_revenue,0,',','.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-3 py-2 text-center text-gray-500">Belum ada data produk</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Transaksi Terbaru --}}
    <div class="p-4 bg-white rounded-lg shadow">
        <h3 class="mb-4 text-lg font-semibold">Transaksi Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-xs border divide-y divide-gray-200 rounded-lg sm:text-sm">

                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-2 py-2 font-semibold text-left text-gray-600 sm:px-4">ID</th>
                        <th class="px-2 py-2 font-semibold text-left text-gray-600 sm:px-4">Tanggal</th>
                        <th class="px-2 py-2 font-semibold text-left text-gray-600 sm:px-4">Kasir</th>
                        <th class="px-2 py-2 font-semibold text-left text-gray-600 sm:px-4">Total Harga</th>
                        <th class="px-2 py-2 font-semibold text-left text-gray-600 sm:px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentTransactions as $trx)
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 py-2 sm:px-4">#{{ $trx->id }}</td>
                            <td class="px-2 py-2 sm:px-4">{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                            <td class="px-2 py-2 sm:px-4">{{ $trx->user->name }}</td>
                            <td class="px-2 py-2 sm:px-4">Rp {{ number_format($trx->total,0,',','.') }}</td>
                            <td class="px-2 py-2 sm:px-4">
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
                            <td colspan="5" class="px-3 py-2 text-center text-gray-500">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
