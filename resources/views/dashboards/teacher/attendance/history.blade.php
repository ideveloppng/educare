<x-teacher-layout>
    <div class="max-w-6xl mx-auto pb-24">
        
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('teacher.attendance.index') }}" class="hover:text-blue-600 transition-colors italic-none">Register</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">History</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">{{ $class->full_name }} Registry</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-widest italic-none">Reviewing records for {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Date Selector -->
                <form action="{{ route('teacher.attendance.history', $class) }}" method="GET" class="flex items-center space-x-2">
                    <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()" 
                        class="px-5 py-3.5 border border-slate-200 bg-white rounded-2xl font-black text-xs uppercase focus:ring-4 focus:ring-blue-500/5 transition-all outline-none italic-none">
                </form>

                <a href="{{ route('teacher.attendance.print', ['class' => $class->id, 'date' => $date]) }}" target="_blank" 
                   class="px-8 py-4 bg-slate-900 text-white font-black rounded-2xl shadow-xl hover:bg-blue-600 transition-all uppercase tracking-widest text-xs italic-none">
                    <i class="fas fa-print mr-2"></i> Print Report
                </a>
            </div>
        </div>

        <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                        <th class="px-10 py-6">Student</th>
                        <th class="px-10 py-6">Admission No</th>
                        <th class="px-10 py-6 text-right">Attendance Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($attendance as $row)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-10 py-8">
                            <p class="font-black text-slate-700 uppercase text-sm italic-none">{{ $row->student->user->name }}</p>
                        </td>
                        <td class="px-10 py-8">
                            <span class="text-xs font-bold text-slate-400 uppercase">{{ $row->student->admission_number }}</span>
                        </td>
                        <td class="px-10 py-8 text-right">
                            @php
                                $colors = [
                                    'present' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'absent' => 'bg-red-50 text-red-500 border-red-100',
                                    'late' => 'bg-orange-50 text-orange-600 border-orange-100',
                                ];
                            @endphp
                            <span class="px-4 py-1.5 {{ $colors[$row->status] }} rounded-full text-[9px] font-black uppercase tracking-widest border shadow-sm italic-none">
                                {{ $row->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-10 py-32 text-center">
                            <i class="fas fa-search text-slate-100 text-6xl mb-6 italic-none"></i>
                            <p class="text-slate-300 font-bold uppercase text-[10px] tracking-[0.2em]">No records found for this date</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-teacher-layout>