<x-admin-layout>
    <div class="max-w-5xl mx-auto pb-24">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">System Settings</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">System Configuration</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-widest italic-none">Global controls for institutional operations</p>
            </div>
        </div>

        <!-- SECTION 1: ACADEMIC TIMELINE -->
        <form action="{{ route('admin.settings.academic.update') }}" method="POST" class="mb-10">
            @csrf @method('PATCH')
            
            <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden">
                
                <div class="p-12 border-b border-slate-50 bg-slate-50/30 flex items-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-blue-200 mr-6 italic-none">
                        <i class="fas fa-calendar-alt text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight italic-none">Academic Timeline</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-1 italic-none">Set active session and term for all modules</p>
                    </div>
                </div>

                <div class="p-12 space-y-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        
                        <!-- Active Session -->
                        <div class="space-y-4">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic-none">Active Academic Session</label>
                            <div class="relative">
                                <i class="fas fa-history absolute left-6 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <select name="current_session" required class="w-full pl-14 pr-12 py-5 border border-slate-100 bg-slate-50/50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none appearance-none text-sm transition-all shadow-sm uppercase italic-none">
                                    @php
                                        $year = date('Y');
                                        $sessions = [
                                            ($year-1)."/".($year),
                                            ($year)."/".($year+1),
                                            ($year+1)."/".($year+2)
                                        ];
                                    @endphp
                                    @foreach($sessions as $session)
                                        <option value="{{ $session }}" {{ $school->current_session == $session ? 'selected' : '' }}>{{ $session }} Session</option>
                                    @endforeach
                                </select>
                                <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none text-[10px]"></i>
                            </div>
                        </div>

                        <!-- Current Term -->
                        <div class="space-y-4">
                            <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic-none">Active Academic Term</label>
                            <div class="relative">
                                <i class="fas fa-clock absolute left-6 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <select name="current_term" required class="w-full pl-14 pr-12 py-5 border border-slate-100 bg-slate-50/50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none appearance-none text-sm transition-all shadow-sm uppercase italic-none">
                                    <option value="First Term" {{ $school->current_term == 'First Term' ? 'selected' : '' }}>First Term</option>
                                    <option value="Second Term" {{ $school->current_term == 'Second Term' ? 'selected' : '' }}>Second Term</option>
                                    <option value="Third Term" {{ $school->current_term == 'Third Term' ? 'selected' : '' }}>Third Term</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none text-[10px]"></i>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="p-12 bg-slate-50 border-t border-slate-100 flex items-center justify-end">
                    <button type="submit" class="px-16 py-6 bg-blue-600 text-white font-black rounded-[2rem] shadow-2xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-1.5 transition-all active:scale-95 uppercase tracking-widest text-xs italic-none">
                        Update Global Timeline
                    </button>
                </div>
            </div>
        </form>

        <!-- SECTION 2: SELF-REGISTRATION LINKS -->
        <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
            <div class="p-10 border-b border-slate-50 bg-slate-50/30">
                <h3 class="text-xl font-black text-slate-800 uppercase italic-none">Registration Gateway</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">Manage public enrollment links for students and faculty</p>
            </div>
            
            <form action="{{ route('admin.settings.reg_status.update') }}" method="POST" class="p-10">
                @csrf @method('PATCH')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    
                    @php
                        $linkTypes = [
                            ['label' => 'Student Portal', 'name' => 'student_reg_active', 'color' => 'blue', 'role' => 'student'],
                            ['label' => 'Teacher Portal', 'name' => 'teacher_reg_active', 'color' => 'emerald', 'role' => 'teacher'],
                            ['label' => 'Parent Portal', 'name' => 'parent_reg_active', 'color' => 'indigo', 'role' => 'parent'],
                            ['label' => 'Staff Registry', 'name' => 'staff_reg_active', 'color' => 'orange', 'role' => 'staff'],
                        ];
                    @endphp

                    @foreach($linkTypes as $link)
                    <div class="p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 relative group" x-data="{ copied: false }">
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-[10px] font-black text-{{ $link['color'] }}-600 uppercase tracking-widest italic-none">{{ $link['label'] }}</span>
                            <input type="checkbox" name="{{ $link['name'] }}" {{ $school->{$link['name']} ? 'checked' : '' }} 
                                class="w-6 h-6 rounded-lg text-{{ $link['color'] }}-600 border-slate-300 focus:ring-{{ $link['color'] }}-500/20">
                        </div>
                        <div class="space-y-4">
                            <p class="text-[11px] font-black text-slate-800 uppercase italic-none">Enrollment Link:</p>
                            <div class="relative">
                                <input type="text" readonly value="{{ url('/register/'.$link['role'].'/'.$school->reg_key) }}" 
                                    class="w-full text-[10px] p-4 pr-12 bg-white border border-slate-200 rounded-2xl outline-none font-bold text-slate-500 shadow-inner italic-none">
                                
                                <!-- COPY BUTTON -->
                                <button type="button" 
                                    @click="navigator.clipboard.writeText($el.previousElementSibling.value); copied = true; setTimeout(() => copied = false, 2000)"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center rounded-xl transition-all"
                                    :class="copied ? 'bg-emerald-500 text-white' : 'bg-slate-50 text-slate-400 hover:text-blue-600 hover:bg-blue-50'">
                                    <i :class="copied ? 'fas fa-check text-[10px]' : 'fas fa-copy text-[10px]'"></i>
                                </button>
                            </div>
                            <p x-show="copied" x-cloak x-transition class="absolute bottom-2 right-8 text-[8px] font-black text-emerald-600 uppercase italic-none">Copied to clipboard!</p>
                        </div>
                    </div>
                    @endforeach

                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-12 py-5 bg-slate-900 text-white font-black rounded-[2rem] shadow-xl hover:bg-blue-600 transition-all uppercase tracking-widest text-[10px] italic-none">
                        Update Link Availability
                    </button>
                </div>
            </form>
        </div>

        <!-- SECTION 3: SYSTEM AUDIT INFO -->
        <div class="p-10 bg-blue-50 rounded-[3rem] border border-blue-100 flex items-start italic-none">
            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-blue-600 mr-6 shadow-sm border border-blue-100 shrink-0">
                <i class="fas fa-shield-alt text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-black text-blue-800 uppercase italic-none">Security Protocol</p>
                <p class="text-[11px] text-blue-600 font-medium leading-relaxed uppercase mt-1">
                    Public registration keys are unique to {{ $school->name }}. Regenerating the key will immediately break all previously shared links.
                </p>
            </div>
        </div>


        <!-- SECTION: SCHOOL FEE BANK ACCOUNTS -->
        <div class="mt-10 bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden" x-data="{ showBankModal: false }">
            <div class="p-10 border-b border-slate-50 bg-slate-50/30 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-black text-slate-800 uppercase italic-none">Fee Collection Accounts</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Bank details shown to parents and students</p>
                </div>
                <button @click="showBankModal = true" class="px-6 py-3 bg-blue-600 text-white font-black rounded-xl text-[10px] uppercase tracking-widest shadow-lg italic-none">
                    Add Account
                </button>
            </div>

            <div class="p-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($banks as $bank)
                <div class="p-8 rounded-[2.5rem] border {{ $bank->is_active ? 'border-blue-100 bg-blue-50/30' : 'border-slate-100 bg-slate-50' }} relative group transition-all">
                    <div class="flex justify-between items-start mb-6">
                        <span class="px-3 py-1 {{ $bank->is_active ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-500' }} text-[8px] font-black rounded-lg uppercase tracking-widest italic-none">
                            {{ $bank->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <div class="flex items-center space-x-2">
                            <form action="{{ route('admin.settings.bank.toggle', $bank->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-slate-400 hover:text-blue-600 transition-all"><i class="fas fa-power-off text-xs"></i></button>
                            </form>
                            <form action="{{ route('admin.settings.bank.delete', $bank->id) }}" method="POST" onsubmit="return confirm('Delete this account?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-red-500 transition-all"><i class="fas fa-trash text-xs"></i></button>
                            </form>
                        </div>
                    </div>
                    <p class="text-xs font-black text-slate-800 uppercase italic-none">{{ $bank->bank_name }}</p>
                    <p class="text-2xl font-black text-slate-900 my-2 tracking-widest italic-none">{{ $bank->account_number }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic-none">{{ $bank->account_name }}</p>
                </div>
                @endforeach
            </div>

            <!-- MODAL: ADD BANK -->
            <div x-show="showBankModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
                <form action="{{ route('admin.settings.bank.store') }}" method="POST" class="bg-white w-full max-w-md rounded-[3rem] p-10 shadow-2xl border border-slate-100 italic-none">
                    @csrf
                    <h3 class="text-2xl font-black text-slate-800 uppercase mb-8 text-center">New Fee Account</h3>
                    <div class="space-y-6">
                        <input type="text" name="bank_name" required placeholder="BANK NAME" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold uppercase text-sm outline-none">
                        <input type="text" name="account_number" required placeholder="ACCOUNT NUMBER" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold uppercase text-sm outline-none">
                        <input type="text" name="account_name" required placeholder="ACCOUNT NAME (SCHOOL NAME)" class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold uppercase text-sm outline-none">
                    </div>
                    <div class="mt-10 flex flex-col space-y-3">
                        <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl uppercase text-[10px]">Save Account</button>
                        <button type="button" @click="showBankModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px]">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-admin-layout>