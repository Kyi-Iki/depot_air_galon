<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sistem Informasi Depot Air Minum AquaSegar - Kelola transaksi, pelanggan, dan produk dengan mudah.">
    <title>@yield('title', 'Dashboard') - Depot Air AquaSegar</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #93c5fd; border-radius: 3px; }
        /* Sidebar active transition */
        .nav-link { transition: all 0.2s ease; }
        /* Toast auto-dismiss animation */
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to   { transform: translateX(0);   opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to   { opacity: 0; transform: translateX(20px); }
        }
        .toast-enter { animation: slideInRight 0.35s ease forwards; }
        .toast-leave { animation: fadeOut 0.35s ease forwards; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex" x-data="{ sidebarOpen: false }">

    <!-- ===== SIDEBAR DESKTOP ===== -->
    <aside class="hidden md:flex flex-col w-64 bg-blue-900 text-white shrink-0 shadow-xl">
        <!-- Brand -->
        <div class="h-16 flex items-center px-6 space-x-3 bg-blue-950 border-b border-blue-800">
            <div class="w-9 h-9 rounded-xl bg-white flex items-center justify-center shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-700" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C8 7 4 10.5 4 14a8 8 0 0016 0c0-3.5-4-7-8-12z"/>
                </svg>
            </div>
            <div>
                <span class="text-base font-bold tracking-wide text-white">AquaSegar</span>
                <p class="text-[10px] text-blue-300 -mt-0.5">Depot Air Minum</p>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">
            @php $route = Route::currentRouteName(); @endphp

            <a href="{{ route('dashboard') }}"
               class="nav-link flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium text-sm
                      {{ str_contains($route, 'dashboard') ? 'bg-white text-blue-700 shadow' : 'text-blue-100 hover:bg-blue-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('customers.index') }}"
               class="nav-link flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium text-sm
                      {{ str_contains($route, 'customers') ? 'bg-white text-blue-700 shadow' : 'text-blue-100 hover:bg-blue-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
                <span>Pelanggan</span>
            </a>

            <a href="{{ route('products.index') }}"
               class="nav-link flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium text-sm
                      {{ str_contains($route, 'products') ? 'bg-white text-blue-700 shadow' : 'text-blue-100 hover:bg-blue-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                </svg>
                <span>Produk</span>
            </a>

            <a href="{{ route('transactions.index') }}"
               class="nav-link flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium text-sm
                      {{ str_contains($route, 'transactions') ? 'bg-white text-blue-700 shadow' : 'text-blue-100 hover:bg-blue-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                </svg>
                <span>Transaksi</span>
            </a>
        </nav>

        <!-- User Info -->
        <div class="p-4 border-t border-blue-800 bg-blue-950">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-sm font-bold text-white shrink-0">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-[10px] text-blue-300 truncate">{{ Auth::user()->email ?? '' }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- ===== MOBILE SIDEBAR ===== -->
    <div class="md:hidden" x-show="sidebarOpen" style="display:none;" x-cloak>
        <!-- Backdrop -->
        <div class="fixed inset-0 z-40 bg-blue-950/70 backdrop-blur-sm" @click="sidebarOpen = false"></div>
        <!-- Drawer -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-blue-900 text-white flex flex-col shadow-2xl"
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in duration-150"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full">
            <div class="h-16 flex items-center justify-between px-6 bg-blue-950 border-b border-blue-800">
                <span class="text-base font-bold text-white">AquaSegar</span>
                <button @click="sidebarOpen = false" class="text-blue-300 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <nav class="flex-1 px-3 py-5 space-y-1">
                <a href="{{ route('dashboard') }}"   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-blue-100 hover:bg-blue-800 text-sm font-medium"><span>Dashboard</span></a>
                <a href="{{ route('customers.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-blue-100 hover:bg-blue-800 text-sm font-medium"><span>Pelanggan</span></a>
                <a href="{{ route('products.index') }}"  class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-blue-100 hover:bg-blue-800 text-sm font-medium"><span>Produk</span></a>
                <a href="{{ route('transactions.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-xl text-blue-100 hover:bg-blue-800 text-sm font-medium"><span>Transaksi</span></a>
            </nav>
        </aside>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Top Navbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 md:px-6 shadow-sm z-30 shrink-0">
            <!-- Mobile burger -->
            <button @click="sidebarOpen = true" class="md:hidden text-slate-500 hover:text-blue-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Page title breadcrumb -->
            <div class="hidden md:flex items-center space-x-2 text-sm text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="font-semibold text-blue-700">@yield('page_header', 'Dashboard')</span>
            </div>

            <!-- Right side -->
            <div class="flex items-center space-x-3">
                <span class="hidden sm:flex items-center space-x-1.5 text-xs text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block animate-pulse"></span>
                    <span>Online</span>
                </span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="flex items-center space-x-1.5 px-3 py-1.5 text-xs font-semibold text-slate-600 border border-slate-200 rounded-lg hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Body -->
        <main class="flex-1 p-4 md:p-6 overflow-y-auto">

            {{-- Toast Notifications --}}
            @if(session('success') || session('error'))
                <div x-data="{ show: true }"
                     x-init="setTimeout(() => show = false, 4000)"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-x-8"
                     x-transition:enter-end="opacity-100 translate-x-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-x-0"
                     x-transition:leave-end="opacity-0 translate-x-8"
                     class="fixed top-5 right-5 z-50 max-w-sm w-full">
                    @if(session('success'))
                        <div class="flex items-start gap-3 bg-white border border-emerald-200 rounded-xl shadow-lg shadow-emerald-100 p-4">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                                <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-emerald-800">Berhasil!</p>
                                <p class="text-xs text-slate-600 mt-0.5">{{ session('success') }}</p>
                            </div>
                            <button @click="show = false" class="text-slate-300 hover:text-slate-600 shrink-0">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="flex items-start gap-3 bg-white border border-red-200 rounded-xl shadow-lg shadow-red-100 p-4 {{ session('success') ? 'mt-2' : '' }}">
                            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                                <svg class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-red-800">Gagal!</p>
                                <p class="text-xs text-slate-600 mt-0.5">{{ session('error') }}</p>
                            </div>
                            <button @click="show = false" class="text-slate-300 hover:text-slate-600 shrink-0">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    @endif
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
