<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Set New Password | EduCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .italic-none { font-style: normal !important; }
        .page-bg { 
            background-image: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.75)), 
                              url('https://images.unsplash.com/photo-1523050853064-8521a3030242?q=80&w=2070&auto=format&fit=crop'); 
            background-size: cover; background-position: center; background-attachment: fixed;
        }
        .glass-card { background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
    </style>
</head>
<body class="page-bg min-h-screen flex items-center justify-center p-4 italic-none">

    <div class="w-full max-w-5xl h-auto lg:h-[700px] glass-card md:rounded-[3.5rem] shadow-2xl flex flex-col lg:flex-row overflow-hidden border border-white/20">
        
        <!-- LEFT SIDE -->
        <div class="hidden lg:flex w-5/12 relative overflow-hidden bg-blue-900/40 p-16 flex flex-col justify-center text-center">
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
            <div class="relative z-10">
                <div class="w-20 h-20 bg-white/10 rounded-3xl flex items-center justify-center text-white mx-auto mb-8 border border-white/10 italic-none">
                    <i class="fas fa-lock-open text-3xl"></i>
                </div>
                <h1 class="text-4xl font-black text-white uppercase tracking-tighter leading-tight italic-none">Update <br>Credentials.</h1>
                <p class="text-blue-200 mt-4 text-[10px] font-black uppercase tracking-widest italic-none">Step 2 of Security Protocol</p>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="w-full lg:w-7/12 h-full bg-white flex flex-col justify-center">
            <div class="p-8 md:p-16">
                <div class="mb-10">
                    <h2 class="text-3xl font-black text-slate-800 uppercase tracking-tighter italic-none">Reset Password</h2>
                    <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.2em] mt-2">Establish your new institutional access key</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf
                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $request->email) }}" required 
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-blue-500/5 transition-all italic-none shadow-sm">
                        @error('email') <p class="text-[9px] font-black text-red-500 uppercase tracking-widest mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">New Password</label>
                        <input type="password" name="password" required 
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-blue-500/5 transition-all italic-none shadow-sm">
                        @error('password') <p class="text-[9px] font-black text-red-500 uppercase tracking-widest mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" required 
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold text-sm outline-none focus:ring-4 focus:ring-blue-500/5 transition-all italic-none shadow-sm">
                    </div>

                    <button type="submit" class="w-full py-6 bg-blue-600 text-white font-black rounded-3xl shadow-xl shadow-blue-100 hover:bg-blue-700 hover:-translate-y-1 transition-all uppercase tracking-widest text-xs italic-none mt-4">
                        Reset & Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>