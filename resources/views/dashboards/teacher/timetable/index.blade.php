<x-teacher-layout>
    <div class="max-w-[100%] mx-auto pb-24">
        
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
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em] italic-none">Your assigned teaching hours and school activities</p>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="hidden md:flex items-center bg-blue-50 px-4 py-2 rounded-xl border border-blue-100 italic-none mr-2">
                    <i class="fas fa-info-circle text-blue-500 mr-2 text-xs"></i>
                    <p class="text-[9px] font-black text-blue-600 uppercase">Swipe horizontally to view full week</p>
                </div>
                <button onclick="window.print()" class="px-8 py-4 bg-slate-900 text-white font-black rounded-2xl shadow-xl hover:bg-blue-600 transition-all uppercase tracking-widest text-[10px] italic-none shrink-0">
                    <i class="fas fa-print mr-2"></i> Print Schedule
                </button>
            </div>
        </div>

        <!-- TIMETABLE DATA TABLE -->
        <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden relative">
            <!-- Scroll Container -->
            <div class="overflow-x-auto custom-scrollbar no-scrollbar lg:block">
                <table class="w-full border-collapse min-w-[1100px]"> <!-- Set Min-Width to ensure Friday is never squished -->
                    <thead>
                        <tr class="bg-slate-900 text-white italic-none">
                            <th class="p-6 border-r border-slate-800 text-[10px] font-black uppercase tracking-widest text-blue-400 w-32 sticky left-0 bg-slate-900 z-10">
                                Time
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
                                <!-- Time Column (Sticky for better UX) -->
                                <td class="p-6 bg-slate-50 border-r border-slate-100 text-center sticky left-0 z-10 group-hover:bg-slate-100 transition-colors">
                                    <p class="text-[11px] font-black text-slate-800 leading-none">{{ date('h:i A', strtotime($slotRow->start_time)) }}</p>
                                    <div class="w-4 h-0.5 bg-slate-200 mx-auto my-2"></div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase leading-none">{{ date('h:i A', strtotime($slotRow->end_time)) }}</p>
                                </td>

                                <!-- Daily Content Columns -->
                                @foreach($days as $day)
                                    <td class="p-3 border-r border-slate-50 last:border-0 vertical-top min-w-[200px]">
                                        @if(isset($formattedTimetable[$timeKey][$day]))
                                            <div class="space-y-3">
                                                @foreach($formattedTimetable[$timeKey][$day] as $data)
                                                    <div class="p-5 rounded-[1.8rem] border transition-all duration-300 shadow-sm hover:shadow-md
                                                        {{ $data->type == 'activity' ? 'bg-orange-50/40 border-orange-100' : 'bg-blue-50/40 border-blue-100' }}">
                                                        
                                                        @if($data->type == 'academic')
                                                            <div class="flex items-center mb-2">
                                                                <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2"></div>
                                                                <span class="text-[9px] font-black text-blue-600 uppercase tracking-widest">Lecture</span>
                                                            </div>
                                                            <h4 class="text-sm font-black text-slate-800 uppercase leading-tight italic-none">{{ $data->subject->name }}</h4>
                                                            <div class="mt-3 pt-3 border-t border-blue-100/50 flex items-center justify-between">
                                                                <div class="flex items-center">
                                                                    <i class="fas fa-users text-blue-300 mr-2 text-[10px]"></i>
                                                                    <span class="text-[9px] font-bold text-slate-500 uppercase">{{ $data->schoolClass->full_name }}</span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="flex items-center mb-2 text-orange-600">
                                                                <i class="fas fa-clock-rotate-left mr-2 text-[10px]"></i>
                                                                <span class="text-[9px] font-black uppercase tracking-widest">Institutional</span>
                                                            </div>
                                                            <h4 class="text-sm font-black text-orange-800 uppercase leading-tight italic-none">{{ $data->activity_name }}</h4>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <!-- Empty Slot Design -->
                                            <div class="h-full min-h-[100px] flex items-center justify-center opacity-20">
                                                <div class="w-1 h-1 bg-slate-300 rounded-full mx-1"></div>
                                                <div class="w-1 h-1 bg-slate-300 rounded-full mx-1"></div>
                                                <div class="w-1 h-1 bg-slate-300 rounded-full mx-1"></div>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-24 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 text-3xl mb-4 border border-slate-100 border-dashed italic-none">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <p class="text-slate-300 font-bold uppercase text-[10px] tracking-[0.3em] italic-none">Your personalized timetable is empty</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer Guidance -->
        <div class="mt-10 flex items-center px-8 py-5 bg-white rounded-[2rem] border border-slate-200 w-fit shadow-sm">
            <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mr-4 border border-blue-100 italic-none shadow-inner">
                <i class="fas fa-info-circle text-[10px]"></i>
            </div>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest italic-none leading-none">
                Schedule conflicts? Please report immediately to the Dean of Studies or Academic Registry.
            </p>
        </div>

    </div>
</x-teacher-layout>