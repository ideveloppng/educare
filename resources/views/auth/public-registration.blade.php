<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Registration | {{ $school->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Force strictly no italics */
        * { font-style: normal !important; }
        
        .page-bg { 
            background-image: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.75)), 
                              url('https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=2132&auto=format&fit=crop'); 
            background-size: cover; background-position: center; background-attachment: fixed;
        }

        .glass-card { 
            background: rgba(255, 255, 255, 0.95); 
            backdrop-filter: blur(12px); 
            -webkit-backdrop-filter: blur(12px); 
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }

        @media (max-width: 1024px) {
            .glass-card { background: white; }
        }
    </style>
</head>
<body class="page-bg min-h-screen flex items-center justify-center p-4 md:p-6">

    <!-- Main Container -->
    <div class="w-full max-w-[450px] lg:max-w-6xl h-auto lg:h-[820px] glass-card rounded-[2.5rem] lg:rounded-[3.5rem] shadow-2xl flex flex-col lg:flex-row overflow-hidden border border-white/20">
        
        <!-- LEFT SIDE: BRANDING (Top on Mobile) -->
        <div class="w-full lg:w-5/12 relative overflow-hidden bg-blue-900 flex-shrink-0">
            <div class="absolute inset-0 bg-blue-900/40 z-0"></div>
            <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=2132&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
            
            <div class="relative z-10 p-8 lg:p-16 flex flex-col justify-between h-full">
                <div>
                    <!-- School Logo/Identity -->
                    <div class="flex items-center space-x-4 mb-10 lg:mb-16">
                        @if($school->logo)
                            <img src="{{ asset('storage/'.$school->logo) }}" class="w-12 h-12 lg:w-16 lg:h-16 rounded-2xl border-2 border-white/20 shadow-2xl object-cover">
                        @else
                            <div class="w-12 h-12 lg:w-16 lg:h-16 bg-white rounded-2xl flex items-center justify-center text-blue-900 shadow-2xl">
                                <i class="fas fa-university text-2xl lg:text-3xl"></i> 
                            </div>
                        @endif
                        <span class="text-white text-xl lg:text-2xl font-black tracking-tighter uppercase leading-tight">{{ $school->name }}</span>
                    </div>
                    
                    <h1 class="text-3xl lg:text-5xl font-black text-white leading-tight uppercase tracking-tighter">Portal <br class="hidden lg:block">Enrollment.</h1>
                    <div class="h-1.5 w-16 bg-blue-500 rounded-full mt-4"></div>
                    <p class="text-blue-200 text-[10px] font-black uppercase tracking-[0.3em] mt-8">{{ $role }} Access Tier</p>
                </div>

                <!-- Footer Card -->
                <div class="bg-white/10 backdrop-blur-xl p-6 lg:p-8 rounded-[2rem] border border-white/10 hidden sm:block">
                    <p class="text-white text-[10px] font-black uppercase tracking-widest">Institutional Registry</p>
                    <p class="text-blue-200 text-[8px] font-medium mt-1 uppercase leading-relaxed">Provide accurate details to verify your identity within the school system.</p>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE: FORM (Scrollable on Desktop) -->
        <div class="w-full lg:w-7/12 bg-white flex flex-col overflow-y-auto no-scrollbar">
            <div class="p-8 lg:p-16">
                <div class="mb-10 lg:mb-12">
                    <h2 class="text-2xl lg:text-3xl font-black text-slate-800 uppercase tracking-tighter">Create Account</h2>
                    <p class="text-slate-400 font-bold uppercase text-[9px] lg:text-[10px] tracking-[0.2em] mt-2 leading-relaxed">
                        Complete the form below to initialize your profile
                    </p>
                </div>

                <form action="{{ route('public.register.store', [$role, $key]) }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ photoPreview: null }">
                    @csrf
                    
                    <!-- Profile Photo Selection -->
                    <div class="flex items-center space-x-6 p-5 bg-slate-50 rounded-[2rem] border border-slate-100">
                        <div class="relative shrink-0">
                            <div class="w-20 h-20 rounded-[1.2rem] bg-white border-2 border-dashed border-slate-200 overflow-hidden flex items-center justify-center relative shadow-sm">
                                <template x-if="photoPreview"><img :src="photoPreview" class="w-full h-full object-cover"></template>
                                <template x-if="!photoPreview"><i class="fas fa-camera text-slate-300 text-xl"></i></template>
                            </div>
                            <label class="absolute -bottom-2 -right-2 w-8 h-8 bg-blue-600 text-white rounded-xl flex items-center justify-center cursor-pointer shadow-lg border-2 border-white hover:scale-110 transition-all">
                                <i class="fas fa-plus text-[10px]"></i>
                                <input type="file" name="photo" class="hidden" accept="image/*" @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result }; reader.readAsDataURL(file); }">
                            </label>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-slate-800 uppercase tracking-widest leading-tight">Profile Identity</p>
                            <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mt-1">Upload a clear passport photo</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Full Name -->
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Legal Name</label>
                            <input type="text" name="name" required placeholder="E.G. ADRIAN STEVE"
                                class="w-full px-6 py-4 lg:py-5 bg-slate-50 border border-slate-100 rounded-2xl font-bold uppercase text-xs outline-none focus:ring-4 focus:ring-blue-500/5 transition-all">
                        </div>

                        <!-- Email -->
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                            <input type="email" name="email" required placeholder="EMAIL@INSTITUTION.COM"
                                class="w-full px-6 py-4 lg:py-5 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-xs outline-none focus:ring-4 focus:ring-blue-500/5 transition-all">
                        </div>

                        @if($role === 'student')
                            <!-- Class Selection -->
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Academic Class</label>
                                <select name="school_class_id" required class="w-full px-6 py-4 lg:py-5 bg-slate-50 border border-slate-100 rounded-2xl font-bold uppercase text-xs outline-none focus:ring-4 focus:ring-blue-500/5 transition-all appearance-none">
                                    <option value="">SELECT CLASS</option>
                                    @foreach($classes as $class) <option value="{{ $class->id }}">{{ $class->full_name }}</option> @endforeach
                                </select>
                            </div>
                            <!-- Birthday -->
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Date of Birth</label>
                                <input type="date" name="date_of_birth" required class="w-full px-6 py-4 lg:py-5 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-xs outline-none focus:ring-4 focus:ring-blue-500/5 transition-all">
                            </div>
                        @else
                            <!-- Phone Number -->
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Phone Number</label>
                                <input type="text" name="phone" required placeholder="+234 ..." class="w-full px-6 py-4 lg:py-5 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-xs outline-none focus:ring-4 focus:ring-blue-500/5 transition-all">
                            </div>
                        @endif

                        <!-- Password -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Security Key</label>
                            <input type="password" name="password" required placeholder="PASSWORD" class="w-full px-6 py-4 lg:py-5 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-xs outline-none focus:ring-4 focus:ring-blue-500/5 transition-all">
                        </div>
                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirm Security</label>
                            <input type="password" name="password_confirmation" required placeholder="RE-TYPE PASSWORD" class="w-full px-6 py-4 lg:py-5 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-xs outline-none focus:ring-4 focus:ring-blue-500/5 transition-all">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6 pb-12 lg:pb-0">
                        <button type="submit" class="w-full py-5 lg:py-6 bg-slate-900 text-white font-black rounded-2xl lg:rounded-3xl shadow-xl shadow-slate-200 hover:bg-blue-600 hover:-translate-y-1 transition-all uppercase tracking-[0.2em] text-xs active:scale-95">
                            Complete Enrollment
                        </button>
                    </div>

                    <!-- Branding Footer -->
                    <div class="mt-10 pt-6 border-t border-slate-50 text-center">
                        <p class="text-[8px] lg:text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] leading-relaxed">
                            Engineered by <span class="text-blue-600">Codecraft Developers Limited</span>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>