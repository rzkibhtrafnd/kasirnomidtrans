<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow-sm sm:rounded-lg">

                <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Nama Kategori
                        </label>
                        <input data-testid="category-name-input" type="text" name="name"
                               value="{{ old('name', $category->name) }}"
                               class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-200"
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('admin.categories.index') }}"
                           class="px-4 py-2 text-sm bg-gray-200 rounded hover:bg-gray-300">
                            Batal
                        </a>
                        <button data-testid="submit-category-button" type="submit"
                                class="px-4 py-2 text-sm text-white bg-blue-600 rounded hover:bg-blue-700">
                            Update
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
