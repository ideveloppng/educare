<x-teacher-layout>
    <div class="w-full pb-24"> <!-- Changed to w-full to allow internal scrolling -->
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">My Personal Schedule</span>
        </nav>

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Personal Timetable</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em] italic-none">Your teaching hours and activities for the current term</p>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Status Badge for Desktop Scroll Hint -->
                <div class="flex items-center bg-blue-50 px-5 py-3 rounded-2xl border border-blue-100 italic-none">
                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse mr-3"></div>
                    <p class="text-[10px] font-black text-blue-700 uppercase tracking-widest leading-none">
                        Scroll horizontally to view Friday
                    </p>
                </div>
                
                <button onclick="window.print()" class="px-8 py-4 bg-slate-900 text-white font-black rounded-2xl shadow-xl hover:bg-blue-600 transition-all uppercase tracking-widest text-[10px] italic-none shrink-0">
                    <i class="fas fa-print mr-2"></i> Print Schedule
                </button>
            </div>
        </div>

        <!-- TIMETABLE WRAPPER -->
        <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden relative">
            
            <!-- HORIZONTAL SCROLL CONTAINER: Forced for all devices -->
            <div class="overflow-x-auto no-scrollbar w-full cursor-grab active:cursor-grabbing">
                <!-- TABLE: Min-Width set to 1400px to guarantee Friday's visibility -->
                <table class="w-full border-collapse min-w-[1400px] table-fixed">
                    <thead>
                        <tr class="bg-slate-900 text-white italic-none">
                            <!-- Sticky Time Column -->
                            <th class="p-6 border-r border-slate-800 text-[10px] font-black uppercase tracking-widest text-blue-400 w-40 sticky left-0 bg-slate-900 z-20">
                                Time Slot
                            </th>
                            @foreach($days as $day)
                                <th class="p-6 text-[10px] font-black uppercase tracking-widest text-center border-r border-slate-800 last:border-0">
                                    {{ $day }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 italic-none">
                        @forelse($timeSlots as $slotRow)
                            @php $timeKey = $slotRow->start_time . '-' . $slotRow->end_time; @endphp
                            <tr class="group">
                                <!-- Sticky Time Cell -->
                                <td class="p-6 bg-slate-50 border-r border-slate-200 text-center sticky left-0 z-10 shadow-[5px_0_15px_rgba(0,0,0,0.02)] group-hover:bg-slate-100 transition-colors">
                                    <p class="text-xs font-black text-slate-800 leading-none">{{ date('h:i A', strtotime($slotRow->start_time)) }}</p>
                                    <div class="w-6 h-0.5 bg-blue-200 mx-auto my-3 rounded-full"></div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase leading-none">{{ date('h:i A', strtotime($slotRow->end_time)) }}</p>
                                </td>

                                <!-- Daily Content -->
                                @foreach($days as $day)
                                    <td class="p-4 border-r border-slate-50 last:border-0 vertical-top">
                                        @if(isset($formattedTimetable[$timeKey][$day]))
                                            <div class="space-y-4">
                                                @foreach($formattedTimetable[$timeKey][$day] as $data)
                                                    <div class="p-6 rounded-[2.2rem] border transition-all duration-300 shadow-sm hover:shadow-xl hover:-translate-y-1
                                                        {{ $data->type == 'activity' ? 'bg-orange-50/50 border-orange-100' : 'bg-blue-50/50 border-blue-100' }}">
                                                        
                                                        @if($data->type == 'academic')
                                                            <div class="flex items-center mb-3">
                                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mr-2"></span>
                                                                <span class="text-[9px] font-black text-blue-600 uppercase tracking-[0.2em]">Academic Lesson</span>
                                                            </div>
                                                            <h4 class="text-sm font-black text-slate-800 uppercase leading-tight italic-none tracking-tight">{{ $data->subject->name }}</h4>
                                                            
                                                            <div class="mt-4 pt-4 border-t border-blue-200/30 flex items-center justify-between">
                                                                <div class="flex items-center">
                                                                    <div class="w-7 h-7 bg-white rounded-lg flex items-center justify-center text-blue-600 mr-2 shadow-sm border border-blue-100">
                                                                        <i class="fas fa-users text-[10px]"></i>
                                                                    </div>
                                                                    <span class="text-[10px] font-black text-slate-600 uppercase tracking-tighter">{{ $data->schoolClass->full_name }}</span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="flex items-center mb-3 text-orange-600">
                                                                <i class="fas fa-clock-rotate-left mr-2 text-[10px]"></i>
                                                                <span class="text-[9px] font-black uppercase tracking-[0.2em]">Activity</span>
                                                            </div>
                                                            <h4 class="text-sm font-black text-orange-900 uppercase leading-tight italic-none tracking-tight">{{ $data->activity_name }}</h4>
                                                            <p class="text-[9px] font-bold text-orange-400 uppercase tracking-widest mt-2 italic-none">School Schedule</p>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <!-- Stylish Empty State -->
                                            <div class="h-full min-h-[120px] flex items-center justify-center">
                                                <div class="flex space-x-1.5 opacity-20">
                                                    <div class="w-1.5 h-1.5 bg-slate-300 rounded-full"></div>
                                                    <div class="w-1.5 h-1.5 bg-slate-300 rounded-full"></div>
                                                    <div class="w-1.5 h-1.5 bg-slate-300 rounded-full"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-32 text-center flex flex-col items-center">
                                    <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center text-slate-200 text-4xl mb-6 border border-slate-100 border-dashed italic-none">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                    <p class="text-slate-300 font-black uppercase text-[12px] tracking-[0.3em] italic-none">No active schedule assigned to your profile</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Professional Footer Notice -->
        <div class="mt-12 p-8 bg-white rounded-[3rem] border border-slate-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 italic-none">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mr-5 border border-blue-100 shadow-inner italic-none">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <p class="text-sm font-black text-slate-800 uppercase tracking-widest leading-none mb-1">Schedule Integrity</p>
                    <p class="text-[10px] font-medium text-slate-400 uppercase leading-none tracking-widest">
                        This timetable is dynamically generated based on current workload mapping.
                    </p>
                </div>
            </div>
            <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest italic-none">Reference: TCH-{{ Auth::user()->teacher->staff_id ?? 'SCHED' }}</p>
        </div>

    </div>
</x-teacher-layout>