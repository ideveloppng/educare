<x-teacher-layout>
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Welcome, {{ Auth::user()->name }}</h1>
            <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em]">Faculty Overview • {{ now()->format('D, M d, Y') }}</p>
        </div>
    </div>

    @if(isset($profileIncomplete))
        <div class="bg-red-50 border border-red-100 p-8 rounded-[3rem] text-center mb-10">
            <i class="fas fa-exclamation-triangle text-red-500 text-3xl mb-4"></i>
            <p class="text-sm text-red-600 font-black uppercase italic-none">Teacher profile not found. Please contact Admin.</p>
        </div>
    @endif

    <!-- MOBILE QUICK LINKS -->
    <div class="lg:hidden mb-10">
        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-4 ml-2 italic-none">Quick Actions</h4>
        <div class="flex overflow-x-auto no-scrollbar gap-4 pb-2">
            <a href="{{ route('teacher.classes.index') }}" class="flex-shrink-0 flex flex-col items-center justify-center w-24 h-24 bg-white rounded-[2rem] border border-slate-100 shadow-sm">
                <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-2"><i class="fas fa-layer-group"></i></div>
                <span class="text-[8px] font-black uppercase text-slate-600 tracking-tighter">Classes</span>
            </a>
            <a href="{{ route('teacher.marks.index') }}" class="flex-shrink-0 flex flex-col items-center justify-center w-24 h-24 bg-white rounded-[2rem] border border-slate-100 shadow-sm">
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-2"><i class="fas fa-file-invoice"></i></div>
                <span class="text-[8px] font-black uppercase text-slate-600 tracking-tighter">Marks</span>
            </a>
            <a href="{{ route('teacher.attendance.index') }}" class="flex-shrink-0 flex flex-col items-center justify-center w-24 h-24 bg-white rounded-[2rem] border border-slate-100 shadow-sm">
                <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center mb-2"><i class="fas fa-calendar-check"></i></div>
                <span class="text-[8px] font-black uppercase text-slate-600 tracking-tighter">Roll Call</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Grid (2x2 Mobile, 4 Desktop) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
        <div class="bg-white p-5 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between transition-all hover:shadow-md italic-none">
            <div class="flex justify-between items-start mb-4">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">My Classes</p>
                <div class="w-8 h-8 bg-blue-50 rounded-xl flex items-center justify-center text-blue-400 text-xs shadow-sm"><i class="fas fa-school"></i></div>
            </div>
            <h3 class="text-xl md:text-2xl font-black text-slate-800 tracking-tighter">{{ $assignedClassesCount ?? 0 }}</h3>
            <span class="mt-2 text-[8px] md:text-[9px] font-black text-emerald-500 uppercase tracking-tighter">Assigned Arms</span>
        </div>

        <div class="bg-white p-5 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between transition-all hover:shadow-md italic-none">
            <div class="flex justify-between items-start mb-4">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Subjects</p>
                <div class="w-8 h-8 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-400 text-xs shadow-sm"><i class="fas fa-book"></i></div>
            </div>
            <h3 class="text-xl md:text-2xl font-black text-slate-800 tracking-tighter">{{ $assignedSubjectsCount ?? 0 }}</h3>
            <span class="mt-2 text-[8px] md:text-[9px] font-black text-slate-400 uppercase tracking-tighter">Active Courses</span>
        </div>

        <div class="bg-white p-5 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between transition-all hover:shadow-md italic-none">
            <div class="flex justify-between items-start mb-4">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Students</p>
                <div class="w-8 h-8 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-400 text-xs shadow-sm"><i class="fas fa-users"></i></div>
            </div>
            <h3 class="text-xl md:text-2xl font-black text-slate-800 tracking-tighter">{{ $totalStudentsCount ?? 0 }}</h3>
            <span class="mt-2 text-[8px] md:text-[9px] font-black text-emerald-500 uppercase tracking-tighter">Class Total</span>
        </div>

        <div class="bg-white p-5 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between transition-all hover:shadow-md italic-none">
            <div class="flex justify-between items-start mb-4">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Pending</p>
                <div class="w-8 h-8 bg-orange-50 rounded-xl flex items-center justify-center text-orange-400 text-xs shadow-sm"><i class="fas fa-tasks"></i></div>
            </div>
            <h3 class="text-xl md:text-2xl font-black {{ ($pendingTasks ?? 0) > 0 ? 'text-red-600' : 'text-slate-800' }} tracking-tighter">{{ $pendingTasks ?? 0 }}</h3>
            <span class="mt-2 text-[8px] md:text-[9px] font-black text-orange-500 uppercase tracking-tighter">Assignments</span>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            <!-- My Current Schedule Card -->
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest italic-none">My Current Schedule</h4>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">Teaching distribution for today</p>
                    </div>
                    <div class="w-12 h-12 bg-slate-50 text-slate-300 rounded-2xl flex items-center justify-center border border-slate-100 shadow-inner italic-none">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- NEXT SLOT HIGHLIGHT -->
                    @if(isset($nextSlot))
                    <div class="p-6 bg-blue-600 rounded-[2rem] shadow-xl shadow-blue-200 border border-blue-500 mb-8 group transition-all transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-white mr-5 italic-none">
                                    <i class="fas fa-clock animate-pulse text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-[8px] font-black text-blue-200 uppercase tracking-[0.2em] italic-none">Up Next</p>
                                    <h5 class="text-base font-black text-white uppercase italic-none">{{ $nextSlot->subject->name }}</h5>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-white italic-none leading-none">{{ date('h:i A', strtotime($nextSlot->start_time)) }}</p>
                                <p class="text-[8px] font-black text-blue-200 uppercase mt-2 italic-none">{{ $nextSlot->schoolClass->full_name }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- TODAYS TIMETABLE LIST (WITH TIME) -->
                    @forelse($todaySchedule ?? [] as $slot)
                    <div class="flex items-center justify-between p-6 bg-slate-50 rounded-[2rem] border border-slate-100 group transition-all hover:bg-white hover:shadow-xl hover:shadow-slate-200/50">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-blue-600 mr-4 shadow-sm italic-none border border-slate-100">
                                <i class="fas fa-book-open text-xs"></i>
                            </div>
                            <div>
                                <h5 class="text-xs font-black text-slate-700 uppercase italic-none">{{ $slot->subject->name }}</h5>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter mt-1 italic-none">{{ $slot->schoolClass->full_name }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-black text-slate-800 italic-none uppercase tracking-widest leading-none">{{ date('h:i A', strtotime($slot->start_time)) }}</p>
                            <p class="text-[8px] font-bold text-slate-400 uppercase mt-1 italic-none">{{ date('h:i A', strtotime($slot->end_time)) }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="py-12 text-center border-2 border-dashed border-slate-100 rounded-[2.5rem] italic-none">
                        <i class="fas fa-calendar-day text-slate-200 text-4xl mb-4"></i>
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">No classes scheduled for today</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- ANNOUNCEMENTS SECTION -->
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest italic-none">School Announcements</h4>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">Latest updates from the directorate</p>
                    </div>
                    <i class="fas fa-bullhorn text-slate-200 text-xl italic-none"></i>
                </div>
                
                <div class="space-y-6">
                    @forelse($notices as $notice)
                    <div class="p-6 bg-slate-50 rounded-[2.5rem] border border-slate-100 transition-all hover:bg-blue-50/30">
                        <div class="flex items-center space-x-4 mb-4">
                            <span class="px-3 py-1 {{ $notice->priority == 'urgent' ? 'bg-red-600' : 'bg-blue-600' }} text-white text-[8px] font-black rounded-lg uppercase tracking-widest shadow-lg italic-none">{{ $notice->priority }}</span>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic-none">{{ $notice->created_at->format('M d, Y') }}</span>
                        </div>
                        <h5 class="text-sm font-black text-slate-800 uppercase italic-none">{{ $notice->title }}</h5>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed italic-none font-medium line-clamp-2">{{ $notice->content }}</p>
                    </div>
                    @empty
                    <div class="py-12 text-center border-2 border-dashed border-slate-100 rounded-[2.5rem] italic-none">
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">No active announcements</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Quick Portal & Profile Summary -->
        <div class="space-y-8">
            <!-- Terminal Assessment Card -->
            <div class="bg-blue-900 rounded-[3rem] p-10 text-white shadow-2xl shadow-blue-200 relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-blue-300 uppercase tracking-widest mb-6 italic-none">Academic Portal</p>
                    <h4 class="text-xl font-black uppercase italic-none leading-tight mb-8">Ready to record termly assessment?</h4>
                    <a href="{{ route('teacher.marks.index') }}" class="inline-block px-8 py-4 bg-blue-600 hover:bg-white hover:text-blue-900 transition-all rounded-2xl text-[10px] font-black uppercase tracking-widest italic-none shadow-lg">
                        Open Marks Entry
                    </a>
                </div>
                <i class="fas fa-certificate absolute -bottom-10 -right-10 text-[160px] opacity-10 group-hover:scale-110 transition-transform duration-700 italic-none"></i>
            </div>

            <!-- Profile Summary Card -->
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm text-center">
                <div class="w-24 h-24 rounded-[2rem] bg-slate-50 border-4 border-white shadow-xl mx-auto overflow-hidden mb-4">
                    @if(Auth::user()->teacher?->photo)
                        <img src="{{ asset('storage/'.Auth::user()->teacher->photo) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-300 italic-none">
                            <i class="fas fa-user-tie text-3xl"></i>
                        </div>
                    @endif
                </div>
                <h4 class="text-sm font-black text-slate-800 uppercase italic-none leading-none">{{ Auth::user()->name }}</h4>
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-2 italic-none">Staff ID: {{ Auth::user()->teacher?->staff_id ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</x-teacher-layout>