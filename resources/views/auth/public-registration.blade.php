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

    <div class="w-full max-w-5xl h-auto lg:h-[780px] glass-card md:rounded-[3.5rem] shadow-2xl flex flex-col lg:flex-row overflow-hidden border border-white/20">
        
        <!-- LEFT SIDE -->
        <div class="hidden lg:flex w-5/12 relative overflow-hidden bg-blue-900/40">
            <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=2132&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900 via-transparent to-transparent"></div>
            <div class="relative z-10 p-12 flex flex-col justify-between h-full">
                <div>
                    @if($school->logo)
                        <img src="{{ asset('storage/'.$school->logo) }}" class="w-16 h-16 rounded-2xl border-4 border-white/20 shadow-2xl mb-8 object-cover">
                    @endif
                    <h1 class="text-4xl font-black text-white leading-tight uppercase tracking-tighter">{{ $school->name }}</h1>
                    <div class="h-1.5 w-16 bg-blue-500 rounded-full mt-4"></div>
                    <p class="text-blue-100 text-sm font-bold uppercase tracking-widest mt-6">{{ $role }} Portal Access</p>
                </div>
                <div class="bg-white/10 backdrop-blur-xl p-6 rounded-[2rem] border border-white/10 shadow-xl">
                    <p class="text-white text-[10px] font-black uppercase tracking-widest">Institutional Enrollment</p>
                    <p class="text-blue-200 text-[8px] font-medium uppercase mt-1">Verify details before submission</p>
                </div>

                <!-- Branding Footer -->
                    <div class="mt-10 pt-6 border-t border-slate-50 text-center">
                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] italic-none">
                            Engineered by <span class="text-blue-600"> <a href="https://codecraftdevelopers.com" target="_blank" class="hover:underline">Codecraft Developers Limited</a></span>
                        </p>
                    </div>
            </div>

            
        </div>

        <!-- RIGHT SIDE -->
        <div class="w-full lg:w-7/12 h-full bg-white overflow-y-auto no-scrollbar flex flex-col">
            <div class="p-8 md:p-14">
                <div class="mb-10">
                    <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tighter">Create Account</h2>
                    <p class="text-slate-400 font-bold uppercase text-[9px] tracking-[0.2em] mt-2">Enter your official details to join the portal</p>
                </div>

                <form action="{{ route('public.register.store', [$role, $key]) }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ photoPreview: null }">
                    @csrf
                    
                    <!-- Photo Upload -->
                    <div class="flex items-center space-x-6 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="relative shrink-0">
                            <div class="w-16 h-16 rounded-xl bg-white border-2 border-dashed border-slate-200 overflow-hidden flex items-center justify-center relative shadow-sm">
                                <template x-if="photoPreview"><img :src="photoPreview" class="w-full h-full object-cover"></template>
                                <template x-if="!photoPreview"><i class="fas fa-user-plus text-slate-300"></i></template>
                            </div>
                            <label class="absolute -bottom-1 -right-1 w-7 h-7 bg-blue-600 text-white rounded-lg flex items-center justify-center cursor-pointer shadow-lg border-2 border-white hover:scale-110 transition-all">
                                <i class="fas fa-camera text-[8px]"></i>
                                <input type="file" name="photo" class="hidden" accept="image/*" @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result }; reader.readAsDataURL(file); }">
                            </label>
                        </div>
                        <p class="text-[10px] font-black text-slate-800 uppercase tracking-widest leading-tight">Profile Image <br><span class="text-[8px] font-bold text-slate-400">PASSPORT FORMAT</span></p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Legal Name</label>
                            <input type="text" name="name" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold uppercase text-xs focus:ring-4 focus:ring-blue-500/5 outline-none transition-all">
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                            <input type="email" name="email" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold text-xs focus:ring-4 focus:ring-blue-500/5 outline-none transition-all">
                        </div>

                        @if($role === 'student')
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Assigned Class</label>
                                <select name="school_class_id" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold uppercase text-xs outline-none">
                                    <option value="">SELECT</option>
                                    @foreach($classes as $class) <option value="{{ $class->id }}">{{ $class->full_name }}</option> @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Birthday</label>
                                <input type="date" name="date_of_birth" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold text-xs outline-none">
                            </div>
                        @else
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Phone Number</label>
                                <input type="text" name="phone" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold text-xs outline-none">
                            </div>
                        @endif

                        <input type="password" name="password" required placeholder="PASSWORD" class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold text-xs outline-none">
                        <input type="password" name="password_confirmation" required placeholder="CONFIRM" class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold text-xs outline-none">
                    </div>

                    <div class="pt-4 pb-10">
                        <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 hover:-translate-y-1 transition-all uppercase tracking-widest text-[10px]">
                            Complete Registration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>