<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Access Recovery | EduCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .italic-none { font-style: normal !important; }
        .page-bg { 
            background-image: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.75)), 
                              url('https://images.unsplash.com/photo-1577874452589-d095263972e4?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); 
            background-size: cover; background-position: center; background-attachment: fixed;
        }
        .glass-card { background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
    </style>
</head>
<body class="page-bg min-h-screen flex items-center justify-center p-4 md:p-6 italic-none">

    <div class="w-full max-w-5xl h-auto lg:h-[600px] glass-card md:rounded-[3.5rem] shadow-2xl flex flex-col lg:flex-row overflow-hidden border border-white/20">
        
        <!-- LEFT SIDE: BRANDING -->
        <div class="hidden lg:flex w-5/12 relative overflow-hidden bg-blue-900/40 p-16 flex flex-col justify-center text-center">
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
            <div class="relative z-10">
                <div class="w-20 h-20 bg-white/10 rounded-3xl flex items-center justify-center text-white mx-auto mb-8 border border-white/10 italic-none">
                    <i class="fas fa-shield-alt text-3xl"></i>
                </div>
                <h1 class="text-4xl font-black text-white uppercase tracking-tighter leading-tight italic-none">Access <br>Recovery.</h1>
                <p class="text-blue-200 mt-4 text-xs font-bold uppercase tracking-widest italic-none">Secure Identity Verification</p>
            </div>
        </div>

        <!-- RIGHT SIDE: FORM -->
        <div class="w-full lg:w-7/12 h-full bg-white flex flex-col justify-center">
            <div class="p-8 md:p-16">
                <div class="mb-10">
                    <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tighter italic-none">Forgot Password?</h2>
                    <p class="text-slate-400 font-bold uppercase text-[9px] tracking-[0.2em] mt-3 leading-relaxed">
                        No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center">
                        <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                        <p class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">{{ session('status') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-8">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Registered Email Address</label>
                        <div class="relative group">
                            <i class="fas fa-envelope absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus 
                                class="w-full pl-14 pr-6 py-5 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-blue-500/5 transition-all italic-none shadow-sm">
                        </div>
                        @error('email')
                            <p class="text-[9px] font-black text-red-500 uppercase tracking-widest mt-2 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full py-6 bg-blue-600 text-white font-black rounded-3xl shadow-xl shadow-blue-100 hover:bg-blue-700 hover:-translate-y-1 transition-all uppercase tracking-widest text-xs italic-none">
                        Email Reset Link
                    </button>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline italic-none">
                            Return to Sign In
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>