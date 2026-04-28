<x-teacher-layout>
    <div class="max-w-6xl mx-auto pb-24">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Attendance Register</span>
        </nav>

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-12">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Attendance</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em] italic-none">Daily roll call and historical records management</p>
            </div>
            
            <div class="hidden md:flex items-center bg-white px-5 py-3 rounded-2xl border border-slate-100 shadow-sm">
                <div class="w-2 h-2 bg-emerald-500 rounded-full mr-3 animate-pulse"></div>
                <p class="text-[10px] font-black text-slate-700 uppercase tracking-widest italic-none">Today: {{ now()->format('l, d M') }}</p>
            </div>
        </div>

        <!-- Classes Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($classes as $class)
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden group hover:shadow-xl hover:shadow-blue-500/5 transition-all duration-500 flex flex-col">
                
                <div class="p-8 flex-1">
                    <!-- Icon & Level Info -->
                    <div class="flex items-start justify-between mb-8">
                        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-[1.2rem] flex items-center justify-center text-2xl shadow-inner border border-blue-100 italic-none group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="px-3 py-1 bg-slate-50 text-slate-400 text-[8px] font-black rounded-lg border border-slate-100 uppercase tracking-tighter">Class Room</span>
                    </div>

                    <!-- Class Name -->
                    <h3 class="text-2xl font-black text-slate-800 uppercase italic-none tracking-tight leading-none group-hover:text-blue-600 transition-colors">
                        {{ $class->full_name }}
                    </h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 italic-none">
                        Total Enrolled students: {{ $class->students_count ?? $class->students->count() }}
                    </p>

                    <div class="h-px bg-slate-50 w-full my-8"></div>

                    <!-- Action Buttons -->
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('teacher.attendance.take', $class) }}" class="flex flex-col items-center justify-center py-4 bg-blue-600 text-white rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all group/btn active:scale-95">
                            <i class="fas fa-edit text-xs mb-1.5"></i>
                            <span class="text-[9px] font-black uppercase tracking-widest italic-none">Take Today</span>
                        </a>
                        <a href="{{ route('teacher.attendance.history', $class) }}" class="flex flex-col items-center justify-center py-4 bg-slate-50 text-slate-500 rounded-2xl border border-slate-100 hover:bg-slate-900 hover:text-white transition-all active:scale-95">
                            <i class="fas fa-history text-xs mb-1.5"></i>
                            <span class="text-[9px] font-black uppercase tracking-widest italic-none">View History</span>
                        </a>
                    </div>
                </div>

                <!-- Subtle Status Bar -->
                <div class="px-8 py-4 bg-slate-50/50 border-t border-slate-50 flex items-center justify-between">
                    <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest italic-none">Academic Session: {{ Auth::user()->school->current_session }}</span>
                    <i class="fas fa-chevron-right text-[8px] text-slate-200 group-hover:text-blue-400 transition-colors"></i>
                </div>
            </div>
            @empty
            <div class="col-span-full py-32 text-center bg-white rounded-[3.5rem] border-2 border-dashed border-slate-100 flex flex-col items-center justify-center">
                <div class="w-24 h-24 bg-slate-50 text-slate-200 rounded-[2rem] flex items-center justify-center text-4xl mb-6 italic-none border border-slate-50">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h2 class="text-xl font-black text-slate-800 uppercase italic-none">No Classes Assigned</h2>
                <p class="text-slate-400 mt-2 max-w-sm mx-auto italic-none font-medium text-sm">
                    You haven't been assigned to any classes for attendance. Please check your academic workload with the Admin.
                </p>
            </div>
            @endforelse
        </div>

        <!-- Institutional Footer Note -->
        <div class="mt-12 p-8 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center mr-4 shadow-inner border border-orange-100 italic-none">
                    <i class="fas fa-info-circle text-sm"></i>
                </div>
                <div>
                    <p class="text-[11px] font-black text-slate-800 uppercase tracking-widest leading-none italic-none">Submission Protocol</p>
                    <p class="text-[10px] font-medium text-slate-400 mt-1 italic-none">Registers should be submitted before 10:00 AM daily for accurate school reporting.</p>
                </div>
            </div>
            <a href="#" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline italic-none">System Guidelines</a>
        </div>

    </div>
</x-teacher-layout>