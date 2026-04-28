<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Login | EduCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .italic-none { font-style: normal !important; }
        .page-bg { 
            background-image: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.75)), 
                              url('https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=2132&auto=format&fit=crop'); 
            background-size: cover; background-position: center; background-attachment: fixed;
        }
        /* Refined Glassmorphism */
        .glass-card { 
            background: rgba(255, 255, 255, 0.95); 
            backdrop-filter: blur(12px); 
            -webkit-backdrop-filter: blur(12px); 
        }
        @media (max-width: 1024px) {
            .glass-card {
                background: white; /* More solid on mobile for better readability */
            }
        }
    </style>
</head>
<body class="page-bg min-h-screen flex items-center justify-center p-4 md:p-6 italic-none">

    <!-- Responsive Container: Max width on desktop, grows vertically on mobile -->
    <div class="w-full max-w-[450px] lg:max-w-5xl h-auto lg:h-[680px] glass-card rounded-[2.5rem] lg:rounded-[3.5rem] shadow-2xl flex flex-col lg:flex-row overflow-hidden border border-white/20">
        
        <!-- BRANDING SECTION (Top on Mobile, Left on Desktop) -->
        <div class="w-full lg:w-5/12 relative overflow-hidden bg-blue-900 flex-shrink-0">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 bg-blue-900/60 lg:bg-blue-900/40 z-0"></div>
            <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=2132&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
            
            <div class="relative z-10 p-8 lg:p-16 flex flex-col justify-between h-full">
                <div class="mb-10 lg:mb-0">
                    <!-- Logo & Title -->
                    <div class="flex items-center space-x-4 mb-12 lg:mb-24">
                        <div class="w-12 h-12 lg:w-16 lg:h-16 bg-white rounded-2xl flex items-center justify-center text-blue-900 shadow-2xl">
                            <i class="fas fa-graduation-cap text-2xl lg:text-3xl"></i> 
                        </div>
                        <span class="text-white text-3xl lg:text-5xl font-black tracking-tighter italic-none">EduCare</span>
                    </div>
                    
                    <h1 class="text-4xl lg:text-5xl font-black text-white leading-tight uppercase tracking-tighter italic-none">Welcome <br class="hidden lg:block">Back.</h1>
                    <div class="h-1.5 w-16 bg-blue-500 rounded-full mt-4"></div>
                </div>

                <!-- Footer Info (Only shows on larger screens or as a small tag on mobile) -->
                <div class="bg-white/10 backdrop-blur-xl p-6 lg:p-8 rounded-[2rem] border border-white/10 hidden sm:block">
                    <p class="text-white text-[10px] lg:text-xs font-black uppercase tracking-widest italic-none">Secure Access Terminal</p>
                    <p class="text-blue-200 text-[8px] lg:text-[10px] font-medium mt-1 uppercase italic-none">Institutional authentication required</p>
                </div>
            </div>
        </div>

        <!-- LOGIN FORM SECTION (Bottom on Mobile, Right on Desktop) -->
        <div class="w-full lg:w-7/12 bg-white flex flex-col justify-center">
            <div class="p-8 lg:p-16">
                <div class="mb-8 lg:mb-12">
                    <h2 class="text-2xl lg:text-3xl font-black text-slate-800 uppercase tracking-tighter italic-none">Portal Login</h2>
                    <p class="text-slate-400 font-bold uppercase text-[9px] lg:text-[10px] tracking-[0.2em] mt-2 italic-none leading-relaxed">
                        Enter your credentials to access your institutional dashboard
                    </p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div class="space-y-5">
                        <!-- Email Input -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus 
                                class="w-full px-6 py-4 lg:py-5 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-blue-500/5 transition-all italic-none"
                                placeholder="name@school.com">
                        </div>

                        <!-- Password Input -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center ml-1">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic-none">Password</label>
                                <a href="{{ route('password.request') }}" class="text-[9px] font-black text-blue-600 uppercase tracking-widest hover:underline italic-none">Forgot?</a>
                            </div>
                            <input type="password" name="password" required 
                                class="w-full px-6 py-4 lg:py-5 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-blue-500/5 transition-all italic-none"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-0">
                        <span class="ml-3 text-[10px] font-black text-slate-400 uppercase tracking-widest italic-none">Keep me signed in</span>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-5 lg:py-6 bg-blue-600 text-white font-black rounded-2xl lg:rounded-3xl shadow-xl shadow-blue-100 hover:bg-blue-700 hover:-translate-y-1 transition-all uppercase tracking-widest text-xs italic-none active:scale-95">
                        Authorize Entry
                    </button>

                    <!-- Branding Footer -->
                    <div class="mt-10 pt-6 border-t border-slate-50 text-center">
                        <p class="text-[8px] lg:text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] italic-none leading-relaxed">
                            Engineered by <span class="text-blue-600">Codecraft Developers Limited</span>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>