<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Kasir') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="p-6 bg-white shadow-sm sm:rounded-lg">

                {{-- Form --}}
                <form action="{{ route('admin.kasir.update', $kasir->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $kasir->name) }}"
                            class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Masukkan nama kasir" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $kasir->email) }}"
                            class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Masukkan email" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">Password</label>

                        <div class="p-3 text-sm text-gray-700 bg-gray-100 border border-gray-300 rounded-md">
                            Default password: 
                            <span class="font-semibold text-gray-900">password</span>
                        </div>

                        <p class="mt-1 text-xs text-gray-500">
                            Kasir akan diminta mengganti password saat login pertama.
                        </p>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('admin.kasir.index') }}"
                            class="px-4 py-2 text-sm text-gray-600 transition bg-gray-200 rounded-lg hover:bg-gray-300">
                            Batal
                        </a>

                        <button type="submit"
                            class="px-4 py-2 text-sm font-semibold text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">
                            Edit
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>
