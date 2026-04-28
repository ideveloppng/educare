<x-student-layout>
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Welcome back, {{ Auth::user()->name }}</h1>
            <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em]">Academic Overview • {{ now()->format('D, M d, Y') }}</p>
        </div>
    </div>

    <!-- Quick Stats Grid: 2x2 on mobile, 4 cols on desktop -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
        <!-- Fees Status -->
        <div class="bg-white p-5 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between transition-all hover:shadow-md">
            <div class="flex justify-between items-start mb-4">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none italic-none">Term Fees</p>
                <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center text-blue-400 text-xs">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
            <h3 class="text-xl md:text-2xl font-black text-slate-800 italic-none">₦{{ number_format($balance, 0) }}</h3>
            @if($balance <= 0)
                <span class="mt-2 text-[8px] md:text-[9px] font-black text-emerald-500 uppercase tracking-tighter italic-none">Cleared</span>
            @else
                <span class="mt-2 text-[8px] md:text-[9px] font-black text-orange-500 uppercase tracking-tighter italic-none">Balance Due</span>
            @endif
        </div>

        <!-- Class Placement -->
        <div class="bg-white p-5 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between transition-all hover:shadow-md">
            <div class="flex justify-between items-start mb-4">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none italic-none">Placement</p>
                <div class="w-8 h-8 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-400 text-xs">
                    <i class="fas fa-layer-group"></i>
                </div>
            </div>
            <h3 class="text-xl md:text-2xl font-black text-slate-800 uppercase italic-none">{{ $student->schoolClass->full_name ?? 'N/A' }}</h3>
            <span class="mt-2 text-[8px] md:text-[9px] font-black text-slate-400 uppercase tracking-tighter italic-none">Current Class</span>
        </div>

        <!-- Pending Assignments -->
        <div class="bg-white p-5 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between transition-all hover:shadow-md">
            <div class="flex justify-between items-start mb-4">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none italic-none">Task List</p>
                <div class="w-8 h-8 bg-orange-50 rounded-xl flex items-center justify-center text-orange-400 text-xs">
                    <i class="fas fa-tasks"></i>
                </div>
            </div>
            <h3 class="text-xl md:text-2xl font-black text-slate-800 italic-none">0</h3>
            <span class="mt-2 text-[8px] md:text-[9px] font-black text-orange-500 uppercase tracking-tighter italic-none">Pending</span>
        </div>

        <!-- Result Status -->
        <div class="bg-white p-5 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between transition-all hover:shadow-md">
            <div class="flex justify-between items-start mb-4">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none italic-none">Portal</p>
                <div class="w-8 h-8 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-400 text-xs">
                    <i class="fas fa-poll-h"></i>
                </div>
            </div>
            <h3 class="text-xl md:text-2xl font-black text-slate-800 italic-none uppercase">Ready</h3>
            <span class="mt-2 text-[8px] md:text-[9px] font-black text-blue-500 uppercase tracking-tighter italic-none">Results</span>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            <!-- Pending Assignments Card -->
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest italic-none">Upcoming Assignments</h4>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">Current tasks from faculty</p>
                    </div>
                    <div class="w-12 h-12 bg-slate-50 text-slate-300 rounded-2xl flex items-center justify-center border border-slate-100 shadow-inner">
                        <i class="fas fa-pen-nib"></i>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Assignment Item Placeholder -->
                    <div class="flex items-center justify-between p-6 bg-slate-50 rounded-[2rem] border border-slate-100 group transition-all hover:bg-white hover:shadow-xl hover:shadow-slate-200/50">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-blue-600 mr-4 shadow-sm italic-none border border-slate-100">
                                <i class="fas fa-book-open text-xs"></i>
                            </div>
                            <div>
                                <h5 class="text-xs font-black text-slate-700 uppercase italic-none">Subject Assessment</h5>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter mt-1 italic-none">Check Assignments Tab for details</p>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right text-slate-200 text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Announcements / Notice Board -->
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest italic-none">School Announcements</h4>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">Directorate updates</p>
                    </div>
                    <i class="fas fa-bullhorn text-slate-200 text-xl"></i>
                </div>
                
                <div class="space-y-6">
                    @forelse($notices as $notice)
                    <div class="p-6 bg-slate-50 rounded-[2.5rem] border border-slate-100 transition-all hover:bg-blue-50/30">
                        <div class="flex items-center space-x-4 mb-4">
                            <span class="px-3 py-1 {{ $notice->priority == 'urgent' ? 'bg-red-600' : 'bg-blue-600' }} text-white text-[8px] font-black rounded-lg uppercase tracking-widest shadow-lg shadow-blue-100">{{ $notice->target_audience }}</span>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $notice->created_at->format('M d, Y') }}</span>
                        </div>
                        <h5 class="text-sm font-black text-slate-800 uppercase italic-none">{{ $notice->title }}</h5>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed italic-none font-medium line-clamp-2">{{ $notice->content }}</p>
                    </div>
                    @empty
                    <div class="py-12 text-center border-2 border-dashed border-slate-100 rounded-[2.5rem]">
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest italic-none">No active announcements</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- MOBILE ONLY: QUICK LINKS -->
            <div class="lg:hidden mb-10">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4 ml-2 italic-none">Quick Links</h4>
                <div class="flex overflow-x-auto no-scrollbar gap-4 pb-2">
                    <a href="{{ route('student.teachers') }}" class="flex-shrink-0 flex flex-col items-center justify-center w-24 h-24 bg-white rounded-[2rem] border border-slate-100 shadow-sm active:scale-95 transition-all">
                        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-2">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <span class="text-[8px] font-black uppercase text-slate-600 tracking-tighter">Teachers</span>
                    </a>
                    <a href="{{ route('student.assignments') }}" class="flex-shrink-0 flex flex-col items-center justify-center w-24 h-24 bg-white rounded-[2rem] border border-slate-100 shadow-sm active:scale-95 transition-all">
                        <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center mb-2">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <span class="text-[8px] font-black uppercase text-slate-600 tracking-tighter">Tasks</span>
                    </a>
                    <a href="{{ route('student.results') }}" class="flex-shrink-0 flex flex-col items-center justify-center w-24 h-24 bg-white rounded-[2rem] border border-slate-100 shadow-sm active:scale-95 transition-all">
                        <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-2">
                            <i class="fas fa-poll-h"></i>
                        </div>
                        <span class="text-[8px] font-black uppercase text-slate-600 tracking-tighter">Results</span>
                    </a>
                    <a href="{{ route('student.profile') }}" class="flex-shrink-0 flex flex-col items-center justify-center w-24 h-24 bg-white rounded-[2rem] border border-slate-100 shadow-sm active:scale-95 transition-all">
                        <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-2">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <span class="text-[8px] font-black uppercase text-slate-600 tracking-tighter">Account</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-8">
            <!-- Result Portal Card -->
            <div class="bg-blue-900 rounded-[3rem] p-10 text-white shadow-2xl shadow-blue-200 relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-blue-300 uppercase tracking-widest mb-6 italic-none">Academic Portal</p>
                    <h4 class="text-xl font-black uppercase italic-none leading-tight mb-8">View Session Results</h4>
                    <a href="{{ route('student.results') }}" class="inline-block px-8 py-4 bg-blue-600 hover:bg-white hover:text-blue-900 transition-all rounded-2xl text-[10px] font-black uppercase tracking-widest italic-none shadow-lg">
                        Check Results
                    </a>
                </div>
                <i class="fas fa-certificate absolute -bottom-10 -right-10 text-[160px] opacity-10 group-hover:scale-110 transition-transform duration-700"></i>
            </div>

            <!-- Class Faculty Section -->
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest italic-none">My Teachers</h4>
                    <a href="{{ route('student.teachers') }}" class="text-[9px] font-black text-blue-600 uppercase tracking-widest hover:underline italic-none">View All</a>
                </div>
                
                <div class="space-y-4">
                    @forelse($teachers as $assignment)
                    <div class="p-4 bg-slate-50 rounded-[1.5rem] border border-slate-100 flex items-center hover:bg-white hover:shadow-sm transition-all">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-blue-600 mr-3 italic-none border border-slate-100 shadow-sm">
                            @if($assignment->teacher->photo)
                                <img src="{{ asset('storage/'.$assignment->teacher->photo) }}" class="w-full h-full object-cover rounded-xl">
                            @else
                                <i class="fas fa-user-tie text-xs"></i>
                            @endif
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-[10px] font-black text-slate-800 uppercase italic-none leading-none truncate">{{ $assignment->teacher->user->name }}</p>
                            <p class="text-[8px] font-bold text-slate-400 uppercase italic-none mt-1">{{ $assignment->subject->name }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-[10px] font-bold text-slate-300 uppercase italic-none text-center py-6 border-2 border-dashed border-slate-50 rounded-3xl">
                        No teachers assigned yet
                    </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-student-layout>