<x-admin-layout>
    <div class="max-w-5xl mx-auto pb-24">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('admin.teachers') }}" class="hover:text-blue-600 transition-colors italic-none">Directory</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800">Faculty Member Profile</span>
        </nav>

        <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden">
            
            <!-- HEADER SECTION -->
            <div class="p-12 bg-slate-50/50 border-b border-slate-100 relative">
                <div class="flex flex-col lg:flex-row items-center lg:items-end gap-10 relative z-10">
                    
                    <!-- Staff Passport -->
                    <div class="w-48 h-48 rounded-[3rem] bg-white p-2 shadow-2xl border border-slate-100 shrink-0">
                        <div class="w-full h-full rounded-[2.5rem] overflow-hidden bg-slate-100 flex items-center justify-center border border-slate-200">
                            @if($teacher->photo)
                                <img src="{{ asset('storage/'.$teacher->photo) }}" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-chalkboard-teacher text-slate-200 text-5xl"></i>
                            @endif
                        </div>
                    </div>

                    <!-- Staff Basic Info -->
                    <div class="flex-1 text-center lg:text-left space-y-5 pb-4">
                        <div class="space-y-3">
                            <span class="px-5 py-2 bg-blue-600 text-white text-[10px] font-black rounded-xl uppercase tracking-[0.2em] shadow-xl shadow-blue-200">
                                {{ $teacher->staff_id }}
                            </span>
                            <h2 class="text-5xl font-black text-slate-800 uppercase tracking-tight leading-none italic-none">
                                {{ $teacher->user->name }}
                            </h2>
                        </div>
                        
                        <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                            <div class="flex items-center bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm">
                                <i class="fas fa-graduation-cap text-blue-600 mr-3 text-sm"></i>
                                <span class="text-xs font-black text-slate-700 uppercase tracking-widest italic-none">{{ $teacher->qualification }}</span>
                            </div>
                            <div class="flex items-center bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm">
                                <i class="fas fa-phone-alt text-emerald-500 mr-3 text-sm"></i>
                                <span class="text-xs font-black text-slate-700 uppercase tracking-widest italic-none">{{ $teacher->phone }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="pb-4">
                        <button class="px-10 py-5 bg-slate-900 text-white font-black rounded-[1.8rem] shadow-2xl hover:bg-blue-600 transition-all text-[10px] uppercase tracking-[0.2em] italic-none">
                            <i class="fas fa-edit mr-3"></i> Edit Staff
                        </button>
                    </div>
                </div>
            </div>

            <!-- DETAILS GRID -->
            <div class="p-12 grid grid-cols-1 lg:grid-cols-2 gap-20">
                
                <!-- Personal & Employment -->
                <div class="space-y-12">
                    <div class="flex items-center space-x-6">
                        <h4 class="text-xs font-black text-blue-600 uppercase tracking-[0.4em] italic-none">Staff Information</h4>
                        <div class="h-px bg-slate-100 flex-1"></div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-12 gap-x-10">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 italic-none">Official Email</p>
                            <p class="text-sm font-bold text-slate-800 italic-none">{{ $teacher->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 italic-none">Employment Date</p>
                            <p class="text-sm font-bold text-slate-800 italic-none">{{ $teacher->employment_date->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payroll Summary -->
                <div class="space-y-12">
                    <div class="flex items-center space-x-6">
                        <h4 class="text-xs font-black text-emerald-600 uppercase tracking-[0.4em] italic-none">Payroll & Compensation</h4>
                        <div class="h-px bg-slate-100 flex-1"></div>
                    </div>

                    <div class="p-10 bg-slate-900 rounded-[3rem] text-white shadow-2xl shadow-blue-200 relative overflow-hidden">
                        <div class="relative z-10">
                            <p class="text-[10px] font-black text-blue-300 uppercase tracking-widest mb-6">Staff Remuneration</p>
                            <div>
                                <p class="text-xs font-bold text-blue-200 uppercase mb-1 italic-none">Monthly Base Salary</p>
                                <p class="text-4xl font-black italic-none tracking-tighter">₦{{ number_format($teacher->base_salary, 0) }}</p>
                            </div>
                            <button class="w-full mt-8 py-4 bg-blue-800 hover:bg-white hover:text-blue-900 transition-all rounded-2xl text-[10px] font-black uppercase tracking-widest border border-blue-700">
                                View Payroll History
                            </button>
                        </div>
                        <i class="fas fa-wallet absolute -bottom-10 -right-10 text-[160px] opacity-10"></i>
                    </div>
                </div>
            </div>

            <!-- ACADEMIC LOAD FOOTER -->
            <div class="px-12 py-10 bg-slate-50 border-t border-slate-100">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 italic-none">Assigned Academic Workload</h4>
                <div class="flex flex-wrap gap-4">
                    @forelse($teacher->assignments as $assign)
                        <div class="px-6 py-3 bg-white border border-slate-200 rounded-2xl shadow-sm flex items-center">
                            <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mr-3 text-[10px]">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-800 uppercase leading-none italic-none">{{ $assign->subject->name }}</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase mt-1 leading-none italic-none">{{ $assign->schoolClass->name }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs font-bold text-slate-300 uppercase tracking-widest py-4 italic-none">No active subject assignments found for this staff member.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>