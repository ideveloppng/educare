<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>EduCare | Simple & Powerful School Management</title>
    
    <!-- Fonts & Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Institutional Standard: No Italics */
        * { font-style: normal !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .hero-bg {
            background-image: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.8)), 
                              url('https://plus.unsplash.com/premium_photo-1661661139398-9f360bea5b48?q=80&w=1471&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover; background-position: center;
        }

        /* Pricing Section Background */
        .pricing-bg {
            background-image: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.95)), 
                              url('https://images.unsplash.com/photo-1636202339022-7d67f7447e3a?q=80&w=1471&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover; background-position: center; background-attachment: fixed;
        }
    </style>
</head>
<body class="bg-white font-sans antialiased text-slate-900">

    <!-- 1. NAVIGATION -->
    <nav x-data="{ mobileMenu: false }" class="fixed top-0 left-0 right-0 z-[100] px-4 md:px-8 py-6">
        <div class="max-w-7xl mx-auto glass-nav rounded-[2.5rem] border border-white/50 shadow-2xl px-6 md:px-10 py-4 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center space-x-3">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <span class="font-black text-xl tracking-tighter uppercase text-slate-800">EduCare</span>
            </div>
            </a>

            <div class="hidden lg:flex items-center space-x-10 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">
                <a href="#features" class="hover:text-blue-600 transition-all">What's Inside</a>
                <a href="#how-it-works" class="hover:text-blue-600 transition-all">How to Start</a>
                <a href="#pricing" class="hover:text-blue-600 transition-all">Pricing</a>
                <a href="{{ route('public.support') }}" class="hover:text-blue-600 transition-all">Contact Us</a>
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
            <a href="#features" @click="mobileMenu = false" class="text-xs font-black uppercase tracking-widest">Features</a>
            <a href="#how-it-works" @click="mobileMenu = false" class="text-xs font-black uppercase tracking-widest">How to Start</a>
            <a href="#pricing" @click="mobileMenu = false" class="text-xs font-black uppercase tracking-widest">Pricing</a>
            <a href="{{ route('public.support') }}" @click="mobileMenu = false" class="text-xs font-black uppercase tracking-widest">Contact Us</a>
            <a href="{{ route('login') }}" class="w-full py-5 bg-blue-600 text-white text-center font-black rounded-2xl text-[10px] uppercase tracking-widest">Login to Portal</a>
        </div>
    </nav>

    <!-- 2. HERO SECTION -->
    <section class="min-h-screen flex items-center justify-center hero-bg px-6 relative overflow-hidden">
        <div class="max-w-4xl mx-auto text-center relative z-10 pt-20">
            <div class="inline-flex items-center px-5 py-2 bg-blue-600 rounded-full mb-8 shadow-xl shadow-blue-900/40">
                <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse mr-3"></span>
                <p class="text-[9px] font-black text-white uppercase tracking-[0.3em]">Institutional Grade Platform</p>
            </div>
            <h1 class="text-5xl md:text-8xl font-black text-white leading-[0.95] uppercase tracking-tighter mb-8">
                Smart Management <br>For Your <span class="text-blue-500">School.</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-300 font-medium leading-relaxed mb-12 max-w-2xl mx-auto">
                Everything you need to manage results, student fees, and teachers in one easy-to-use portal. Made for modern schools.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="{{ route('public.school.register') }}" class="w-full sm:w-auto px-16 py-7 bg-blue-600 text-white font-black rounded-3xl shadow-2xl shadow-blue-900/50 hover:bg-blue-500 hover:-translate-y-2 transition-all active:scale-95 uppercase tracking-widest text-xs">
                    Start 30-Day Free Trial
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-16 py-7 bg-white/10 backdrop-blur-md border border-white/20 text-white font-black rounded-3xl hover:bg-white hover:text-blue-900 transition-all uppercase tracking-widest text-xs">
                    Portal Login
                </a>
            </div>
        </div>
    </section>

    <!-- 3. HOW IT WORKS (REDESIGNED) -->
    <section id="how-it-works" class="py-32 px-6 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-24 gap-6">
                <div class="max-w-2xl">
                    <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.4em] mb-4">Implementation</h4>
                    <h2 class="text-5xl md:text-7xl font-black text-slate-900 uppercase tracking-tighter leading-none">Simplified <br>Onboarding.</h2>
                </div>
                <p class="text-slate-400 font-bold uppercase text-[10px] tracking-widest mb-4">Zero Technical Complexity</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <!-- Step 1 -->
                <div class="step-card group relative p-12 bg-slate-50 rounded-[3rem] border border-slate-100 transition-all hover:bg-white hover:shadow-2xl">
                    <span class="step-number absolute -top-10 right-10 text-[10rem] font-black text-slate-900/5 transition-all duration-500">01</span>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-blue-600 text-white rounded-2xl flex items-center justify-center text-xl mb-10 shadow-xl shadow-blue-200">
                            <i class="fas fa-school"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 uppercase mb-4">Identity Setup</h3>
                        <p class="text-slate-500 font-medium leading-relaxed text-sm">Register your institution, upload your crest, and define your academic hierarchy in minutes.</p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="step-card group relative p-12 bg-slate-50 rounded-[3rem] border border-slate-100 transition-all hover:bg-white hover:shadow-2xl">
                    <span class="step-number absolute -top-10 right-10 text-[10rem] font-black text-slate-900/5 transition-all duration-500">02</span>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-emerald-600 text-white rounded-2xl flex items-center justify-center text-xl mb-10 shadow-xl shadow-emerald-200">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 uppercase mb-4">Data Ingestion</h3>
                        <p class="text-slate-500 font-medium leading-relaxed text-sm">Import your student registries and teacher workloads. Our system maps everything automatically.</p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="step-card group relative p-12 bg-slate-50 rounded-[3rem] border border-slate-100 transition-all hover:bg-white hover:shadow-2xl">
                    <span class="step-number absolute -top-10 right-10 text-[10rem] font-black text-slate-900/5 transition-all duration-500">03</span>
                    <div class="relative z-10">
                        <div class="w-16 h-16 bg-orange-600 text-white rounded-2xl flex items-center justify-center text-xl mb-10 shadow-xl shadow-orange-200">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 uppercase mb-4">Live Operations</h3>
                        <p class="text-slate-500 font-medium leading-relaxed text-sm">Activate portals for parents and students. Start processing fees and automated results immediately.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. CORE FEATURES -->
    <section id="features" class="py-32 px-6 bg-slate-50 rounded-[4rem] mx-4 md:mx-10">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div>
                <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.4em] mb-4">Features</h4>
                <h2 class="text-5xl font-black text-slate-900 uppercase tracking-tighter mb-8 leading-[1.1]">Built to make life <br>easier for everyone.</h2>
                <div class="space-y-8">
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-lg mr-6 shrink-0">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-slate-800 uppercase">Easy Results & Report Cards</h4>
                            <p class="text-xs text-slate-500 mt-1 font-medium">Teachers enter marks and students can check results using scratch cards.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-emerald-600 shadow-lg mr-6 shrink-0">
                            <i class="fas fa-naira-sign"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-slate-800 uppercase">Fee Payment & Tracking</h4>
                            <p class="text-xs text-slate-500 mt-1 font-medium">Parents can view bills and upload payment receipts directly in the portal.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-orange-600 shadow-lg mr-6 shrink-0">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-slate-800 uppercase">Announcements</h4>
                            <p class="text-xs text-slate-500 mt-1 font-medium">Send important messages to parents and staff instantly via the notice board.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-slate-900 rounded-[3.5rem] p-12 text-white relative overflow-hidden shadow-2xl">
                <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-10">Real-time Dashboard</p>
                <div class="space-y-6">
                    <div class="h-12 w-full bg-white/5 rounded-2xl border border-white/10 flex items-center px-6">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full mr-4"></div>
                        <div class="h-2 w-32 bg-white/20 rounded-full"></div>
                    </div>
                    <div class="h-12 w-3/4 bg-white/5 rounded-2xl border border-white/10 flex items-center px-6">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-4"></div>
                        <div class="h-2 w-24 bg-white/20 rounded-full"></div>
                    </div>
                    <div class="h-32 w-full bg-blue-600 rounded-[2.5rem] p-8 mt-10 shadow-2xl shadow-blue-600/30">
                        <p class="text-xs font-black uppercase mb-2">School Balance</p>
                        <h4 class="text-3xl font-black tracking-tighter">₦8.4M</h4>
                    </div>
                </div>
                <i class="fas fa-shield-halved absolute -bottom-10 -right-10 text-[180px] opacity-10"></i>
            </div>
        </div>
    </section>

    <!-- 5. PRICING (REDESIGNED WITH BG IMAGE) -->
    <section id="pricing" class="py-32 px-6 pricing-bg rounded-[4rem] my-10 mx-4 md:mx-10 relative">
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-20">
                <h4 class="text-[10px] font-black text-blue-400 uppercase tracking-[0.4em] mb-4">Pricing</h4>
                <h2 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tighter">Standard School Plans</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($plans as $plan)
                <div class="bg-white/10 backdrop-blur-xl p-10 rounded-[3rem] border border-white/10 flex flex-col items-center text-center transition-all hover:bg-white group">
                    <h3 class="text-xl font-black text-white group-hover:text-slate-800 uppercase mb-6">{{ $plan->name }}</h3>
                    <div class="mb-10">
                        <span class="text-4xl font-black text-white group-hover:text-blue-600 tracking-tighter">₦{{ number_format($plan->price, 0) }}</span>
                    </div>
                    <a href="{{ route('public.school.register') }}" class="w-full py-4 bg-blue-600 text-white font-black rounded-2xl text-[10px] uppercase tracking-widest hover:bg-slate-900 transition-all shadow-lg">Select Plan</a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 6. NEW CONTACT SECTION -->
    <section id="contact" class="py-32 px-6 bg-white">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-20">
            <div>
                <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-[0.4em] mb-4">Contact Us</h4>
                <h2 class="text-5xl font-black text-slate-900 uppercase tracking-tighter mb-10 leading-none">Get In Touch <br>With Our Team.</h2>
                <p class="text-slate-500 font-medium leading-relaxed mb-12 max-w-md">Have questions about setting up your school? Our technical support team is ready to assist you.</p>
                
                <div class="space-y-6">
                    <div class="flex items-center space-x-6">
                        <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-blue-600 border border-slate-100 shadow-sm"><i class="fas fa-phone"></i></div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Call Us</p>
                            <p class="text-lg font-black text-slate-800 uppercase">+234 (0) 123 456 789</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-blue-600 border border-slate-100 shadow-sm"><i class="fas fa-envelope"></i></div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Email Us</p>
                            <p class="text-lg font-black text-slate-800 uppercase">support@educare.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-50 p-10 md:p-14 rounded-[3.5rem] border border-slate-100 shadow-inner">
                <form action="#" method="POST" class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Your Name</label>
                        <input type="text" name="name" required class="w-full px-6 py-4 bg-white border border-slate-100 rounded-2xl font-bold text-xs uppercase outline-none focus:ring-4 focus:ring-blue-500/5 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                        <input type="email" name="email" required class="w-full px-6 py-4 bg-white border border-slate-100 rounded-2xl font-bold text-xs outline-none focus:ring-4 focus:ring-blue-500/5 transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Message</label>
                        <textarea rows="4" name="message" required class="w-full px-6 py-4 bg-white border border-slate-100 rounded-2xl font-bold text-xs outline-none focus:ring-4 focus:ring-blue-500/5 transition-all"></textarea>
                    </div>
                    <button type="submit" class="w-full py-6 bg-blue-600 text-white font-black rounded-2xl uppercase tracking-widest text-[10px] shadow-xl hover:bg-slate-900 transition-all">
                        Send Inquiry
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- 7. FINAL CTA -->
    <section class="py-20 px-6">
        <div class="max-w-5xl mx-auto bg-blue-600 rounded-[4rem] p-12 md:p-24 text-center text-white shadow-[0_50px_100px_rgba(37,99,235,0.4)] relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-4xl md:text-6xl font-black uppercase tracking-tighter leading-tight mb-8">Ready to transform <br>your school?</h2>
                <a href="{{ route('public.school.register') }}" class="inline-block px-16 py-6 bg-white text-blue-600 font-black rounded-[2rem] shadow-2xl hover:scale-105 transition-all uppercase tracking-widest text-xs">Start Your Free Trial Now</a>
            </div>
            <i class="fas fa-graduation-cap absolute -bottom-10 -left-10 text-[200px] opacity-10"></i>
        </div>
    </section>

    <!-- 8. FOOTER -->
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