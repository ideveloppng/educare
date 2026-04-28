<x-admin-layout>
    <div class="max-w-5xl mx-auto pb-24">
        
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('admin.staff.index') }}" class="hover:text-blue-600 transition-colors italic-none">Staff Registry</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Non-Academic Recruitment</span>
        </nav>

        <form action="{{ route('admin.staff.store') }}" method="POST">
            @csrf
            <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden">
                
                <div class="p-12 border-b border-slate-50 bg-slate-50/30 flex items-center">
                    <div class="w-16 h-16 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-emerald-200 mr-6"><i class="fas fa-user-tie text-2xl"></i></div>
                    <div>
                        <h1 class="text-3xl font-black text-slate-800 uppercase italic-none tracking-tight">Staff Enrollment</h1>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Register Accountants, Librarians and Support Staff</p>
                    </div>
                </div>

                <div class="p-14 space-y-16">
                    <section>
                        <h4 class="text-xs font-black text-blue-600 uppercase tracking-[0.4em] mb-10 flex items-center italic-none">
                            <span class="w-8 h-px bg-blue-100 mr-4"></span> Professional Identity
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-12">
                            <!-- Role Selection - THE KEY FIELD -->
                            <div class="space-y-4">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic-none">System Access Role</label>
                                <div class="relative">
                                    <i class="fas fa-shield-alt absolute left-6 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                    <select name="role" required class="w-full pl-14 pr-12 py-5 border border-slate-100 bg-slate-50/50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none appearance-none text-sm uppercase italic-none shadow-sm">
                                        <option value="">Select Portal Access</option>
                                        <option value="accountant">Accountant / Bursar</option>
                                        <option value="librarian">Librarian</option>
                                    </select>
                                    <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none text-[10px]"></i>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic-none">Full Name</label>
                                <input type="text" name="name" required class="w-full px-6 py-5 border border-slate-100 bg-slate-50/50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none uppercase text-sm italic-none shadow-sm" placeholder="E.G. CHIDI BENE">
                            </div>

                            <div class="space-y-4">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic-none">Official Designation</label>
                                <input type="text" name="designation" required class="w-full px-6 py-5 border border-slate-100 bg-slate-50/50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none uppercase text-sm italic-none shadow-sm" placeholder="E.G. HEAD BURSAR">
                            </div>

                            <div class="space-y-4">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic-none">Monthly Salary (₦)</label>
                                <input type="number" name="base_salary" required class="w-full px-6 py-5 border border-slate-100 bg-slate-50/50 rounded-2xl font-black text-xl focus:ring-4 focus:ring-blue-500/5 outline-none italic-none shadow-sm">
                            </div>
                        </div>
                    </section>
                    
                    <!-- Contact Section -->
                    <section>
                        <h4 class="text-xs font-black text-emerald-600 uppercase tracking-[0.4em] mb-10 flex items-center italic-none">
                            <span class="w-8 h-px bg-emerald-100 mr-4"></span> Contact Details
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-12">
                            <div class="space-y-4">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic-none">Login Email</label>
                                <input type="email" name="email" required class="w-full px-6 py-5 border border-slate-100 bg-slate-50/50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none text-sm italic-none shadow-sm">
                            </div>
                            <div class="space-y-4">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic-none">Phone Number</label>
                                <input type="text" name="phone" required class="w-full px-6 py-5 border border-slate-100 bg-slate-50/50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none text-sm italic-none shadow-sm">
                            </div>
                        </div>
                    </section>
                </div>

                <div class="p-12 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                    <div class="flex items-center px-6 py-4 bg-white rounded-2xl border border-slate-200 shadow-sm italic-none">
                        <i class="fas fa-lock text-emerald-500 mr-4 text-sm"></i>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Initial Password: <span class="text-emerald-600">staff123</span></p>
                    </div>
                    <button type="submit" class="px-16 py-6 bg-emerald-600 text-white font-black rounded-[2.2rem] shadow-2xl shadow-emerald-200 hover:bg-emerald-700 transition-all active:scale-95 uppercase tracking-widest text-xs italic-none">
                        Register & Activate Account
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>