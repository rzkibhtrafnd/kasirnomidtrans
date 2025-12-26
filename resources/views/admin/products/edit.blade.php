<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white rounded-lg shadow">

                <form action="{{ route('admin.products.update', $product) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-4">
                    @csrf
                    @method('PUT')

                    {{-- Kategori --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium">Kategori</label>
                        <select name="category_id"
                                class="w-full p-2 border rounded"
                                required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Nama --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium">Nama Produk</label>
                        <input type="text"
                               name="name"
                               value="{{ $product->name }}"
                               class="w-full p-2 border rounded"
                               required>
                    </div>

                    {{-- Gambar --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium">Gambar Produk</label>

                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}"
                                 class="object-cover w-24 h-24 mb-2 rounded">
                        @endif

                        <input type="file"
                               name="image"
                               class="w-full p-2 border rounded">
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium">Harga (Rp)</label>
                        <input type="number"
                               name="price"
                               value="{{ $product->price }}"
                               class="w-full p-2 border rounded"
                               required>
                    </div>

                    {{-- Button --}}
                    <div class="flex justify-end gap-2 pt-4">
                        <a href="{{ route('admin.products.index') }}"
                           class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
