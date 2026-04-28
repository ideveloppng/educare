<x-teacher-layout>
    <div class="max-w-6xl mx-auto pb-24" x-data="{ showGradeModal: false, activeSub: { student: { user: { name: '' } } }, actionUrl: '' }">
        
        <!-- Breadcrumbs & Back Navigation -->
        <div class="flex items-center space-x-4 mb-10 px-4 md:px-0">
            <a href="{{ route('teacher.assignments.index') }}" class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 hover:text-blue-600 transition-all shadow-sm italic-none shrink-0">
                <i class="fas fa-arrow-left text-xs"></i>
            </a>
            <div class="overflow-hidden">
                <h1 class="text-2xl md:text-3xl font-black text-slate-800 uppercase italic-none tracking-tight truncate">{{ $assignment->title }}</h1>
                <p class="text-slate-400 font-medium uppercase text-[10px] font-black tracking-widest italic-none">Submission & Grading Queue</p>
            </div>
        </div>

        <!-- Submissions Table Card -->
        <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mx-4 md:mx-0">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                            <th class="px-6 md:px-10 py-6">Student Information</th>
                            <th class="px-6 md:px-10 py-6">Date Submitted</th>
                            <th class="px-6 md:px-10 py-6 text-center">Status / Score</th>
                            <th class="px-6 md:px-10 py-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($submissions as $sub)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 md:px-10 py-8">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black mr-4 border border-blue-100 italic-none shadow-sm uppercase text-xs">
                                        {{ substr($sub->student->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-700 uppercase text-sm italic-none">{{ $sub->student->user->name }}</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">{{ $sub->student->admission_number }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 md:px-10 py-8">
                                <span class="text-xs font-bold text-slate-500 uppercase italic-none">
                                    {{ \Carbon\Carbon::parse($sub->submitted_at)->format('M d, h:i A') }}
                                </span>
                            </td>
                            <td class="px-6 md:px-10 py-8 text-center">
                                @if($sub->status == 'graded')
                                    <div class="inline-flex flex-col">
                                        <span class="text-xl font-black text-blue-600 italic-none leading-none">{{ (int)$sub->grade }}<span class="text-[10px]">/{{ $assignment->max_score }}</span></span>
                                        <span class="text-[8px] font-black text-emerald-500 uppercase mt-1">Evaluated</span>
                                    </div>
                                @else
                                    <span class="px-3 py-1 bg-orange-50 text-orange-500 rounded-full text-[9px] font-black uppercase tracking-widest border border-orange-100 shadow-sm">Waiting</span>
                                @endif
                            </td>
                            <td class="px-6 md:px-10 py-8 text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    @if($sub->file_path)
                                        <a href="{{ asset('storage/'.$sub->file_path) }}" target="_blank" 
                                           class="w-10 h-10 bg-slate-50 text-slate-400 rounded-xl flex items-center justify-center border border-slate-100 hover:text-blue-600 hover:bg-white transition-all shadow-sm italic-none">
                                            <i class="fas fa-file-download"></i>
                                        </a>
                                    @endif
                                    <button @click="activeSub = {{ $sub->load('student.user', 'assignment')->toJson() }}; actionUrl = '/teacher/submissions/{{ $sub->id }}/grade'; showGradeModal = true" 
                                            class="px-6 py-2.5 bg-blue-600 text-white font-black rounded-xl text-[10px] uppercase tracking-widest shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all italic-none whitespace-nowrap">
                                        Mark Work
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-10 py-32 text-center flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-100 text-3xl mb-4 border border-slate-50 border-dashed">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <p class="text-slate-300 font-bold uppercase text-[10px] tracking-[0.2em] italic-none">No submissions pending review</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: GRADING INTERFACE (Responsive Fixed) -->
        <!-- ========================================== -->
        <div x-show="showGradeModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
            <!-- Backdrop -->
            <div x-show="showGradeModal" x-transition.opacity @click="showGradeModal = false" class="absolute inset-0 bg-slate-900/80 backdrop-blur-md"></div>
            
            <!-- Modal Content -->
            <form :action="actionUrl" method="POST" x-show="showGradeModal" x-transition.scale.95 
                 class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl overflow-hidden border border-slate-100 flex flex-col">
                @csrf
                
                <div class="p-10 border-b border-slate-50 bg-slate-50/50 text-center">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-[1.2rem] flex items-center justify-center mx-auto mb-6 text-2xl shadow-inner border border-blue-100 italic-none">
                        <i class="fas fa-marker"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 uppercase italic-none mb-1">Evaluate Work</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic-none">Student: <span class="text-blue-600" x-text="activeSub.student?.user?.name"></span></p>
                </div>

                <div class="p-10 space-y-8 bg-white">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-2 block italic-none">
                            Award Score (Max: <span x-text="activeSub.assignment?.max_score"></span>)
                        </label>
                        <div class="relative group">
                            <input type="number" name="grade" required min="0" :max="activeSub.assignment?.max_score" 
                                class="w-full px-6 py-5 bg-slate-50 border border-slate-100 rounded-2xl font-black text-3xl text-center text-blue-600 focus:ring-8 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all italic-none" 
                                x-model="activeSub.grade" placeholder="0">
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-2 block italic-none">Feedback Remarks</label>
                        <textarea name="feedback" rows="3" 
                            class="w-full px-6 py-5 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none text-sm italic-none focus:ring-4 focus:ring-blue-500/5 transition-all shadow-sm" 
                            x-model="activeSub.teacher_feedback" placeholder="Constructive feedback..."></textarea>
                    </div>
                </div>

                <div class="p-10 bg-slate-50 border-t border-slate-100 flex flex-col space-y-3">
                    <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 transition-all uppercase tracking-widest text-[11px] italic-none">
                        Confirm & Publish Grade
                    </button>
                    <button type="button" @click="showGradeModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px] italic-none hover:text-slate-600 transition-colors">Go Back</button>
                </div>
            </form>
        </div>

    </div>
</x-teacher-layout>