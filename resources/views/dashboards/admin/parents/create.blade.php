<x-admin-layout>
    <div class="max-w-4xl mx-auto pb-24">
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('admin.parents') }}" class="hover:text-blue-600 transition-colors italic-none">Registry</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800">Account Onboarding</span>
        </nav>

        <form action="{{ route('admin.parents.store') }}" method="POST">
            @csrf
            <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-12 border-b border-slate-50 bg-slate-50/30 flex items-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-blue-200 mr-6 italic-none">
                        <i class="fas fa-user-friends text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Register Parent</h1>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-2 italic-none">Create a new guardian portal account</p>
                    </div>
                </div>

                <div class="p-12 space-y-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Full Name</label>
                            <input type="text" name="name" required class="w-full px-6 py-5 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none uppercase text-sm italic-none shadow-sm" placeholder="e.g. MR. JOHN DOE">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Email Address</label>
                            <input type="email" name="email" required class="w-full px-6 py-5 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none text-sm italic-none shadow-sm" placeholder="parent@email.com">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Phone Number</label>
                            <input type="text" name="phone" required class="w-full px-6 py-5 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none text-sm italic-none shadow-sm" placeholder="+234 ...">
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Occupation</label>
                            <input type="text" name="occupation" class="w-full px-6 py-5 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none uppercase text-sm italic-none shadow-sm" placeholder="e.g. SOFTWARE ENGINEER">
                        </div>
                        <div class="md:col-span-2 space-y-3">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Residential Address</label>
                            <textarea name="address" rows="3" class="w-full px-6 py-5 border border-slate-100 bg-slate-50 rounded-[2rem] font-bold focus:ring-4 focus:ring-blue-500/5 outline-none uppercase text-sm italic-none shadow-sm"></textarea>
                        </div>
                    </div>
                </div>

                <div class="p-12 bg-slate-50 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="flex items-center px-6 py-4 bg-white rounded-2xl border border-slate-200 shadow-sm">
                        <i class="fas fa-key text-blue-600 mr-4 text-sm italic-none"></i>
                        <p class="text-[10px] font-bold text-slate-400 uppercase italic-none">Initial Passcode: <span class="text-blue-600 font-black">parent123</span></p>
                    </div>
                    <div class="flex items-center space-x-8">
                        <a href="{{ route('admin.parents') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic-none">Discard</a>
                        <button type="submit" class="px-12 py-5 bg-blue-600 text-white font-black rounded-[1.8rem] shadow-2xl hover:bg-blue-700 transition-all uppercase tracking-widest text-[11px] italic-none">Register Parent Account</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>