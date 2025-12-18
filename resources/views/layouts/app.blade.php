<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Spacer') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.getItem('sidebarExpanded') === 'false') {
            document.documentElement.classList.add('sidebar-collapsed');
        }
    </script>
    <style>
        .sidebar-collapsed aside {
            width: 4.5rem !important; 
        }
        .sidebar-collapsed .sidebar-text {
            display: none !important; 
        }
        .sidebar-collapsed .logo-container {
            padding-left: 0 !important;
            padding-right: 0 !important;
            justify-content: center !important;
        }
    </style>
</head>
<body class="font-sans antialiased bg-slate-950 text-slate-300">
    
    <div x-data="{ 
            sidebarOpen: false, 
            sidebarExpanded: localStorage.getItem('sidebarExpanded') !== 'false', // Default true kecuali user pernah menutupnya
            toggleSidebar() {
                this.sidebarExpanded = !this.sidebarExpanded;
                localStorage.setItem('sidebarExpanded', this.sidebarExpanded);
                
                // Sinkronisasi class html untuk reload selanjutnya
                if(!this.sidebarExpanded) {
                    document.documentElement.classList.add('sidebar-collapsed');
                } else {
                    document.documentElement.classList.remove('sidebar-collapsed');
                }
            }
        }" 
        class="flex h-screen overflow-hidden">

        <aside 
            class="fixed inset-y-0 left-0 z-50 flex flex-col bg-slate-900 border-r border-slate-800 transition-all duration-300 ease-in-out lg:static lg:translate-x-0 w-64"
            :class="{
                '-translate-x-full': !sidebarOpen,
                'translate-x-0': sidebarOpen,
                'w-64': sidebarExpanded,
                'w-[4.5rem]': !sidebarExpanded
            }"
        >
            <div class="flex items-center h-20 border-b border-slate-800/50 relative overflow-hidden transition-all duration-300 px-6 logo-container"
                 :class="sidebarExpanded ? 'px-6' : 'px-0 justify-center'">
                
                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center shadow-lg shadow-indigo-500/20 z-20 relative bg-white overflow-hidden">
                    <img src="{{ asset('apple-touch-icon.png') }}" alt="Spacer Logo" class="w-full h-full object-cover">
                </div>

                <div class="whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out absolute left-20 sidebar-text"
                     :class="sidebarExpanded ? 'opacity-100 translate-x-0 visible' : 'opacity-0 -translate-x-5 invisible'">
                    <span class="text-xl font-bold text-white tracking-wide">Spacer</span>
                </div>
            </div>

            <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto overflow-x-hidden">
                @php
                    $menus = [
                        ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                        ['name' => 'Focus',     'route' => 'focus',     'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['name' => 'To-Do',     'route' => 'todo',      'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                        ['name' => 'Calendar',  'route' => 'calendar',  'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                        ['name' => 'Notes',     'route' => 'notes',     'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                    ];
                @endphp

                @foreach ($menus as $menu)
                    <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#' }}" 
                       class="flex items-center px-3 py-3 rounded-lg transition-all duration-200 group relative
                       {{ request()->routeIs($menu['route']) ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }}"
                       :class="sidebarExpanded ? 'justify-start' : 'justify-center'">
                        
                        <svg class="w-6 h-6 flex-shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}"></path>
                        </svg>

                        <span class="font-medium whitespace-nowrap overflow-hidden transition-all duration-300 absolute left-12 sidebar-text"
                              :class="sidebarExpanded ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-4 pointer-events-none'">
                            {{ $menu['name'] }}
                        </span>
                        
                        <div x-show="!sidebarExpanded" 
                             class="absolute left-14 top-1/2 -translate-y-1/2 px-2 py-1 bg-slate-700 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 pointer-events-none shadow-md">
                            {{ $menu['name'] }}
                        </div>
                    </a>
                @endforeach
            </nav>

            <div class="border-t border-slate-800 p-4 overflow-hidden relative">
                <div class="flex items-center transition-all duration-300 logo-container" 
                     :class="sidebarExpanded ? 'justify-start' : 'justify-center'">
                    
                    <div class="flex-shrink-0 w-9 h-9 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-sm shadow-md z-20 relative">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>

                    <div class="ml-3 whitespace-nowrap overflow-hidden transition-all duration-300 absolute left-14 sidebar-text"
                         :class="sidebarExpanded ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-4'">
                        <p class="text-sm font-medium text-white truncate max-w-[120px]">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 truncate max-w-[120px]">Free Plan</p>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="absolute right-4 sidebar-text"
                          x-show="sidebarExpanded" 
                          x-transition:enter="transition ease-out duration-300 delay-100"
                          x-transition:enter-start="opacity-0 translate-x-2"
                          x-transition:enter-end="opacity-100 translate-x-0">
                        @csrf
                        <button type="submit" class="text-slate-500 hover:text-red-400 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

            <button @click="toggleSidebar()" 
                    class="hidden lg:flex absolute -right-3 top-24 bg-slate-800 border border-slate-700 text-slate-400 hover:text-white rounded-full p-1 shadow-md transition-transform duration-300 z-50"
                    :class="sidebarExpanded ? 'rotate-0' : 'rotate-180'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
        </aside>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden" x-transition.opacity></div>
        <div class="flex-1 flex flex-col overflow-hidden relative transition-all duration-300">
            <header class="flex items-center justify-between p-4 bg-slate-900 border-b border-slate-800 lg:hidden">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-slate-400 hover:text-white mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div class="w-8 h-8 rounded-full bg-white overflow-hidden flex items-center justify-center">
                        <img src="{{ asset('apple-touch-icon.png') }}" alt="Logo" class="w-full h-full object-cover">
                    </div>
                    <span class="ml-3 text-lg font-bold text-white">Spacer</span>
                </div>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-950 p-6 [scrollbar-gutter:stable]">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>