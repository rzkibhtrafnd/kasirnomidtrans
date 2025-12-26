<aside
    class="fixed inset-y-0 left-0 z-40 w-64 transition-transform duration-300 transform bg-white border-r shadow-lg lg:static lg:translate-x-0"
    :class="{
        '-translate-x-full': !sidebarOpen,
        'translate-x-0': sidebarOpen
    }"
>

    {{-- HEADER --}}
    <div class="flex items-center justify-between p-4 border-b">
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center w-10 h-10 text-white rounded-lg">
                <div class="flex items-center justify-center w-10 h-10 overflow-hidden rounded-lg">
                    @if($setting?->img_logo)
                        <img src="{{ asset('storage/settings/' . $setting->img_logo) }}" 
                            alt="Logo" class="object-contain w-full h-full">
                    @else
                        <i class="text-white fas fa-store"></i>
                    @endif
                </div>
            </div>
            <div>
                <h1 class="font-semibold">{{ config('app.name') }}</h1>
                <p class="text-xs text-gray-500">
                    {{ $setting->company_name ?? 'System Panel' }}
                </p>
            </div>
        </div>

        {{-- CLOSE BTN (tablet & mobile) --}}
        <button 
            @click="sidebarOpen = false"
            class="text-gray-500 lg:hidden"
        >
            ✕
        </button>
    </div>

    {{-- USER PANEL --}}
    <div class="p-4 border-b bg-gray-50">
        <p class="text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
        <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</p>
    </div>

    {{-- MENU --}}
    <nav class="p-4 space-y-1 overflow-y-auto">

        @if(Auth::user()->role === 'admin')
            <x-nav-link 
                href="{{ route('dashboard') }}" 
                name="Dashboard" 
                icon="gauge"
                :active="request()->routeIs('dashboard')"
            />
            <x-nav-link 
                href="{{ route('admin.kasir.index') }}" 
                name="Kasir" 
                icon="users"
                :active="request()->routeIs('admin.kasir.*')"
            />
            <x-nav-link 
                href="{{ route('admin.settings.index') }}" 
                name="Pengaturan" 
                icon="cog"
                :active="request()->routeIs('admin.settings.*')"
            />
        @endif

        @if(Auth::user()->role === 'kasir')
            <x-nav-link 
                href="{{ route('dashboard') }}" 
                name="Dashboard" 
                icon="gauge"
                :active="request()->routeIs('dashboard')"
            />
        @endif

        <div class="pt-4 mt-4 text-xs text-gray-400 uppercase border-t">
            Manajemen
        </div>

        @if(Auth::user()->role === 'admin')
            <x-nav-link 
                href="{{ route('admin.categories.index') }}" 
                name="Kategori" 
                icon="tags"
                :active="request()->routeIs('admin.categories.*')"
            />
            <x-nav-link 
                href="{{ route('admin.products.index') }}" 
                name="Produk" 
                icon="box-open"
                :active="request()->routeIs('admin.products.*')"
            />
        @endif
        
        <x-nav-link 
            href="{{ route('transactions.create') }}" 
            name="Transaksi" 
            icon="cash-register"
            :active="request()->routeIs('transactions.create')"
        />
        <x-nav-link 
            href="{{ route('transactions.index') }}" 
            name="Riwayat Transaksi" 
            icon="history"
            :active="request()->routeIs('transactions.*') && !request()->routeIs('transactions.create')"
        />
    </nav>

</aside>
