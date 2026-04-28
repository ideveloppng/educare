<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Institutional Onboarding | EduCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .italic-none { font-style: normal !important; }
        .page-bg { 
            background-image: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.75)), 
                              url('https://images.unsplash.com/photo-1523050853064-8521a3030242?q=80&w=2070&auto=format&fit=crop'); 
            background-size: cover; background-position: center; background-attachment: fixed;
        }
        .glass-card { background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="page-bg min-h-screen flex items-center justify-center p-4 md:p-6 italic-none">

    <!-- MAIN CONTAINER -->
    <div class="w-full max-w-5xl h-auto lg:h-[820px] glass-card md:rounded-[3.5rem] shadow-2xl flex flex-col lg:flex-row overflow-hidden border border-white/20">
        
        <!-- LEFT SIDE: BRANDING -->
        <div class="hidden lg:flex w-5/12 relative overflow-hidden bg-blue-900/40 p-12 flex flex-col justify-between h-full">
            <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=2132&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
            
            <div class="relative z-10">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-blue-900 shadow-2xl mb-8">
                    <i class="fas fa-graduation-cap text-3xl"></i>
                </div>
                <h1 class="text-4xl font-black text-white leading-tight uppercase tracking-tighter italic-none">
                    Start Your <br>Digital Journey.
                </h1>
                <div class="h-1.5 w-16 bg-blue-500 rounded-full mt-4"></div>
                <p class="text-blue-100 text-sm font-bold uppercase tracking-widest mt-6 italic-none">Institutional Onboarding Terminal</p>
            </div>

            <div class="relative z-10 space-y-4">
                <div class="bg-white/10 backdrop-blur-xl p-6 rounded-[2rem] border border-white/10 shadow-xl">
                    <p class="text-white text-[10px] font-black uppercase tracking-widest">Powered by</p>
                    <p class="text-blue-200 text-xs font-bold uppercase tracking-widest mt-1">Codecraft Developers Ltd</p>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE: FORM -->
        <div class="w-full lg:w-7/12 h-full bg-white overflow-y-auto no-scrollbar flex flex-col">
            <div class="p-8 md:p-14">
                <div class="mb-10 text-center lg:text-left">
                    <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tighter">Register School</h2>
                    <p class="text-slate-400 font-bold uppercase text-[9px] tracking-[0.2em] mt-2">Establish your school's secure digital portal</p>
                </div>

                <form action="{{ route('public.school.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ photoPreview: null }">
                    @csrf
                    
                    <!-- SECTION 1: SCHOOL INFO -->
                    <div class="space-y-6">
                        <h4 class="text-[10px] font-black text-blue-600 uppercase tracking-widest italic-none flex items-center">
                            <span class="w-8 h-px bg-blue-100 mr-2"></span> 01. Institution Data
                        </h4>
                        
                        <div class="space-y-4">
                            <div class="relative group">
                                <i class="fas fa-university absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                                <input type="text" name="school_name" required placeholder="OFFICIAL SCHOOL NAME" class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold uppercase text-xs focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all italic-none shadow-sm">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="relative group">
                                    <i class="fas fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                                    <input type="email" name="school_email" required placeholder="OFFICIAL EMAIL" class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-xs focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all italic-none shadow-sm">
                                </div>
                                <div class="relative group">
                                    <i class="fas fa-phone-alt absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 text-xs"></i>
                                    <input type="text" name="school_phone" required placeholder="CONTACT PHONE" class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-xs focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all italic-none shadow-sm">
                                </div>
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
                            <div>
                                <p class="text-[10px] font-black text-slate-800 uppercase tracking-widest leading-none">Institutional Logo</p>
                                <p class="text-[8px] font-bold text-slate-400 uppercase mt-1 italic-none">PNG/JPG (MAX 2MB)</p>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: ADMIN ACCOUNT -->
                    <div class="space-y-6">
                        <h4 class="text-[10px] font-black text-emerald-600 uppercase tracking-widest italic-none flex items-center">
                            <span class="w-8 h-px bg-emerald-100 mr-2"></span> 02. Master Admin
                        </h4>
                        
                        <div class="grid grid-cols-1 gap-4">
                            <input type="text" name="admin_name" required placeholder="ADMINISTRATOR FULL NAME" class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold uppercase text-xs focus:ring-4 focus:ring-emerald-500/5 outline-none shadow-sm">
                            <input type="email" name="admin_email" required placeholder="ADMIN LOGIN EMAIL" class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold text-xs focus:ring-4 focus:ring-emerald-500/5 outline-none shadow-sm">
                            
                            <div class="grid grid-cols-2 gap-4">
                                <input type="password" name="password" required placeholder="PASSWORD" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-xs outline-none">
                                <input type="password" name="password_confirmation" required placeholder="CONFIRM" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-xs outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="pt-4 pb-10">
                        <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 hover:-translate-y-1 transition-all active:scale-95 uppercase tracking-widest text-[10px] italic-none">
                            Finalize & Start 30-Day Trial
                        </button>
                        
                        <div class="mt-8 text-center border-t border-slate-50 pt-6">
                            <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.2em] italic-none mb-1">
                                Engineered by <span class="text-blue-600">Codecraft Developers Limited</span>
                            </p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                Already have an account? <a href="{{ route('login') }}" class="text-blue-600 underline">Sign In</a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>