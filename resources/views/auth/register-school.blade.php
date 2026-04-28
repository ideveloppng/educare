<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Institutional Onboarding | EduCare</title>
    
    <!-- Fonts & Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .italic-none { font-style: normal !important; }
        
        .page-bg { 
            background-image: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.75)), 
                              url('https://images.unsplash.com/photo-1523050853064-8521a3030242?q=80&w=2070&auto=format&fit=crop'); 
            background-size: cover; 
            background-position: center;
            background-attachment: fixed;
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        @media (max-width: 1024px) {
            .glass-card { background: white; }
        }
    </style>
</head>
<body class="page-bg min-h-screen flex items-center justify-center p-4 md:p-6 italic-none">

    <!-- MAIN CONTAINER: Responsive flex-col for mobile, flex-row for desktop -->
    <div class="w-full max-w-[450px] lg:max-w-6xl h-auto lg:h-[800px] glass-card rounded-[2.5rem] lg:rounded-[4rem] shadow-2xl flex flex-col lg:flex-row overflow-hidden border border-white/20">
        
        <!-- LEFT SIDE: BRANDING (Top on mobile, Left on desktop) -->
        <div class="w-full lg:w-5/12 relative overflow-hidden bg-blue-900 flex-shrink-0">
            <!-- Background Image Overlay -->
            <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=2132&auto=format&fit=crop" 
                 class="absolute inset-0 w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-blue-900/60 lg:bg-blue-900/40"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
            
            <div class="relative z-10 p-8 lg:p-12 flex flex-col justify-between h-full">
                <div>
                    <!-- Logo & EduCare Title -->
                    <div class="flex items-center space-x-4 mb-8 lg:mb-24">
                        <div class="w-12 h-12 lg:w-16 lg:h-16 bg-white rounded-2xl flex items-center justify-center text-blue-900 shadow-2xl">
                            <i class="fas fa-graduation-cap text-2xl lg:text-3xl"></i> 
                        </div>
                        <span class="text-white text-3xl lg:text-5xl font-black tracking-tighter italic-none">EduCare</span>
                    </div>

                    <h1 class="text-3xl lg:text-4xl font-black text-white leading-tight uppercase tracking-tighter italic-none">
                        Start Your <br class="hidden lg:block">Digital Journey.
                    </h1>
                    <div class="h-1.5 w-16 bg-blue-500 rounded-full mt-4"></div>
                    <p class="text-blue-100 text-xs lg:text-sm font-bold uppercase tracking-widest mt-6 italic-none">Institutional Onboarding Terminal</p>
                </div>

                <!-- Footer Info (Hidden on very small mobile) -->
                <div class="mt-10 lg:mt-0 bg-white/10 backdrop-blur-xl p-6 lg:p-8 rounded-[2rem] border border-white/10 hidden sm:block">
                    <p class="text-white text-[10px] lg:text-xs font-black uppercase tracking-widest italic-none">Institutional Access</p>
                    <p class="text-blue-200 text-[8px] lg:text-[10px] font-medium mt-1 uppercase italic-none">30-Day Free Trial Included</p>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE: FORM -->
        <div class="w-full lg:w-7/12 h-full bg-white overflow-y-auto no-scrollbar flex flex-col">
            <div class="p-8 lg:p-14">
                <div class="mb-10 text-center lg:text-left">
                    <h2 class="text-2xl lg:text-3xl font-black text-slate-900 uppercase tracking-tighter italic-none">Register School</h2>
                    <p class="text-slate-400 font-bold uppercase text-[9px] lg:text-[10px] tracking-[0.2em] mt-2 italic-none">Establish your school's secure digital portal</p>
                </div>

                <form action="{{ route('public.school.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ photoPreview: null }">
                    @csrf
                    
                    <!-- SECTION 1: SCHOOL INFO -->
                    <div class="space-y-6">
                        <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-widest italic-none flex items-center">
                            <span class="w-8 h-px bg-blue-100 mr-2"></span> 01. Institution Data
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative group md:col-span-2">
                                <i class="fas fa-university absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                                <input type="text" name="school_name" required placeholder="OFFICIAL SCHOOL NAME" class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-black uppercase text-xs focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all italic-none shadow-sm">
                            </div>

                            <div class="relative group">
                                <i class="fas fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                                <input type="email" name="school_email" required placeholder="OFFICIAL EMAIL" class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-xs focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all italic-none shadow-sm">
                            </div>
                            <div class="relative group">
                                <i class="fas fa-phone-alt absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                                <input type="text" name="school_phone" required placeholder="CONTACT PHONE" class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-xs focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all italic-none shadow-sm">
                            </div>
                        </div>

                        <!-- Compact Logo Widget -->
                        <div class="flex items-center space-x-6 p-4 bg-slate-50 rounded-2xl border border-slate-100 italic-none">
                            <div class="relative shrink-0">
                                <div class="w-16 h-16 rounded-xl bg-white border-2 border-dashed border-slate-200 overflow-hidden flex items-center justify-center relative shadow-sm">
                                    <template x-if="photoPreview"><img :src="photoPreview" class="w-full h-full object-cover"></template>
                                    <template x-if="!photoPreview"><i class="fas fa-image text-slate-300"></i></template>
                                </div>
                                <label class="absolute -bottom-1 -right-1 w-7 h-7 bg-blue-600 text-white rounded-lg flex items-center justify-center cursor-pointer shadow-lg border-2 border-white hover:scale-110 transition-all">
                                    <i class="fas fa-camera text-[8px]"></i>
                                    <input type="file" name="logo" class="hidden" accept="image/*" @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result }; reader.readAsDataURL(file); }">
                                </label>
                            </div>
                            <div class="leading-tight">
                                <p class="text-[10px] font-black text-slate-800 uppercase tracking-widest">School Logo</p>
                                <p class="text-[8px] font-bold text-slate-400 uppercase mt-1">PNG, JPG (MAX 2MB)</p>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: ADMIN ACCOUNT -->
                    <div class="space-y-6">
                        <h4 class="text-[10px] font-black text-emerald-600 uppercase tracking-widest italic-none flex items-center">
                            <span class="w-8 h-px bg-emerald-100 mr-2"></span> 02. Master Admin
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative group md:col-span-2">
                                <i class="fas fa-user-shield absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                                <input type="text" name="admin_name" required placeholder="ADMINISTRATOR FULL NAME" class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-black uppercase text-xs focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 outline-none transition-all italic-none shadow-sm">
                            </div>

                            <div class="relative group md:col-span-2">
                                <i class="fas fa-at absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                                <input type="email" name="admin_email" required placeholder="ADMIN LOGIN EMAIL" class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold text-xs focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 outline-none transition-all italic-none shadow-sm">
                            </div>
                            
                            <input type="password" name="password" required placeholder="PASSWORD" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-xs focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 outline-none transition-all italic-none">
                            <input type="password" name="password_confirmation" required placeholder="CONFIRM" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-xs focus:ring-4 focus:ring-emerald-500/5 focus:border-emerald-500 outline-none transition-all italic-none">
                        </div>
                    </div>

                    <!-- Submit Area -->
                    <div class="pt-4 pb-10">
                        <button type="submit" class="w-full py-5 lg:py-6 bg-blue-600 text-white font-black rounded-2xl lg:rounded-3xl shadow-xl shadow-blue-100 hover:bg-blue-700 hover:-translate-y-1 transition-all active:scale-95 uppercase tracking-widest text-[10px] lg:text-xs italic-none">
                            Finalize & Start 30-Day Trial
                        </button>
                        
                        <div class="mt-8 text-center border-t border-slate-50 pt-6">
                            <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] italic-none mb-4 leading-relaxed">
                                Engineered by <br class="lg:hidden"> <span class="text-blue-600">Codecraft Developers Limited</span>
                            </p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic-none">
                                Already registered? <a href="{{ route('login') }}" class="text-blue-600 underline font-black">Sign In</a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>