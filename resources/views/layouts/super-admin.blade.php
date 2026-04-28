<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EduCare | Super Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-900 bg-slate-50">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        <!-- Blue Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-72 bg-blue-900 transition duration-300 transform lg:translate-x-0 lg:static">
            <div class="flex flex-col h-full">
                
                <div class="px-8 py-10">
                    <span class="text-white text-2xl font-black tracking-tight">EduCare</span>
                    <p class="text-blue-300 text-[10px] font-bold uppercase tracking-[0.3em] mt-1">Super Admin Console</p>
                </div>

                <nav class="flex-1 px-6 space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('dashboard') ? 'bg-blue-800 text-white shadow-lg shadow-blue-900/50' : 'text-blue-100 hover:bg-blue-800' }} rounded-xl font-bold text-sm transition-all">
                        <i class="fas fa-network-wired w-6"></i> <span class="mx-3">Network Overview</span>
                    </a>
                    <a href="{{ route('schools.index') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('schools.index') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:bg-blue-800' }} rounded-xl font-bold text-sm transition-all">
                        <i class="fas fa-school w-6"></i> <span class="mx-3">Institutions</span>
                    </a>

                    <a href="{{ route('super_admin.admins.index') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('super_admin.admins.*') ? 'bg-blue-800 text-white shadow-lg shadow-blue-900/50' : 'text-blue-100 hover:bg-blue-800' }} rounded-xl font-bold text-sm transition-all">
                        <i class="fas fa-users-cog w-6"></i> <span class="mx-3">School Admins</span>
                    </a>

                    <a href="{{ route('super_admin.plans.index') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('super_admin.plans.index') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:bg-blue-800' }} rounded-xl font-bold text-sm transition-all">
                        <i class="fas fa-credit-card w-6"></i> <span class="mx-3">Subscription Plans</span>
                    </a>

                    <a href="{{ route('super_admin.payments.index') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('super_admin.payments.index') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:bg-blue-800' }} rounded-xl font-bold text-sm transition-all">
                        <i class="fas fa-money-bill-wave w-6"></i> <span class="mx-3">Payments</span>
                    </a>

                    <a href="{{ route('super_admin.support.index') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('super_admin.support*') ? 'bg-blue-800 shadow-xl' : 'text-blue-100 hover:bg-blue-800' }} rounded-2xl font-bold text-sm transition-all italic-none">
                        <i class="fas fa-headset w-6"></i> <span class="mx-3">Support Setup</span>
                    </a>

                </nav>

                <div class="p-6 border-t border-blue-800">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-blue-300 hover:text-white font-bold text-sm transition-all">
                            <i class="fas fa-sign-out-alt w-6"></i> <span class="mx-3">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            <!-- Header with Search -->
            <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8">
                <div class="flex items-center flex-1">
                    <button @click="sidebarOpen = true" class="lg:hidden text-slate-500 mr-4"><i class="fas fa-bars text-xl"></i></button>
                    <div class="relative w-full max-w-md">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="w-full pl-11 pr-4 py-2.5 border-none bg-slate-100 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20" placeholder="Search institutions, plans, or logs...">
                    </div>
                </div>
                <div class="flex items-center space-x-6">
                    <div class="flex items-center space-x-3">
                        <span class="text-sm font-black text-slate-700">Academic Curator</span>
                        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-bold">
                            <i class="fas fa-user-shield"></i>
                        </div>
                    </div>
                </div>
            </header>

            @if (session('success') || session('error'))
                <x-alert />
            @endif

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-10">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>