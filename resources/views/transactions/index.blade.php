<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Riwayat Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:px-6 lg:px-8">
        <div class="p-6 overflow-hidden bg-white shadow-md sm:rounded-lg">

            {{-- Header dan Tombol --}}
            <div class="flex justify-between mb-6">
                <h3 class="flex items-center text-lg font-semibold text-gray-800">
                    </i> Daftar Transaksi
                </h3>

                <a href="{{ route('transactions.create') }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition duration-200 bg-blue-600 rounded-lg shadow hover:bg-blue-700">
                    <i class="mr-2 fas fa-plus"></i> Transaksi Baru
                </a>
            </div>

            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="p-3 mb-4 text-green-700 bg-green-100 border border-green-300 rounded-md">
                    <i class="mr-2 fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-3 mb-4 text-red-700 bg-red-100 border border-red-300 rounded-md">
                    <i class="mr-2 fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="GET" class="grid gap-2 mb-4 sm:flex sm:items-end">
                <select name="month" class="px-2 py-1 border rounded">
                    <option value="">Bulan</option>
                    @for($m=1;$m<=12;$m++)
                        <option value="{{ $m }}" @selected(request('month') == $m)>{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                    @endfor
                </select>

                <select name="year" class="px-2 py-1 border rounded">
                    <option value="">Tahun</option>
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" @selected(request('year') == $y)>{{ $y }}</option>
                    @endfor
                </select>

                <button type="submit" class="px-4 py-1 text-white bg-blue-600 rounded">Filter</button>

                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('transactions.report.pdf', request()->query()) }}" 
                    class="px-4 py-1 text-center text-white bg-red-600 rounded"><i class="mr-1 fas fa-file-pdf"></i>Unduh Laporan</a>
                @endif
            </form>

            {{-- Tabel Transaksi --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border divide-y divide-gray-200 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">ID</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Tanggal</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Total</th>
                            <th class="px-4 py-2 font-semibold text-center text-gray-600">Pembayaran</th>
                            <th class="px-4 py-2 font-semibold text-center text-gray-600">Status</th>
                            <th class="px-4 py-2 font-semibold text-right text-gray-600">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @forelse ($transactions as $transaction)
                            <tr class="transition hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    #{{ $transaction->id }}
                                </td>

                                <td class="px-4 py-2">
                                    {{ $transaction->created_at->format('d M Y, H:i') }}
                                </td>

                                <td class="px-4 py-2 font-semibold">
                                    Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-2 text-center">
                                    @if($transaction->payment_method === 'cash')
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">
                                            Cash
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-purple-800 bg-purple-100 rounded-full">
                                            Midtrans
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-2 text-center">
                                    @if($transaction->payment_status === 'paid')
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                                            Selesai
                                        </span>
                                    @elseif($transaction->payment_status === 'pending')
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">
                                            Menunggu
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">
                                            Gagal
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-2 space-x-2 text-right">
                                    {{-- Detail --}}
                                    <a href="{{ route('transactions.show', $transaction->id) }}"
                                       class="inline-flex items-center px-3 py-1 text-sm font-medium text-white transition bg-indigo-600 rounded-md hover:bg-indigo-700">
                                        <i class="mr-1 fas fa-eye"></i> Detail
                                    </a>

                                    {{-- Download PDF --}}
                                    <a href="{{ route('transactions.receipt.pdf', $transaction->id) }}"
                                       class="inline-flex items-center px-3 py-1 text-sm font-medium text-white transition bg-green-600 rounded-md hover:bg-green-700">
                                        <i class="mr-1 fas fa-file-pdf"></i> Struk
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                    <i class="mr-2 fas fa-inbox"></i>
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
    </div>
</x-app-layout>
