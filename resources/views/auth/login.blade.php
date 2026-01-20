<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" data-testid="session-status" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" :value="old('email')" required autofocus autocomplete="username"
                          class="block w-full mt-1" data-testid="email-input"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" data-testid="email-error"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" name="password" type="password" required autocomplete="current-password"
                          class="block w-full mt-1" data-testid="password-input"/>
            <x-input-error :messages="$errors->get('password')" class="mt-2" data-testid="password-error"/>
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" name="remember" type="checkbox" class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                   {{ __('Forgot your password?') }}
                </a>
            @endif
            <x-primary-button class="ml-3" data-testid="login-button">{{ __('Log in') }}</x-primary-button>
        </div>
    </form>
</x-guest-layout>