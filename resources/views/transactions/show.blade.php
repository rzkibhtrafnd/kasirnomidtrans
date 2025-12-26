<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Detail Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 space-y-6 bg-white shadow-sm sm:rounded-lg">

                {{-- Header Card --}}
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Transaksi #{{ $transaction->id }}
                    </h3>

                    <a href="{{ route('transactions.receipt.pdf', $transaction->id) }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition bg-green-600 rounded-lg hover:bg-green-700">
                        <i class="mr-2 fas fa-file-pdf"></i> Cetak Struk
                    </a>
                </div>

                {{-- Informasi Transaksi --}}
                <div class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                    <div>
                        <p class="mb-1 text-gray-500">Kasir</p>
                        <p class="font-semibold text-gray-800">{{ $transaction->user->name }}</p>
                    </div>

                    <div>
                        <p class="mb-1 text-gray-500">Tanggal</p>
                        <p class="text-gray-800">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <div>
                        <p class="mb-1 text-gray-500">Metode Pembayaran</p>
                        <p class="text-gray-800">{{ ucfirst($transaction->payment_method) }}</p>
                    </div>

                    <div>
                        <p class="mb-1 text-gray-500">Status Pembayaran</p>
                        <p class="text-gray-800">
                            @if($transaction->payment_status === 'paid')
                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Selesai</span>
                            @elseif($transaction->payment_status === 'pending')
                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Menunggu</span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">Gagal</span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Tabel Item --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border divide-y divide-gray-200 rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 font-semibold text-left text-gray-600">Produk</th>
                                <th class="px-4 py-2 font-semibold text-center text-gray-600">Qty</th>
                                <th class="px-4 py-2 font-semibold text-right text-gray-600">Subtotal</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @foreach ($transaction->items as $item)
                                <tr class="transition hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $item->product->name }}</td>
                                    <td class="px-4 py-2 text-center">{{ $item->qty }}</td>
                                    <td class="px-4 py-2 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Total --}}
                <div class="flex justify-end pt-4 border-t">
                    <p class="text-lg font-bold text-gray-800">Total: Rp {{ number_format($transaction->total, 0, ',', '.') }}</p>
                </div>

                {{-- Tombol Kembali --}}
                <div class="flex justify-end pt-2">
                    <a href="{{ route('transactions.index') }}" class="px-4 py-2 text-sm text-gray-600 transition bg-gray-200 rounded-lg hover:bg-gray-300">
                        Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
