<x-student-layout>
    <div class="max-w-7xl mx-auto pb-24">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Class Timetable</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-widest italic-none">Weekly lesson schedule for {{ Auth::user()->student->schoolClass->full_name ?? 'Your Class' }}</p>
            </div>
            <button onclick="window.print()" class="px-8 py-4 bg-white border border-slate-200 text-slate-700 font-black rounded-2xl shadow-sm hover:bg-slate-50 transition-all uppercase tracking-widest text-[10px] italic-none">
                <i class="fas fa-print mr-2"></i> Print Timetable
            </button>
        </div>

        <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-blue-900 text-white italic-none">
                            <th class="p-6 border-r border-blue-800 text-[10px] font-black uppercase tracking-widest text-blue-300 w-32">Time</th>
                            @foreach($days as $day)
                                <th class="p-6 text-[10px] font-black uppercase tracking-widest">{{ $day }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 italic-none">
                        @forelse($timeSlots as $slotRow)
                            @php $timeKey = $slotRow->start_time . '-' . $slotRow->end_time; @endphp
                            <tr>
                                <td class="p-6 bg-slate-50 border-r border-slate-100 text-center">
                                    <p class="text-[11px] font-black text-slate-800">{{ date('h:i A', strtotime($slotRow->start_time)) }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase">{{ date('h:i A', strtotime($slotRow->end_time)) }}</p>
                                </td>
                                @foreach($days as $day)
                                    <td class="p-2 min-w-[180px]">
                                        @if(isset($formattedTimetable[$timeKey][$day]))
                                            @php $data = $formattedTimetable[$timeKey][$day]; @endphp
                                            <div class="p-5 rounded-3xl border shadow-sm transition-all
                                                {{ $data->type == 'activity' ? 'bg-orange-50 border-orange-100' : 'bg-blue-50 border-blue-100' }}">
                                                @if($data->type == 'academic')
                                                    <p class="text-[11px] font-black text-blue-600 uppercase leading-none">{{ $data->subject->name }}</p>
                                                    <p class="text-[9px] font-bold text-slate-500 mt-2 uppercase">{{ $data->teacher->user->name ?? 'Staff TBA' }}</p>
                                                @else
                                                    <p class="text-[11px] font-black text-orange-600 uppercase leading-none">{{ $data->activity_name }}</p>
                                                @endif
                                            </div>
                                        @else
                                            <div class="h-full w-full border-2 border-dashed border-slate-50 rounded-3xl min-h-[80px]"></div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr><td colspan="6" class="p-20 text-center text-slate-300 font-black uppercase text-xs">Timetable not yet published for your class.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-student-layout>