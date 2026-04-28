<x-teacher-layout>
    <div class="max-w-7xl mx-auto pb-24" x-data="{ showPublishModal: false }">
        
        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-10 gap-6">
            <div class="flex items-center space-x-5">
                <a href="{{ route('teacher.marks.index') }}" class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 hover:text-blue-600 transition-all shadow-sm italic-none">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h1 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">{{ $subject->name }} — {{ $class->full_name }}</h1>
                    <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest italic-none mt-2">Termly Evaluation Sheet</p>
                </div>
            </div>
        </div>

        <form action="{{ route('teacher.marks.store', [$class->id, $subject->id]) }}" method="POST">
            @csrf
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden mb-10 italic-none">
                <div class="overflow-x-auto no-scrollbar">
                    <table class="w-full text-left border-collapse min-w-[1100px]">
                        <thead>
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                                <th class="px-8 py-6">Student Information</th>
                                <th class="px-2 py-6 text-center">CA 1</th>
                                <th class="px-2 py-6 text-center">CA 2</th>
                                <th class="px-2 py-6 text-center">CA 3</th>
                                <th class="px-2 py-6 text-center">Exam</th>
                                <th class="px-6 py-6">Individual Remarks / Comments</th>
                                <th class="px-4 py-6 text-center">Grade</th>
                                <th class="px-8 py-6 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($students as $student)
                            @php $res = $existingResults[$student->id] ?? null; @endphp
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-8 py-6">
                                    <p class="font-black text-slate-700 uppercase text-sm italic-none">{{ $student->user->name }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter italic-none">{{ $student->admission_number }}</p>
                                </td>
                                <td class="px-2 py-6 text-center">
                                    <input type="number" name="marks[{{ $student->id }}][ca1]" value="{{ (float)($res->ca1 ?? 0) }}" min="0" max="10" step="0.1" class="w-14 py-3 border border-slate-100 bg-slate-50 rounded-xl font-black text-center text-blue-600 focus:bg-white outline-none text-sm italic-none">
                                </td>
                                <td class="px-2 py-6 text-center">
                                    <input type="number" name="marks[{{ $student->id }}][ca2]" value="{{ (float)($res->ca2 ?? 0) }}" min="0" max="10" step="0.1" class="w-14 py-3 border border-slate-100 bg-slate-50 rounded-xl font-black text-center text-blue-600 focus:bg-white outline-none text-sm italic-none">
                                </td>
                                <td class="px-2 py-6 text-center">
                                    <input type="number" name="marks[{{ $student->id }}][ca3]" value="{{ (float)($res->ca3 ?? 0) }}" min="0" max="10" step="0.1" class="w-14 py-3 border border-slate-100 bg-slate-50 rounded-xl font-black text-center text-blue-600 focus:bg-white outline-none text-sm italic-none">
                                </td>
                                <td class="px-2 py-6 text-center">
                                    <input type="number" name="marks[{{ $student->id }}][exam]" value="{{ (float)($res->exam ?? 0) }}" min="0" max="70" step="0.1" class="w-16 py-3 border border-slate-100 bg-slate-50 rounded-xl font-black text-center text-blue-600 focus:bg-white outline-none text-sm italic-none">
                                </td>
                                <!-- INDIVIDUAL REMARK FIELD -->
                                <td class="px-6 py-6">
                                    <input type="text" name="marks[{{ $student->id }}][remarks]" value="{{ $res->remarks ?? '' }}" class="w-full px-4 py-3 border border-slate-100 bg-slate-50 rounded-xl font-bold text-[10px] uppercase focus:bg-white outline-none italic-none placeholder:text-slate-300" placeholder="E.G. EXCELLENT WORK">
                                </td>
                                <td class="px-4 py-6 text-center">
                                    @if($res && $res->grade)
                                        <span class="px-3 py-1 rounded-lg font-black text-xs uppercase italic-none {{ $res->grade == 'A' ? 'bg-emerald-50 text-emerald-600' : 'bg-blue-50 text-blue-600' }}">{{ $res->grade }}</span>
                                    @else
                                        <span class="text-[8px] font-black text-slate-300 uppercase italic-none">Pending</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="text-lg font-black text-slate-800 italic-none tracking-tighter">{{ (float)($res->total ?? 0) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="flex flex-col md:flex-row items-center justify-between px-10 py-8 bg-white border border-slate-100 rounded-[3rem] shadow-2xl">
                <div class="flex items-center text-slate-400 mb-6 md:mb-0">
                    <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center mr-4 border border-slate-100 italic-none"><i class="fas fa-save text-xs"></i></div>
                    <p class="text-[10px] font-bold uppercase tracking-widest italic-none">Progress is saved as draft until finalized</p>
                </div>
                <div class="flex items-center gap-6">
                    <button type="submit" class="px-10 py-5 bg-slate-100 text-slate-600 font-black rounded-2xl hover:bg-slate-200 transition-all uppercase tracking-widest text-[10px] italic-none">Save Draft</button>
                    <button type="button" @click="showPublishModal = true" class="px-12 py-5 bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-100 hover:bg-emerald-700 hover:-translate-y-1 transition-all uppercase tracking-widest text-[10px] italic-none">Finalize & Publish</button>
                </div>
            </div>
        </form>

        <!-- PUBLISH MODAL -->
        <div x-show="showPublishModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <form action="{{ route('teacher.marks.publish', [$class->id, $subject->id]) }}" method="POST" class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl p-12 text-center border border-slate-100">
                @csrf
                <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-[1.5rem] flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner italic-none border border-emerald-100"><i class="fas fa-check-double"></i></div>
                <h3 class="text-2xl font-black text-slate-800 uppercase italic-none mb-2">Publish Scores</h3>
                <p class="text-slate-400 font-medium mb-10 text-[10px] uppercase tracking-widest leading-relaxed italic-none">
                    Confirming will release these marks to students. Please ensure all individual remarks are correct.
                </p>
                <div class="flex flex-col space-y-3">
                    <button type="submit" class="w-full py-5 bg-emerald-600 text-white font-black rounded-2xl shadow-xl uppercase tracking-widest text-[11px] italic-none hover:bg-emerald-700 transition-all">Yes, Release Results</button>
                    <button type="button" @click="showPublishModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px] italic-none">Back to Editor</button>
                </div>
            </form>
        </div>
    </div>
</x-teacher-layout>