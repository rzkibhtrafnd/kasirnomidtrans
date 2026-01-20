<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600" data-testid="forgot-password-text">
        {{ __('Lupa kata sandi? Masukkan email Anda dan kami akan mengirim tautan reset.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" data-testid="session-status" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" :value="old('email')" required autofocus
                          class="block w-full mt-1"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>{{ __('Kirim Tautan Reset') }}</x-primary-button>
        </div>
    </form>
</x-guest-layout>