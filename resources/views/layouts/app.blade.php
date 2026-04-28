<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EduCare') }}</title>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-900">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-slate-50">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden"></div>

        <!-- Sidebar (Blue Background) -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-blue-800 lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex items-center justify-start px-6 py-8">
                <div class="text-white text-2xl font-bold">
                    <i class="fas fa-graduation-cap mr-2"></i>EduCare
                </div>
            </div>
            
            <p class="px-6 text-xs font-semibold text-blue-300 uppercase tracking-wider">Super Admin Console</p>

            <nav class="mt-6 px-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard') ? 'text-white bg-blue-700' : 'text-blue-100 hover:bg-blue-700' }} rounded-lg font-medium transition-colors">
                    <i class="fas fa-network-wired w-6"></i>
                    <span class="mx-3">Network Overview</span>
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-blue-100 hover:bg-blue-700 rounded-lg transition-colors">
                    <i class="fas fa-school w-6"></i>
                    <span class="mx-3">Institutions</span>
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-blue-100 hover:bg-blue-700 rounded-lg transition-colors">
                    <i class="fas fa-credit-card w-6"></i>
                    <span class="mx-3">Subscription Plans</span>
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-blue-100 hover:bg-blue-700 rounded-lg transition-colors">
                    <i class="fas fa-cog w-6"></i>
                    <span class="mx-3">Settings</span>
                </a>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-blue-100 hover:bg-red-600 rounded-lg transition-colors mt-10">
                        <i class="fas fa-sign-out-alt w-6"></i>
                        <span class="mx-3">Logout</span>
                    </button>
                </form>
            </nav>

            <!-- User Profile Bottom -->
            <div class="absolute bottom-0 w-full p-4 border-t border-blue-700">
                <div class="flex items-center p-2 bg-blue-900/50 rounded-xl">
                    <img class="h-10 w-10 rounded-lg object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=fff&color=1e40af" alt="Avatar">
                    <div class="ml-3">
                        <p class="text-sm font-bold text-white">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-blue-300 font-bold uppercase tracking-tight">Master Authority</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Global Top Navbar -->
            <header class="flex items-center justify-between px-8 py-4 bg-white border-b border-slate-200">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-slate-500 focus:outline-none lg:hidden mr-4">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <div class="relative w-full max-w-md hidden md:block">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fas fa-search text-slate-400"></i>
                        </span>
                        <input class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20" type="text" placeholder="Search data...">
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <button class="text-slate-500 hover:text-blue-600 relative">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    <div class="h-8 w-px bg-slate-200 mx-2"></div>
                    <div class="flex items-center">
                        <span class="text-slate-700 text-sm font-bold mr-3 hidden sm:block">Academic Curator</span>
                        <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-500">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page-Specific Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>