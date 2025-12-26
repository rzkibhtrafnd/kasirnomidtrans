<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ __('Setting Mitra Kasir') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white shadow-sm sm:rounded-lg">

                @if(session('success'))
                    <div class="p-2 mb-4 text-green-800 bg-green-100 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-gray-700">Nama Perusahaan</label>
                            <input type="text" name="company_name" class="w-full p-2 border rounded"
                                value="{{ old('company_name', $setting->company_name ?? 'UPN MART') }}" required>
                        </div>

                        <div>
                            <label class="block text-gray-700">Email</label>
                            <input type="email" name="email" class="w-full p-2 border rounded"
                                value="{{ old('email', $setting->email ?? 'gonuhakez@mailinator.com') }}">
                        </div>

                        <div>
                            <label class="block text-gray-700">Telepon</label>
                            <input type="text" name="phone" class="w-full p-2 border rounded"
                                value="{{ old('phone', $setting->phone ?? '+1 (463) 764-9643') }}">
                        </div>

                        <div>
                            <label class="block text-gray-700">Alamat</label>
                            <textarea name="address" class="w-full p-2 border rounded">{{ old('address', $setting->address ?? 'Jalan') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-gray-700">WiFi SSID</label>
                            <input type="text" name="wifi" class="w-full p-2 border rounded"
                                value="{{ old('wifi', $setting->wifi ?? '') }}">
                        </div>

                        <div>
                            <label class="block text-gray-700">WiFi Password</label>
                            <input type="text" name="wifi_password" class="w-full p-2 border rounded"
                                value="{{ old('wifi_password', $setting->wifi_password ?? '') }}">
                        </div>

                        {{-- Logo --}}
                        <div>
                            <label class="block text-gray-700">Logo Perusahaan</label>
                            @if($setting?->img_logo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/settings/' . $setting->img_logo) }}" alt="Logo" class="object-contain w-16 h-16 rounded">
                                </div>
                            @endif
                            <input type="file" name="img_logo" class="w-full p-2 border rounded">
                        </div>
                        
                        {{-- QRIS --}}
                        <div>
                            <label class="block text-gray-700">QRIS (Pembayaran)</label>

                            @if($setting?->img_qris)
                                <div class="mb-2">
                                    <img 
                                        src="{{ asset('storage/settings/' . $setting->img_qris) }}" 
                                        alt="QRIS"
                                        class="object-contain w-32 h-32 border rounded"
                                    >
                                </div>
                            @endif

                            <input type="file" name="img_qris" class="w-full p-2 border rounded">
                            <p class="mt-1 text-xs text-gray-500">
                                Upload QR Code QRIS (JPG / PNG)
                            </p>
                        </div>

                        <div>
                            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                                Simpan
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>