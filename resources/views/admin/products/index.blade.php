<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Kelola Produk') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:px-6 lg:px-8">
        <div class="p-6 overflow-hidden bg-white shadow-md sm:rounded-lg">

            {{-- Header dan tombol tambah --}}
            <div class="flex justify-between mb-6">
                <h3 class="flex items-center text-lg font-semibold text-gray-800">
                    Daftar Produk
                </h3>
                <a href="{{ route('admin.products.create') }}" data-testid="add-product-button"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition duration-200 ease-in-out bg-blue-600 rounded-lg shadow hover:bg-blue-700">
                    <i class="mr-2 fas fa-plus"></i> Tambah Produk
                </a>
            </div>

            {{-- Notifikasi sukses --}}
            @if(session('success'))
                <div data-testid="alert-success" class="p-3 mb-4 text-green-700 bg-green-100 border border-green-300 rounded-md">
                    <i class="mr-2 fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tabel Produk --}}
            <div class="overflow-x-auto">
                <table data-testid="product-table" class="min-w-full text-sm border divide-y divide-gray-200 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr data-testid="product-row">
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">No</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Gambar</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Kategori</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Nama Produk</th>
                            <th class="px-4 py-2 font-semibold text-left text-gray-600">Harga</th>
                            <th class="px-4 py-2 font-semibold text-right text-gray-600">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @forelse ($products as $product)
                            <tr data-testid="product-row" class="transition hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-2">
                                    @if($product->image)
                                        <img src="{{ asset('storage/'.$product->image) }}"
                                             class="object-cover rounded w-14 h-14">
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                <td class="px-4 py-2">
                                    {{ $product->category->name }}
                                </td>

                                <td class="px-4 py-2">
                                    {{ $product->name }}
                                </td>

                                <td class="px-4 py-2">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-2 space-x-2 text-right">

                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.products.edit', $product->id) }}" data-testid="edit-product-button"
                                       class="inline-flex items-center px-3 py-1 text-sm font-medium text-white transition duration-200 bg-yellow-500 rounded-md hover:bg-yellow-600">
                                        <i class="mr-1 fas fa-edit"></i> Edit
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" data-testid="delete-product-button"
                                                onclick="return confirm('Yakin hapus produk ini?')"
                                                class="inline-flex items-center px-3 py-1 text-sm font-medium text-white transition duration-200 bg-red-600 rounded-md hover:bg-red-700">
                                            <i class="mr-1 fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-center text-gray-500">
                                    <i class="mr-2 fas fa-inbox"></i> Belum ada produk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
