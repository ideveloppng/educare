<x-student-layout>
    <div class="max-w-6xl mx-auto pb-24" x-data="{ showSubmitModal: false, activeAssignment: {} }">
        <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tight leading-none italic-none mb-10">My Assignments</h1>

        <div class="grid grid-cols-1 gap-8">
            @foreach($assignments as $task)
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col md:flex-row">
                <div class="p-10 flex-1">
                    <div class="flex items-center space-x-4 mb-6">
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[9px] font-black rounded-lg uppercase tracking-widest border border-blue-100 italic-none">{{ $task->subject->name }}</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic-none">Due: {{ $task->due_date->format('M d, h:i A') }}</span>
                    </div>
                    <h3 class="text-xl font-black text-slate-800 uppercase italic-none mb-4">{{ $task->title }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed italic-none">{{ $task->description }}</p>
                    
                    @if($task->file_path)
                        <a href="{{ asset('storage/'.$task->file_path) }}" target="_blank" class="inline-flex items-center mt-6 text-blue-600 font-black text-[10px] uppercase tracking-widest hover:underline italic-none">
                            <i class="fas fa-file-download mr-2"></i> Download Teacher's Resource
                        </a>
                    @endif
                </div>

                <div class="p-10 bg-slate-50 w-full md:w-80 border-l border-slate-100 flex flex-col justify-center text-center">
                    @php $sub = $task->submissions->first(); @endphp
                    
                    @if($sub)
                        <div class="space-y-4">
                            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto"><i class="fas fa-check-circle"></i></div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic-none">Status: {{ strtoupper($sub->status) }}</p>
                            @if($sub->status == 'graded')
                                <h4 class="text-3xl font-black text-slate-800 italic-none">{{ $sub->grade }}/{{ $task->max_score }}</h4>
                                <p class="text-[9px] text-slate-400 italic-none">Feedback: "{{ $sub->teacher_feedback }}"</p>
                            @endif
                        </div>
                    @else
                        <button @click="activeAssignment = {{ $task }}; showSubmitModal = true" class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 uppercase tracking-widest text-[10px] italic-none">
                            Submit Work
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- SUBMIT MODAL -->
        <div x-show="showSubmitModal" x-cloak class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <form :action="'/student/assignments/' + activeAssignment.id + '/submit'" method="POST" enctype="multipart/form-data" class="bg-white w-full max-w-lg rounded-[3rem] p-10 shadow-2xl border border-slate-100">
                @csrf
                <h3 class="text-2xl font-black text-slate-800 uppercase italic-none mb-2">Submit Assignment</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-8 italic-none" x-text="activeAssignment.title"></p>
                
                <div class="space-y-6">
                    <textarea name="student_notes" rows="4" placeholder="ANY NOTES FOR THE TEACHER?" class="w-full px-6 py-5 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none uppercase text-xs italic-none"></textarea>
                    <input type="file" name="attachment" required class="w-full text-xs text-slate-400">
                </div>

                <div class="mt-10 flex flex-col space-y-3">
                    <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl uppercase tracking-widest text-[10px] italic-none">Upload & Submit</button>
                    <button type="button" @click="showSubmitModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px] italic-none">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</x-student-layout>