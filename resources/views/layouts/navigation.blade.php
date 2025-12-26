<nav class="flex items-center justify-between w-full px-6 py-4 bg-white border-b shadow-sm">
    <div class="text-lg font-semibold">
        {{ ucfirst(Auth::user()->role) }} Dashboard
    </div>

    <!-- User Dropdown -->
    <div>
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="flex items-center px-4 py-2 text-sm text-gray-600 bg-gray-100 rounded hover:bg-gray-200">
                    {{ Auth::user()->name }}

                    <svg class="w-4 h-4 ms-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 
                              111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                              clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    Profile
                </x-dropdown-link>
            </x-slot>
        </x-dropdown>
    </div>
</nav>
