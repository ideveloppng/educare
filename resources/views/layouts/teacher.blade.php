<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Teacher Portal | {{ Auth::user()->school->name ?? 'EduCare' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .glass-nav { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
    </style>
</head>
<body class="font-sans antialiased text-slate-900 bg-slate-50 overflow-x-hidden">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        
        <!-- 1. DESKTOP SIDEBAR -->
        <aside class="hidden lg:flex flex-col w-72 bg-blue-900 text-white shrink-0 shadow-2xl z-30">
            <div class="flex flex-col h-full">
                <div class="px-8 py-10">
                    <div class="flex items-center space-x-3">
                        @if(Auth::user()->school && Auth::user()->school->logo)
                            <img src="{{ asset('storage/'.Auth::user()->school->logo) }}" class="h-12 w-12 rounded-xl object-cover border border-blue-700 bg-white p-0.5 shadow-sm">
                        @else
                            <div class="h-12 w-12 bg-blue-800 rounded-xl flex items-center justify-center text-white border border-blue-700 shadow-lg"><i class="fas fa-chalkboard-teacher"></i></div>
                        @endif
                        <div class="overflow-hidden">
                            <h2 class="font-black text-white text-lg tracking-tight truncate leading-tight uppercase italic-none">{{ Auth::user()->school->name ?? 'EduCare' }}</h2>
                            <p class="text-[9px] font-bold text-blue-300 uppercase tracking-[0.2em] mt-1 leading-none italic-none">Faculty Access</p>
                        </div>
                    </div>
                </div>

                <nav class="flex-1 px-6 space-y-1 overflow-y-auto no-scrollbar">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('dashboard') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-bold text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-th-large w-6"></i> <span class="mx-3">Dashboard</span>
                    </a>

                    <p class="px-4 pt-8 pb-2 text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] italic-none">Classroom</p>
                    <a href="{{ route('teacher.attendance.index') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('teacher.attendance*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-bold text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-calendar-check w-6"></i> <span class="mx-3">Attendance</span>
                    </a>
                    <a href="{{ route('teacher.marks.index') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('teacher.marks*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-bold text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-edit w-6"></i> <span class="mx-3">Marks Entry</span>
                    </a>
                    <a href="{{ route('teacher.classes.index') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('teacher.classes*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-bold text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-layer-group w-6"></i> <span class="mx-3">My Classes</span>
                    </a>
                    <a href="{{ route('teacher.assignments.index') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('teacher.assignments*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-bold text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-tasks w-6"></i> <span class="mx-3">Assignments</span>
                    </a>

                    <p class="px-4 pt-8 pb-2 text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] italic-none">Account</p>
                    <a href="{{ route('teacher.profile.index') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('teacher.profile*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-bold text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-user-circle w-6"></i> <span class="mx-3">My Profile</span>
                    </a>

                    <a href="{{ route('teacher.timetable.index') }}" class="flex items-center px-4 py-4 {{ request()->routeIs('teacher.timetable*') ? 'bg-blue-800 text-white shadow-lg' : 'text-blue-100 hover:bg-blue-800/50' }} rounded-xl font-bold text-sm transition-all italic-none uppercase tracking-widest">
                        <i class="fas fa-calendar-alt w-6"></i> <span class="mx-3">My Timetable</span>
                    </a>
                </nav>

                <div class="p-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-4 text-blue-300 hover:text-red-400 font-bold text-sm transition-all italic-none uppercase tracking-widest">
                            <i class="fas fa-sign-out-alt w-6"></i> <span class="mx-3">Logout</span>
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

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col overflow-hidden relative">
            <header class="h-20 lg:h-24 bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-10 shrink-0 z-40 shadow-sm">
                <div class="flex items-center space-x-3 overflow-hidden">
                    <div class="shrink-0 lg:hidden">
                        @if(Auth::user()->school && Auth::user()->school->logo)
                            <img src="{{ asset('storage/'.Auth::user()->school->logo) }}" class="h-10 w-10 rounded-lg object-cover border border-slate-200 bg-white p-0.5">
                        @endif
                    </div>
                    <div class="overflow-hidden leading-tight">
                        <h2 class="font-black text-slate-800 text-xs lg:text-base uppercase truncate italic-none">{{ Auth::user()->school->name }}</h2>
                        <p class="text-[8px] lg:text-[10px] font-black text-blue-600 uppercase tracking-widest mt-1 italic-none flex items-center">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                            {{ Auth::user()->school->current_term }} • {{ Auth::user()->school->current_session }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block leading-none">
                        <p class="text-sm font-black text-slate-800 leading-none uppercase italic-none">{{ Auth::user()->name }}</p>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">Teacher</p>
                    </div>
                    @if(Auth::user()->teacher && Auth::user()->teacher->photo)
                        <img src="{{ asset('storage/'.Auth::user()->teacher->photo) }}" class="h-10 w-10 lg:h-11 lg:w-11 rounded-xl lg:rounded-2xl object-cover border-2 border-white shadow-lg">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1e3a8a&color=fff" class="h-10 w-10 lg:h-11 lg:w-11 rounded-xl lg:rounded-2xl object-cover border-2 border-white shadow-lg">
                    @endif
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 lg:p-12 pb-32 lg:pb-12 no-scrollbar relative">
                @if (session('success') || session('error')) <x-alert /> @endif
                {{ $slot }}
            </main>

            <!-- 4. FLOATING MOBILE BOTTOM NAVIGATION -->
            <div class="lg:hidden fixed bottom-6 left-0 right-0 px-6 z-[100]">
                <nav class="glass-nav max-w-md mx-auto rounded-[3rem] shadow-[0_20px_50px_rgba(0,0,0,0.15)] flex items-center justify-between px-2 py-2">
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-14 h-14">
                        <i class="fas fa-th-large text-lg {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                        <span class="text-[7px] font-black uppercase mt-1 italic-none {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-400' }}">Home</span>
                    </a>
                    <a href="{{ route('teacher.attendance.index') }}" class="flex flex-col items-center justify-center w-14 h-14">
                        <i class="fas fa-calendar-check text-lg {{ request()->routeIs('teacher.attendance*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                        <span class="text-[7px] font-black uppercase mt-1 italic-none {{ request()->routeIs('teacher.attendance*') ? 'text-blue-600' : 'text-slate-400' }}">Roll</span>
                    </a>
                    <a href="{{ route('teacher.marks.index') }}" class="flex flex-col items-center justify-center">
                        <div class="w-14 h-14 bg-slate-900 rounded-full flex items-center justify-center text-white shadow-xl transform active:scale-95 transition-all -mt-2">
                            <i class="fas fa-plus text-lg"></i>
                        </div>
                        <span class="text-[7px] font-black text-slate-900 uppercase mt-1 italic-none">Marks</span>
                    </a>
                    <a href="{{ route('teacher.assignments.index') }}" class="flex flex-col items-center justify-center w-14 h-14">
                        <i class="fas fa-tasks text-lg {{ request()->routeIs('teacher.assignments*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                        <span class="text-[7px] font-black uppercase mt-1 italic-none {{ request()->routeIs('teacher.assignments*') ? 'text-blue-600' : 'text-slate-400' }}">Tasks</span>
                    </a>
                    <a href="{{ route('teacher.profile.index') }}" class="flex flex-col items-center justify-center w-14 h-14">
                        <i class="fas fa-user-circle text-lg {{ request()->routeIs('teacher.profile*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                        <span class="text-[7px] font-black uppercase mt-1 italic-none {{ request()->routeIs('teacher.profile*') ? 'text-blue-600' : 'text-slate-400' }}">Me</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</body>
</html>