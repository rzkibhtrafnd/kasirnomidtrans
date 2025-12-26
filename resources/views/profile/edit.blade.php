<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                    <div class="w-full">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
                <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                    <div class="w-full">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
