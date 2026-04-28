<x-super-admin-layout>
    <div class="max-w-6xl mx-auto pb-24">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('schools.index') }}" class="hover:text-blue-600 transition-colors italic-none">Institutions</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Institutional Overview</span>
        </nav>

        <!-- Header: School Identity -->
        <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10 relative">
            <div class="p-12 bg-slate-50/50 border-b border-slate-100 flex flex-col lg:flex-row items-center lg:items-end gap-10">
                
                <!-- School Logo -->
                <div class="w-44 h-44 rounded-[3rem] bg-white p-2 shadow-2xl border border-slate-100 shrink-0">
                    <div class="w-full h-full rounded-[2.5rem] overflow-hidden bg-slate-100 flex items-center justify-center border border-slate-200 shadow-inner">
                        @if($school->logo)
                            <img src="{{ asset('storage/'.$school->logo) }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-school text-slate-200 text-5xl"></i>
                        @endif
                    </div>
                </div>

                <!-- Identity info -->
                <div class="flex-1 text-center lg:text-left space-y-5 pb-4">
                    <div class="space-y-3">
                        <span class="px-5 py-2 bg-blue-600 text-white text-[10px] font-black rounded-xl uppercase tracking-[0.2em] shadow-xl shadow-blue-200 italic-none">
                            Registered ID: #{{ str_pad($school->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                        <h2 class="text-4xl font-black text-slate-800 uppercase tracking-tight leading-none italic-none">
                            {{ $school->name }}
                        </h2>
                    </div>
                    
                    <div class="flex flex-wrap justify-center lg:justify-start gap-4 italic-none">
                        <div class="flex items-center bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm">
                            <i class="fas fa-calendar-alt text-blue-600 mr-3 text-sm"></i>
                            <span class="text-xs font-black text-slate-700 uppercase tracking-widest leading-none">
                                Joined: {{ $school->created_at->format('M Y') }}
                            </span>
                        </div>
                        <div class="flex items-center bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm">
                            <i class="fas fa-shield-check text-emerald-500 mr-3 text-sm"></i>
                            <span class="text-xs font-black text-slate-700 uppercase tracking-widest leading-none">
                                Status: {{ strtoupper($school->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="pb-4">
                    <a href="{{ route('schools.edit', $school) }}" class="flex items-center px-10 py-5 bg-slate-900 text-white font-black rounded-[1.8rem] shadow-2xl hover:bg-blue-600 transition-all text-[10px] uppercase tracking-[0.2em] italic-none">
                        <i class="fas fa-edit mr-3"></i> Edit Institution
                    </a>
                </div>
            </div>

            <!-- Stats Grid: 4 Personas -->
            <div class="p-12 grid grid-cols-2 lg:grid-cols-4 gap-8 bg-white italic-none">
                <div class="space-y-2">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Enrolled Students</p>
                    <p class="text-3xl font-black text-slate-800 tracking-tighter">{{ number_format($stats['students']) }}</p>
                </div>
                <div class="space-y-2 border-l border-slate-50 pl-8">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Active Teachers</p>
                    <p class="text-3xl font-black text-slate-800 tracking-tighter">{{ number_format($stats['teachers']) }}</p>
                </div>
                <div class="space-y-2 border-l border-slate-50 pl-8">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Support Staff</p>
                    <p class="text-3xl font-black text-slate-800 tracking-tighter">{{ number_format($stats['staff']) }}</p>
                </div>
                <div class="space-y-2 border-l border-slate-50 pl-8">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Parent Network</p>
                    <p class="text-3xl font-black text-slate-800 tracking-tighter">{{ number_format($stats['parents']) }}</p>
                </div>
            </div>
        </div>

        <!-- Detailed Contact & Admin Info -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- Contact Card (Left 2/3) -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm p-12">
                    <h4 class="text-xs font-black text-blue-600 uppercase tracking-[0.4em] mb-12 flex items-center italic-none">
                        <span class="w-8 h-px bg-blue-100 mr-4"></span> Official Contact Data
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-12 gap-x-10 italic-none">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Institutional Email</p>
                            <div class="flex items-center text-slate-800">
                                <i class="fas fa-envelope text-blue-200 mr-3 text-sm"></i>
                                <span class="text-sm font-bold break-words">{{ $school->email }}</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Primary Phone</p>
                            <div class="flex items-center text-slate-800">
                                <i class="fas fa-phone-alt text-blue-200 mr-3 text-sm"></i>
                                <span class="text-sm font-bold">{{ $school->phone ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Physical Location</p>
                            <div class="flex items-start text-slate-800">
                                <i class="fas fa-map-marker-alt text-blue-200 mr-3 mt-1 text-sm"></i>
                                <span class="text-sm font-bold uppercase leading-relaxed">{{ $school->address ?? 'No Address on File' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- School Admin Profile (Right 1/3) -->
            <div class="space-y-8 italic-none">
                <div class="bg-slate-900 rounded-[3rem] p-10 text-white shadow-2xl relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-8">Admin Controller</p>
                        @if($admin)
                            <div class="space-y-6">
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase">Full Name</p>
                                    <p class="text-xl font-black uppercase tracking-tight text-white">{{ $admin->name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase">Login Username</p>
                                    <p class="text-sm font-bold text-blue-300">{{ $admin->email }}</p>
                                </div>
                            </div>
                        @else
                            <p class="text-xs font-bold text-red-400 uppercase">No primary admin account linked.</p>
                        @endif
                    </div>
                    <i class="fas fa-user-shield absolute -bottom-10 -right-10 text-[160px] opacity-10"></i>
                </div>

                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-4">Subscription Plan</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xl font-black text-slate-800 uppercase">{{ $school->plan }}</span>
                        <i class="fas fa-gem text-blue-600"></i>
                    </div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase mt-2">Expires: {{ $school->subscription_expires_at ? $school->subscription_expires_at->format('d M, Y') : 'Trial Mode' }}</p>
                </div>
            </div>
        </div>

    </div>
</x-super-admin-layout>