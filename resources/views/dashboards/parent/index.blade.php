<x-parent-layout>
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Family Overview</h1>
            <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em]">Monitoring {{ $children->count() }} enrolled dependents</p>
        </div>
    </div>

    @if(isset($noProfile))
        <div class="bg-red-50 border border-red-100 p-8 rounded-[3rem] text-center mb-10">
            <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-4"></i>
            <p class="text-sm text-red-600 font-black uppercase italic-none">Parent profile not found. Please contact Registry.</p>
        </div>
    @endif

    <!-- Quick Stats Grid: 2x2 on mobile, 4 cols on desktop -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
        <!-- Family Balance -->
        <div class="bg-white p-5 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between transition-all hover:shadow-md">
            <div class="flex justify-between items-start mb-4">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none italic-none">Family Balance</p>
                <div class="w-8 h-8 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500 text-xs shadow-sm"><i class="fas fa-wallet"></i></div>
            </div>
            <h3 class="text-xl md:text-2xl font-black {{ $familyBalance > 0 ? 'text-red-500' : 'text-slate-800' }} tracking-tighter italic-none">₦{{ number_format($familyBalance, 0) }}</h3>
            <span class="mt-2 text-[8px] md:text-[9px] font-black text-slate-400 uppercase tracking-tighter">Current Debt</span>
        </div>

        <!-- Children Count -->
        <div class="bg-white p-5 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between transition-all hover:shadow-md">
            <div class="flex justify-between items-start mb-4">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none italic-none">Children</p>
                <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500 text-xs shadow-sm"><i class="fas fa-child"></i></div>
            </div>
            <h3 class="text-xl md:text-2xl font-black text-slate-800 tracking-tighter italic-none">{{ $children->count() }}</h3>
            <span class="mt-2 text-[8px] md:text-[9px] font-black text-slate-400 uppercase tracking-tighter">In Institution</span>
        </div>

        <!-- Results Check -->
        <div class="bg-white p-5 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between transition-all hover:shadow-md">
            <div class="flex justify-between items-start mb-4">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none italic-none">Academics</p>
                <div class="w-8 h-8 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500 text-xs shadow-sm"><i class="fas fa-poll-h"></i></div>
            </div>
            <h3 class="text-xl md:text-2xl font-black text-slate-800 tracking-tighter italic-none">READY</h3>
            <span class="mt-2 text-[8px] md:text-[9px] font-black text-blue-500 uppercase tracking-tighter">Term Reports</span>
        </div>

        <!-- System Alerts -->
        <div class="bg-white p-5 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between transition-all hover:shadow-md">
            <div class="flex justify-between items-start mb-4">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none italic-none">Notices</p>
                <div class="w-8 h-8 bg-orange-50 rounded-xl flex items-center justify-center text-orange-500 text-xs shadow-sm"><i class="fas fa-bullhorn"></i></div>
            </div>
            <h3 class="text-xl md:text-2xl font-black text-slate-800 tracking-tighter italic-none">{{ $notices->count() }}</h3>
            <span class="mt-2 text-[8px] md:text-[9px] font-black text-orange-400 uppercase tracking-tighter">New Updates</span>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            <!-- 1. ANALYTICS: Comparison Mockup -->
            <div class="bg-white p-8 md:p-10 rounded-[3rem] border border-slate-100 shadow-sm relative">
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest italic-none">Performance Analytics</h4>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">Class Average comparison</p>
                    </div>
                    <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[8px] font-black rounded-lg uppercase">Current Term</span>
                </div>
                
                <!-- Mock Chart Visualization -->
                <div class="h-64 flex items-end justify-around gap-4 px-4 border-b border-slate-50">
                    @foreach($children as $child)
                        <div class="flex flex-col items-center w-full group">
                            <!-- Mock growth bar -->
                            <div class="w-full bg-blue-600 rounded-t-2xl shadow-lg shadow-blue-100 transition-all duration-700 group-hover:bg-blue-700" 
                                 style="height: {{ rand(40, 90) }}%">
                                <div class="w-full h-full bg-white/10 flex items-start justify-center pt-2">
                                    <span class="text-[8px] font-black text-white uppercase">{{ rand(60, 95) }}%</span>
                                </div>
                            </div>
                            <p class="mt-4 text-[8px] font-black text-slate-400 uppercase tracking-tighter truncate w-full text-center">{{ explode(' ', $child->user->name)[0] }}</p>
                        </div>
                    @endforeach
                    @if($children->isEmpty())
                        <p class="pb-20 text-slate-200 uppercase font-black text-[10px]">No children linked to chart</p>
                    @endif
                </div>
            </div>

            <!-- 2. ANNOUNCEMENTS / NOTICE BOARD -->
            <div class="bg-white p-8 md:p-10 rounded-[3rem] border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest italic-none">Institutional Notices</h4>
                    <i class="fas fa-broadcast-tower text-slate-200"></i>
                </div>
                
                <div class="space-y-6">
                    @forelse($notices as $notice)
                    <div class="p-6 bg-slate-50 rounded-[2.5rem] border border-slate-100 transition-all hover:bg-blue-50/50 group">
                        <div class="flex items-center space-x-4 mb-4">
                            <span class="px-3 py-1 {{ $notice->priority == 'urgent' ? 'bg-red-600' : 'bg-blue-600' }} text-white text-[8px] font-black rounded-lg uppercase tracking-widest shadow-lg italic-none">{{ $notice->priority }}</span>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic-none">{{ $notice->created_at->format('M d, Y') }}</span>
                        </div>
                        <h5 class="text-sm font-black text-slate-800 uppercase italic-none group-hover:text-blue-600 transition-colors">{{ $notice->title }}</h5>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed italic-none font-medium">{{ Str::limit($notice->content, 150) }}</p>
                    </div>
                    @empty
                    <div class="py-12 text-center border-2 border-dashed border-slate-100 rounded-[2.5rem] italic-none">
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">No active announcements</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Sidebar Actions -->
        <div class="space-y-8">
            <!-- Family Financial Card -->
            <div class="bg-slate-900 rounded-[3rem] p-10 text-white shadow-2xl relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-6 italic-none">Quick Payment</p>
                    <h4 class="text-xl font-black uppercase italic-none leading-tight mb-8">Clear Family Balance</h4>
                    <div class="mb-10">
                        <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Outstanding</p>
                        <p class="text-3xl font-black tracking-tighter italic-none">₦{{ number_format($familyBalance, 0) }}</p>
                    </div>
                    <a href="{{ route('parent.fees') }}" class="inline-block px-8 py-4 bg-blue-600 hover:bg-white hover:text-blue-900 transition-all rounded-2xl text-[10px] font-black uppercase tracking-widest italic-none shadow-lg">
                        Submit Proof
                    </a>
                </div>
                <i class="fas fa-receipt absolute -bottom-10 -right-10 text-[160px] opacity-5 group-hover:scale-110 transition-transform duration-700"></i>
            </div>

            <!-- Linked Children List (Sidebar) -->
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest italic-none">Your Children</h4>
                    <a href="{{ route('parent.children') }}" class="text-[9px] font-black text-blue-600 uppercase tracking-widest hover:underline italic-none">Manage</a>
                </div>
                
                <div class="space-y-4">
                    @foreach($children as $child)
                    <div class="p-4 bg-slate-50 rounded-[1.5rem] border border-slate-100 flex items-center hover:bg-white hover:shadow-sm transition-all italic-none">
                        <div class="w-10 h-10 rounded-xl bg-white border-2 border-white shadow-sm overflow-hidden mr-3">
                            @if($child->student_photo)
                                <img src="{{ asset('storage/'.$child->student_photo) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-200"><i class="fas fa-user text-xs"></i></div>
                            @endif
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] font-black text-slate-800 uppercase leading-none truncate">{{ $child->user->name }}</p>
                            <p class="text-[8px] font-bold text-slate-400 uppercase mt-1">{{ $child->schoolClass->full_name }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-parent-layout>