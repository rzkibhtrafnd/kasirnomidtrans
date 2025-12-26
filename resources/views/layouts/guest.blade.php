<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $setting->company_name ?? config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-100">
        
        <div class="flex flex-col min-h-screen">
            
            <main class="flex flex-col items-center justify-center flex-grow px-4 py-12">
                <div class="mb-4 text-center">
                    <div class="flex justify-center mb-2">
                        <x-application-logo class="w-16 h-16 text-gray-500 fill-current" />
                    </div>
                    <h2 class="mb-2 text-2xl font-black tracking-tight text-gray-800">
                        Cashly Management System
                    </h2>
                    <p class="text-sm font-bold tracking-widest text-blue-500">
                        {{ $setting->company_name ?? 'Nama Perusahaan' }}
                    </p>
                </div>

                <div class="w-full px-6 py-6 mt-4 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">
                    {{ $slot }}
                </div>
            </main>

            <footer class="bg-white border-t border-gray-200">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                            Cashly Management System
                        </p>
                        
                        <p class="text-xs text-gray-400">
                            &copy; {{ date('Y') }} <span class="font-semibold text-blue-600">{{ $setting->company_name ?? config('app.name') }}</span>. 
                            All rights reserved.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>