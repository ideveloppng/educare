<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>{{ $title ?? 'EduCare' }} | Institutional Grade Management</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        * { font-style: normal !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .glass-nav { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
    </style>
</head>
<body class="bg-white antialiased text-slate-900">

    <!-- NAVIGATION (From Welcome Page) -->
    <nav x-data="{ mobileMenu: false }" class="fixed top-0 left-0 right-0 z-[100] px-4 md:px-8 py-6">
        <div class="max-w-7xl mx-auto glass-nav rounded-[2.5rem] border border-white/50 shadow-2xl px-6 md:px-10 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="/" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <span class="font-black text-xl tracking-tighter uppercase text-slate-800">EduCare</span>
                </a>
            </div>

            <!-- Links point to main page anchors if on subpages -->
            <div class="hidden lg:flex items-center space-x-10 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">
                <a href="{{ url('/') }}#features" class="hover:text-blue-600 transition-all">What's Inside</a>
                <a href="{{ url('/') }}#how-it-works" class="hover:text-blue-600 transition-all">How to Start</a>
                <a href="{{ url('/') }}#pricing" class="hover:text-blue-600 transition-all">Pricing</a>
                <a href="{{ route('public.support') }}" class="text-blue-600">Support</a>
            </div>

            <div class="hidden lg:block">
                <a href="{{ route('login') }}" class="px-8 py-3 bg-blue-600 text-white font-black rounded-xl text-[10px] uppercase tracking-widest shadow-xl hover:bg-blue-700 transition-all">
                    Login to Portal
                </a>
            </div>

            <button @click="mobileMenu = !mobileMenu" class="lg:hidden text-slate-800 text-xl"><i class="fas fa-bars-staggered"></i></button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenu" x-cloak class="lg:hidden mt-4 bg-white rounded-[2.5rem] shadow-2xl p-8 space-y-6 flex flex-col border border-slate-100">
            <a href="{{ url('/') }}#features" @click="mobileMenu = false" class="text-xs font-black  tracking-widest">What's Inside</a>
            <a href="{{ url('/') }}#how-it-works" @click="mobileMenu = false" class="text-xs font-black  tracking-widest">How to Start</a>
            <a href="{{ url('/') }}#pricing" @click="mobileMenu = false" class="text-xs font-black  tracking-widest">Pricing</a>
            <a href="{{ route('public.support') }}" @click="mobileMenu = false" class="text-xs font-black  tracking-widest">Support</a>
            <a href="{{ route('login') }}" @click="mobileMenu = false" class="w-full py-5 bg-blue-600 text-white text-center font-black rounded-2xl text-[10px] uppercase tracking-widest">Login to Portal</a>
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <main class="pt-32">
        @yield('content')
    </main>

    <!-- FOOTER (From Welcome Page) -->
    <footer class="py-20 px-6 bg-white border-t border-slate-100 text-center">
        <div class="max-w-7xl mx-auto">
            <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-8"><i class="fas fa-graduation-cap"></i></div>
            <h3 class="text-2xl font-black text-slate-800 uppercase tracking-tighter mb-2">EduCare</h3>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-10">Advanced Multi-Tenant Educational Terminal</p>
            
            <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] mb-2">Developed & Managed by</p>
            <p class="text-sm font-black text-blue-600 uppercase">Codecraft Developers Limited</p>
            
            <div class="mt-16 flex justify-center space-x-10 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                <a href="{{ route('public.support') }}" class="hover:text-slate-800 transition-all">Support</a>
                <a href="{{ route('public.privacy') }}" class="hover:text-slate-800 transition-all">Privacy</a>
                <a href="{{ route('public.terms') }}" class="hover:text-slate-800 transition-all">Terms</a>
            </div>
        </div>
    </footer>

</body>
</html>