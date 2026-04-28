<x-teacher-layout>
    <div class="max-w-5xl mx-auto pb-24">
        
        <div class="flex items-center justify-between mb-10">
            <div class="flex items-center space-x-4">
                <a href="{{ route('teacher.attendance.index') }}" class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 hover:text-blue-600 transition-all shadow-sm italic-none"><i class="fas fa-arrow-left text-xs"></i></a>
                <div>
                    <h1 class="text-2xl md:text-3xl font-black text-slate-800 uppercase italic-none">{{ $class->full_name }} Roll Call</h1>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic-none mt-1">Date: {{ now()->format('l, jS F Y') }}</p>
                </div>
            </div>
        </div>

        <form action="{{ route('teacher.attendance.store', $class) }}" method="POST">
            @csrf
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
                <div class="overflow-x-auto no-scrollbar">
                    <table class="w-full text-left border-collapse min-w-[500px]">
                        <thead>
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                                <th class="px-8 py-6">Student Information</th>
                                <th class="px-8 py-6 text-right">Status Selection</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($students as $student)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-6 flex items-center">
                                    <div class="w-10 h-10 rounded-xl overflow-hidden mr-4 border border-slate-200 bg-slate-100 flex items-center justify-center italic-none">
                                        @if($student->student_photo)
                                            <img src="{{ asset('storage/'.$student->student_photo) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-user text-slate-300"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 uppercase text-sm italic-none leading-none">{{ $student->user->name }}</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1.5 italic-none">{{ $student->admission_number }}</p>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="inline-flex p-1.5 bg-slate-100 rounded-2xl gap-2" x-data="{ status: '{{ $existingRecords[$student->id] ?? 'present' }}' }">
                                        <!-- Present -->
                                        <label class="cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="present" class="hidden" x-model="status">
                                            <div :class="status === 'present' ? 'bg-emerald-500 text-white shadow-lg' : 'text-slate-400 hover:text-slate-600'" class="px-4 py-2 rounded-xl text-[9px] font-black uppercase transition-all italic-none">Present</div>
                                        </label>
                                        <!-- Absent -->
                                        <label class="cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="absent" class="hidden" x-model="status">
                                            <div :class="status === 'absent' ? 'bg-red-500 text-white shadow-lg' : 'text-slate-400 hover:text-slate-600'" class="px-4 py-2 rounded-xl text-[9px] font-black uppercase transition-all italic-none">Absent</div>
                                        </label>
                                        <!-- Late -->
                                        <label class="cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}]" value="late" class="hidden" x-model="status">
                                            <div :class="status === 'late' ? 'bg-orange-500 text-white shadow-lg' : 'text-slate-400 hover:text-slate-600'" class="px-4 py-2 rounded-xl text-[9px] font-black uppercase transition-all italic-none">Late</div>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex items-center justify-between px-8 py-6 bg-slate-900 rounded-[2.5rem] shadow-2xl shadow-slate-200">
                <div class="hidden md:flex items-center text-slate-400">
                    <i class="fas fa-info-circle mr-3"></i>
                    <p class="text-[10px] font-bold uppercase tracking-widest italic-none">This register is locked to the current system date.</p>
                </div>
                <button type="submit" class="w-full md:w-auto px-12 py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl hover:bg-blue-700 transition-all uppercase tracking-widest text-xs italic-none">
                    Submit Daily Register
                </button>
            </div>
        </form>
    </div>
</x-teacher-layout>