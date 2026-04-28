<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ Auth::user()->school->name ?? 'Portal' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="font-sans antialiased text-slate-900 bg-slate-50">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        
        <!-- MOBILE OVERLAY -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-20 bg-slate-900/60 backdrop-blur-sm lg:hidden" 
             x-cloak>
        </div>

        <!-- Sidebar (Deep Blue Aesthetic) -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-30 w-72 bg-blue-900 text-white transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
            
            <!-- CLOSE BUTTON (Mobile Only) -->
            <button @click="sidebarOpen = false" class="lg:hidden absolute top-5 right-5 text-blue-200 hover:text-white transition-colors">
                <i class="fas fa-times text-2xl"></i>
            </button>

            <div class="flex flex-col h-full">
                
                <!-- School Branding Section -->
                <div class="px-8 py-10">
                    <div class="flex items-center space-x-3">
                        @if(Auth::user()->school && Auth::user()->school->logo)
                            <img src="{{ asset('storage/'.Auth::user()->school->logo) }}" class="h-10 w-10 rounded-xl object-cover border border-blue-700 bg-white p-0.5 shadow-sm">
                        @else
                            <div class="h-10 w-10 bg-blue-800 rounded-xl flex items-center justify-center text-white border border-blue-700 shadow-lg">
                                <i class="fas fa-graduation-cap text-lg"></i>
                            </div>
                        @endif
                        <div class="overflow-hidden">
                            <h2 class="font-black text-white tracking-tight truncate leading-tight uppercase text-sm">
                                {{ Auth::user()->school->name ?? 'EduCare' }}
                            </h2>
                            <p class="text-[9px] font-bold text-blue-400 uppercase tracking-[0.2em] mt-1 leading-none">Institutional Portal</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Tabs -->
                <nav class="flex-1 px-6 space-y-1 overflow-y-auto custom-scrollbar">
                    
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('dashboard') ? 'bg-blue-800 text-white shadow-lg shadow-blue-900/50' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-black text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-th-large w-6 text-lg"></i> <span class="mx-3">Dashboard</span>
                    </a>

                    <p class="px-4 pt-8 pb-2 text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] italic-none">Academic</p>
                    
                    <!-- Students -->
                    <a href="{{ route('admin.students') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('admin.students*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-black text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-user-graduate w-6 text-lg"></i> <span class="mx-3">Students</span>
                    </a>

                    <!-- Teachers -->
                    <a href="{{ route('admin.teachers') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('admin.teachers*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-black text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-chalkboard-teacher w-6 text-lg"></i> <span class="mx-3">Teachers</span>
                    </a>

                    <!-- Staff Registry -->
                    <a href="{{ route('admin.staff.index') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('admin.staff*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-black text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-user-tie w-6 text-lg"></i> <span class="mx-3">Staff Registry</span>
                    </a>

                    <!-- Class -->
                    <a href="{{ route('admin.classes') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('admin.classes*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-black text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-layer-group w-6 text-lg"></i> <span class="mx-3">Class</span>
                    </a>

                    <!-- Subject -->
                    <a href="{{ route('admin.subjects') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('admin.subjects*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-black text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-book w-6 text-lg"></i> <span class="mx-3">Subject</span>
                    </a>

                    <!-- Timetable -->
                    <a href="{{ route('admin.timetables') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('admin.timetables*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-black text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-calendar-alt w-6"></i> <span class="mx-3">Timetable</span>
                    </a>

                    <p class="px-4 pt-8 pb-2 text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] italic-none">Management</p>

                    <!-- Linking Requests (RESTORED) -->
                    <a href="{{ route('admin.parents.requests') }}" class="flex items-center justify-between px-4 py-4 {{ request()->routeIs('admin.parents.requests*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-black text-sm transition-all italic-none uppercase tracking-widest">
                        <div class="flex items-center">
                            <i class="fas fa-link w-6 text-lg"></i> <span class="mx-3">Linking Requests</span>
                        </div>
                        
                        @php
                            $pendingRequests = \App\Models\ChildLinkingRequest::where('school_id', Auth::user()->school_id)
                                                ->where('status', 'pending')->count();
                        @endphp

                        @if($pendingRequests > 0)
                            <span class="flex items-center justify-center min-w-[20px] h-5 px-1.5 bg-red-500 text-white text-[9px] font-black rounded-lg shadow-lg">
                                {{ $pendingRequests }}
                            </span>
                        @endif
                    </a>

                    <!-- Result Token -->
                    <a href="{{ route('admin.tokens') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('admin.tokens*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-black text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-ticket-alt w-6 text-lg"></i> <span class="mx-3">Result Token</span>
                    </a>

                    <!-- Finance -->
                    <a href="{{ route('admin.finance') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('admin.finance*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-black text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-wallet w-6 text-lg"></i> <span class="mx-3">Finance</span>
                    </a>

                    <!-- Parents -->
                    <a href="{{ route('admin.parents') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('admin.parents') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-black text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-users w-6 text-lg"></i> <span class="mx-3">Parents</span>
                    </a>

                    <p class="px-4 pt-8 pb-2 text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] italic-none">System</p>

                    <!-- Notice Board -->
                    <a href="{{ route('admin.noticeboard') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('admin.noticeboard*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-black text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-bullhorn w-6 text-lg"></i> <span class="mx-3">Notice Board</span>
                    </a>

                    <!-- System Settings -->
                    <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('admin.settings*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-black text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-cogs w-6 text-lg"></i> <span class="mx-3">System Settings</span>
                    </a>

                    <!-- Inside the nav tag, potentially under 'System' or as a standalone section -->
                    <p class="px-4 pt-8 pb-2 text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] italic-none">Billing</p>
                    <a href="{{ route('admin.subscription.index') }}" 
                    class="flex items-center px-4 py-4 {{ request()->routeIs('admin.subscription*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-black text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-credit-card w-6"></i> <span class="mx-3">My Subscription</span>
                    </a>

                    <a href="{{ route('admin.support') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('admin.support*') ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-slate-500 hover:bg-slate-50' }} rounded-xl font-bold text-sm transition-all italic-none uppercase">
                        <i class="fas fa-question-circle w-6"></i> <span class="mx-3">Help Center</span>
                    </a>

                </nav>

                <!-- Footer Section -->
                <div class="p-6 space-y-4 border-t border-blue-800">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-2 text-blue-300 hover:text-red-400 font-bold text-sm transition-all">
                            <i class="fas fa-sign-out-alt w-6"></i> <span class="mx-2">Logout</span>
                        </button>
                    </form>
                </div>
                <!-- Developer Attribution -->
                <div class="px-8 py-6 mt-auto border-t border-blue-800/50">
                    <div class="flex items-center space-x-3 opacity-60 hover:opacity-100 transition-opacity cursor-default">
                        <div class="w-6 h-6 bg-blue-700 rounded-lg flex items-center justify-center text-[10px]">
                            <i class="fas fa-code text-blue-200"></i>
                        </div>
                        <p class="text-[8px] font-black text-blue-300 uppercase tracking-widest leading-tight italic-none">
                            Developed & Managed by <br>
                            <span class="text-white">Codecraft Developers Ltd.</span>
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Global Top Navbar -->
            <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8">

                <div class="hidden lg:flex items-center bg-blue-50 px-5 py-2.5 rounded-2xl border border-blue-100 mr-6">
                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse mr-3"></div>
                    <div class="leading-none">
                        <p class="text-[9px] font-black text-blue-400 uppercase tracking-widest leading-none mb-1 italic-none">Current State</p>
                        <p class="text-[11px] font-black text-blue-700 uppercase leading-none italic-none">
                            {{ Auth::user()->school->current_term }} • {{ Auth::user()->school->current_session }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center flex-1">
                    <button @click="sidebarOpen = true" class="lg:hidden text-blue-900 mr-4 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    
                    <div class="relative w-full max-w-md hidden md:block">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="w-full pl-11 pr-4 py-2.5 border-none bg-slate-100 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 transition-all font-medium" placeholder="Search institutional records...">
                    </div>
                </div>

                <div class="flex items-center space-x-6">
                    <div class="hidden md:flex items-center space-x-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] pl-4">
                        <a href="#" class="hover:text-blue-600 transition-colors">Reports</a>
                        <a href="#" class="hover:text-blue-600 transition-colors">Schedule</a>
                    </div>
                    
                    <div class="h-8 w-px bg-slate-100 hidden md:block"></div>

                    <div class="flex items-center space-x-3">
                        <div class="text-right hidden sm:block leading-none">
                            <p class="text-sm font-black text-slate-800 leading-none">{{ Auth::user()->name }}</p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Directorate</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" class="h-10 w-10 rounded-xl object-cover border border-slate-200 shadow-sm">
                    </div>
                </div>
            </header>

            @if (session('success') || session('error'))
                <x-alert />
            @endif

            <!-- Page-Specific Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 lg:p-10">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>