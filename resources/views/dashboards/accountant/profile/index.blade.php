<x-accountant-layout>
    <div x-data="{ 
        showEditModal: false, 
        showPasswordModal: false,
        photoPreview: '{{ Auth::user()->staff?->photo ? asset('storage/'.Auth::user()->staff->photo) : null }}'
    }" class="max-w-6xl mx-auto pb-24">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Accountant Profile</span>
        </nav>

        <!-- MAIN PROFILE CARD -->
        <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10 relative">
            
            <!-- HEADER SECTION -->
            <div class="p-12 bg-slate-50/50 border-b border-slate-100 relative">
                <div class="flex flex-col lg:flex-row items-center lg:items-end gap-10 relative z-10">
                    
                    <!-- Staff Passport -->
                    <div class="w-48 h-48 rounded-[3rem] bg-white p-2 shadow-2xl border border-slate-100 shrink-0">
                        <div class="w-full h-full rounded-[2.5rem] overflow-hidden bg-slate-100 flex items-center justify-center border border-slate-200 shadow-inner">
                            @if(Auth::user()->staff?->photo)
                                <img src="{{ asset('storage/'.Auth::user()->staff->photo) }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user-tie text-slate-200 text-5xl"></i>
                            @endif
                        </div>
                    </div>

                    <!-- Identity Info -->
                    <div class="flex-1 text-center lg:text-left space-y-5 pb-4">
                        <div class="space-y-3">
                            <span class="px-5 py-2 bg-emerald-100 text-emerald-600 text-[10px] font-black rounded-xl uppercase tracking-[0.2em] shadow-xl shadow-emerald-200 italic-none">
                                {{ Auth::user()->staff?->staff_id ?? 'STF-Bursary' }}
                            </span>
                            <h2 class="text-5xl font-black text-slate-800 uppercase tracking-tight leading-none italic-none">
                                {{ Auth::user()->name }}
                            </h2>
                        </div>
                        
                        <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                            <div class="flex items-center bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm">
                                <i class="fas fa-shield-alt text-emerald-600 mr-3 text-sm"></i>
                                <span class="text-xs font-black text-slate-700 uppercase tracking-widest italic-none">
                                    {{ Auth::user()->staff?->designation ?? 'Finance Officer' }}
                                </span>
                            </div>
                            <div class="flex items-center bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm">
                                <i class="fas fa-calendar-alt text-slate-400 mr-3 text-sm"></i>
                                <span class="text-xs font-black text-slate-700 uppercase tracking-widest italic-none">
                                    Active Since: {{ Auth::user()->created_at->format('M Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Header Actions -->
                    <div class="pb-4 flex flex-col gap-3 shrink-0">
                        <button @click="showEditModal = true" class="flex items-center px-10 py-5 bg-slate-900 text-white font-black rounded-[1.8rem] shadow-2xl hover:bg-emerald-600 transition-all text-[10px] uppercase tracking-[0.2em] italic-none">
                            <i class="fas fa-user-edit mr-3"></i> Edit Profile
                        </button>
                        <button @click="showPasswordModal = true" class="flex items-center px-10 py-4 bg-white border border-slate-200 text-slate-400 font-black rounded-[1.5rem] hover:text-red-500 transition-all text-[9px] uppercase tracking-[0.2em] italic-none">
                            <i class="fas fa-lock mr-3"></i> Password
                        </button>
                    </div>
                </div>
            </div>

            <!-- PROFILE VIEW GRID -->
            <div class="p-12 grid grid-cols-1 lg:grid-cols-2 gap-20">
                <!-- Personal Info -->
                <div class="space-y-12">
                    <h4 class="text-xs font-black text-blue-600 uppercase tracking-[0.4em] italic-none flex items-center">
                        <span class="w-8 h-px bg-blue-100 mr-4"></span> Professional Identity
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-12 gap-x-10">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 italic-none">Login Email</p>
                            <p class="text-sm font-bold text-slate-800 italic-none">{{ Auth::user()->email }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 italic-none">Contact Phone</p>
                            <p class="text-sm font-bold text-slate-800 italic-none">{{ Auth::user()->staff?->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 italic-none">Department</p>
                            <p class="text-sm font-bold text-slate-800 uppercase italic-none">Bursary / Accounts</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 italic-none">Role Permissions</p>
                            <p class="text-sm font-bold text-emerald-600 uppercase italic-none">Ledger Authorizer</p>
                        </div>
                    </div>
                </div>

                <!-- Compensation Card -->
                <div class="space-y-12">
                    <h4 class="text-xs font-black text-emerald-600 uppercase tracking-[0.4em] italic-none flex items-center">
                        <span class="w-8 h-px bg-emerald-100 mr-4"></span> Salary Data
                    </h4>
                    <div class="p-10 bg-slate-900 rounded-[3rem] text-white shadow-2xl relative overflow-hidden group">
                        <div class="relative z-10">
                            <p class="text-[10px] font-black text-blue-300 uppercase tracking-widest mb-6 italic-none">Confidential Registry</p>
                            <div>
                                <p class="text-xs font-bold text-blue-200 uppercase mb-1 italic-none">Monthly Base Salary</p>
                                <p class="text-4xl font-black italic-none tracking-tighter">₦{{ number_format(Auth::user()->staff?->base_salary, 2) }}</p>
                            </div>
                            <div class="mt-8 pt-8 border-t border-slate-800 flex items-center justify-between">
                                <span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest italic-none">Payroll Active</span>
                                <i class="fas fa-check-circle text-emerald-400"></i>
                            </div>
                        </div>
                        <i class="fas fa-wallet absolute -bottom-10 -right-10 text-[160px] opacity-10"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: EDIT PROFILE -->
        <!-- ========================================== -->
        <div x-show="showEditModal" x-cloak class="fixed inset-0 z-[9999] overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-md"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <form action="{{ route('accountant.profile.update') }}" method="POST" enctype="multipart/form-data" @click.away="showEditModal = false"
                      class="relative bg-white w-full max-w-2xl rounded-[3.5rem] shadow-2xl border border-slate-100 overflow-hidden flex flex-col italic-none">
                    @csrf @method('PATCH')
                    <div class="p-10 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="relative mr-6 shrink-0">
                                <div class="w-24 h-24 rounded-[1.8rem] bg-white border-2 border-dashed border-slate-200 overflow-hidden flex items-center justify-center">
                                    <template x-if="photoPreview"><img :src="photoPreview" class="w-full h-full object-cover"></template>
                                    <template x-if="!photoPreview"><i class="fas fa-camera text-slate-200 text-3xl"></i></template>
                                </div>
                                <label class="absolute -bottom-2 -right-2 w-10 h-10 bg-emerald-600 text-white rounded-xl flex items-center justify-center cursor-pointer shadow-xl border-4 border-white"><i class="fas fa-plus text-xs"></i><input type="file" name="photo" class="hidden" accept="image/*" @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result }; reader.readAsDataURL(file); }"></label>
                            </div>
                            <h3 class="text-2xl font-black text-slate-800 uppercase italic-none">Edit My Profile</h3>
                        </div>
                        <button type="button" @click="showEditModal = false" class="text-slate-300 hover:text-red-500"><i class="fas fa-times text-xl"></i></button>
                    </div>
                    <div class="p-10 grid grid-cols-1 md:grid-cols-2 gap-8 bg-white">
                        <div class="space-y-2"><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Full Name</label><input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-emerald-500/5 outline-none uppercase text-sm italic-none shadow-sm"></div>
                        <div class="space-y-2"><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Phone Number</label><input type="text" name="phone" value="{{ old('phone', Auth::user()->staff?->phone) }}" required class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-emerald-500/5 outline-none text-sm italic-none shadow-sm"></div>
                        <div class="space-y-2 opacity-60"><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Qualification</label><input type="text" name="qualification" value="{{ Auth::user()->staff?->qualification ?? 'NOT SET' }}" readonly class="w-full px-6 py-4 border border-slate-100 bg-slate-100 rounded-2xl font-bold outline-none text-sm italic-none cursor-not-allowed"></div>
                    </div>
                    <div class="p-10 bg-slate-50 border-t border-slate-100 flex items-center justify-end space-x-6">
                        <button type="button" @click="showEditModal = false" class="text-xs font-black text-slate-400 uppercase tracking-widest italic-none">Discard</button>
                        <button type="submit" class="px-10 py-5 bg-emerald-600 text-white font-black rounded-2xl shadow-xl hover:bg-emerald-700 transition-all uppercase tracking-widest text-[11px] italic-none">Update Ledger ID</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: CHANGE PASSWORD -->
        <!-- ========================================== -->
        <div x-show="showPasswordModal" x-cloak class="fixed inset-0 z-[9999] overflow-y-auto">
            <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-md"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <form action="{{ route('accountant.profile.password') }}" method="POST" @click.away="showPasswordModal = false"
                      class="relative bg-white w-full max-w-md rounded-[3.5rem] shadow-2xl border border-slate-100 p-10 text-center flex flex-col italic-none">
                    @csrf @method('PATCH')
                    <div class="w-20 h-20 bg-emerald-50 text-emerald-500 rounded-[1.8rem] flex items-center justify-center mx-auto mb-8 text-3xl shadow-inner border border-emerald-100 italic-none"><i class="fas fa-lock"></i></div>
                    <h3 class="text-2xl font-black text-slate-800 uppercase italic-none mb-2">Change Password</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-10 italic-none">Keep your terminal access safe</p>
                    <div class="space-y-6 text-left">
                        <div><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-2 block italic-none">Old Password</label><input type="password" name="current_password" required class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none text-sm focus:ring-4 focus:ring-emerald-500/5 transition-all shadow-sm italic-none"></div>
                        <div><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-2 block italic-none">New Password</label><input type="password" name="password" required class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none text-sm focus:ring-4 focus:ring-emerald-500/5 transition-all shadow-sm italic-none"></div>
                        <div><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-2 block italic-none">Confirm Password</label><input type="password" name="password_confirmation" required class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none text-sm focus:ring-4 focus:ring-emerald-500/5 transition-all shadow-sm italic-none"></div>
                    </div>
                    <div class="mt-12 flex flex-col space-y-3">
                        <button type="submit" class="w-full py-5 bg-slate-900 text-white font-black rounded-[1.5rem] shadow-xl hover:bg-emerald-600 transition-all uppercase tracking-widest text-[11px] italic-none">Update Login Key</button>
                        <button type="button" @click="showPasswordModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px] italic-none">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-accountant-layout>