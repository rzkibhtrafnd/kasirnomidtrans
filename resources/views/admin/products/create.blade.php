<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tambah Produk') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white rounded-lg shadow">

                <form action="{{ route('admin.products.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-4">
                    @csrf

                    {{-- Kategori --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium">Kategori</label>
                        <select name="category_id"
                                class="w-full p-2 border rounded"
                                required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium">Nama Produk</label>
                        <input type="text"
                               name="name"
                               class="w-full p-2 border rounded"
                               required>
                        @error('name')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gambar --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium">Gambar Produk</label>
                        <input type="file"
                               name="image"
                               class="w-full p-2 border rounded">
                        @error('image')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium">Harga (Rp)</label>
                        <input type="number"
                               name="price"
                               class="w-full p-2 border rounded"
                               required>
                        @error('price')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Button --}}
                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('admin.products.index') }}"
                           class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
