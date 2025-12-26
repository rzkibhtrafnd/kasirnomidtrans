<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">

<div 
    x-data="{ sidebarOpen: false }"
    class="flex min-h-screen overflow-hidden"
>

    <div 
        x-show="sidebarOpen"
        x-transition.opacity
        @click="sidebarOpen = false"
        class="fixed inset-0 z-30 bg-black/50 lg:hidden"
    ></div>

    @include('layouts.sidebar')

    <div class="flex flex-col flex-1 min-w-0">

        {{-- HEADER --}}
        <header class="flex items-center justify-between px-4 py-3 bg-white border-b shadow-sm">

            {{-- Sidebar toggle button --}}
            <button 
                @click="sidebarOpen = true"
                class="text-xl lg:hidden focus:outline-none"
            >
                <i class="fas fa-bars"></i>
            </button>

            <div class="flex items-center gap-3">
                <span class="hidden font-semibold lg:inline">
                    Selamat Bekerja, {{ Auth::user()->name }}
                </span>
            </div>

            {{-- User Dropdown --}}
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center px-3 py-2 text-sm bg-gray-100 rounded hover:bg-gray-200">
                        {{ Auth::user()->name }}
                        <i class="ml-2 text-xs fas fa-chevron-down"></i>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        Profile
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link
                            :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                        >
                            Logout
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>

        </header>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-4 overflow-y-auto sm:p-6">
            {{ $slot }}
        </main>

        <footer class="mt-auto bg-white border-t border-gray-200">
            <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
                    <div class="flex items-center">
                        <div class="text-left">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                Cashly Management System
                            </p>
                        </div>
                    </div>
                        
                    <div class="text-center md:text-right">
                        <p class="text-xs text-gray-400">
                            &copy; {{ date('Y') }} <span class="font-semibold text-blue-600">{{ $setting->company_name ?? config('app.name') }}</span>. 
                            <span class="hidden sm:inline">All rights reserved.</span>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

</body>
</html>
