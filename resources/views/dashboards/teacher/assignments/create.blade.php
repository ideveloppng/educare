<x-teacher-layout>
    <div class="max-w-5xl mx-auto pb-24">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('teacher.assignments.index') }}" class="hover:text-blue-600 transition-colors italic-none">Assignments</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Publish New Task</span>
        </nav>

        <form action="{{ route('teacher.assignments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden">
                
                <!-- HEADER SECTION -->
                <div class="p-12 border-b border-slate-50 bg-slate-50/30 flex items-center">
                    <div class="w-20 h-20 bg-blue-600 rounded-[1.8rem] flex items-center justify-center text-white shadow-2xl shadow-blue-200 shrink-0 mr-10 italic-none">
                        <i class="fas fa-file-signature text-3xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tight leading-none italic-none">New Assignment</h1>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-3 italic-none">Create and distribute academic tasks to your students</p>
                    </div>
                </div>

                <!-- FORM CONTENT -->
                <div class="p-14 space-y-16">
                    
                    <!-- SECTION 1: TASK IDENTITY -->
                    <section>
                        <div class="flex items-center space-x-6 mb-12">
                            <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black text-xs border border-blue-100 italic-none">01</span>
                            <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.4em] italic-none">Task Identification</h4>
                            <div class="h-px bg-slate-100 flex-1"></div>
                        </div>
                        
                        <div class="space-y-10">
                            <!-- Title -->
                            <div class="space-y-4">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic-none">Assignment Title</label>
                                <div class="relative group">
                                    <i class="fas fa-heading absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                                    <input type="text" name="title" value="{{ old('title') }}" required 
                                        class="w-full pl-14 pr-6 py-5 border border-slate-100 bg-slate-50/50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none text-sm uppercase transition-all shadow-sm italic-none" 
                                        placeholder="E.G. WEEK 4 CONTINUOUS ASSESSMENT">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                                <!-- Target Class/Subject -->
                                <div class="space-y-4">
                                    <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic-none">Target Class & Subject</label>
                                    <div class="relative group">
                                        <i class="fas fa-layer-group absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors"></i>
                                        <select name="workload_id" required 
                                            class="w-full pl-14 pr-12 py-5 border border-slate-100 bg-slate-50/50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none appearance-none text-sm uppercase transition-all shadow-sm italic-none">
                                            <option value="">Select Target Class</option>
                                            @foreach($workload as $item)
                                                <option value="{{ $item->id }}">{{ $item->subject->name }} — {{ $item->schoolClass->full_name }}</option>
                                            @endforeach
                                        </select>
                                        <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none text-[10px]"></i>
                                    </div>
                                </div>

                                <!-- Dynamic Grid for Date and Max Score -->
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="space-y-4">
                                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic-none">Submission Deadline</label>
                                        <input type="datetime-local" name="due_date" required 
                                            class="w-full px-6 py-5 border border-slate-100 bg-slate-50/50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none text-sm transition-all shadow-sm italic-none">
                                    </div>
                                    <div class="space-y-4">
                                        <label class="text-[11px] font-black text-blue-600 uppercase tracking-widest ml-1 italic-none">Overall Mark</label>
                                        <div class="relative group">
                                            <input type="number" name="max_score" value="10" required min="1" 
                                                class="w-full px-6 py-5 border border-blue-100 bg-blue-50/30 rounded-2xl font-black text-xl text-center text-blue-600 focus:ring-8 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all shadow-sm italic-none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- SECTION 2: CONTENT & RESOURCES -->
                    <section>
                        <div class="flex items-center space-x-6 mb-12">
                            <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-black text-xs border border-emerald-100 italic-none">02</span>
                            <h4 class="text-xs font-black text-slate-400 uppercase tracking-[0.4em] italic-none">Instructions & Resources</h4>
                            <div class="h-px bg-slate-100 flex-1"></div>
                        </div>
                        
                        <div class="space-y-10">
                            <!-- Instructions Textarea -->
                            <div class="space-y-4">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic-none">Detailed Instructions</label>
                                <textarea name="description" rows="5" required 
                                    class="w-full px-8 py-8 border border-slate-100 bg-slate-50/50 rounded-[2.5rem] font-bold focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none text-sm italic-none shadow-sm placeholder:text-slate-300" 
                                    placeholder="Provide step-by-step guidance for the students..."></textarea>
                            </div>

                            <!-- File Upload -->
                            <div class="space-y-4">
                                <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic-none">Attach Supporting Material (Optional)</label>
                                <div class="flex items-center bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm border-dashed">
                                    <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 mr-6 italic-none border border-slate-100 shadow-inner">
                                        <i class="fas fa-file-upload"></i>
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" name="attachment" 
                                            class="w-full text-xs text-slate-400 file:mr-6 file:py-3 file:px-8 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-blue-600 file:text-white file:uppercase file:tracking-widest hover:file:bg-blue-700 transition-all cursor-pointer">
                                        <p class="text-[9px] font-bold text-slate-300 uppercase tracking-widest mt-2 ml-1 italic-none">Accepted formats: PDF, DOC, JPG (MAX 10MB)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- ACTION FOOTER -->
                <div class="p-12 bg-slate-50/80 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-10">
                    
                    <!-- Information Security Note -->
                    <div class="flex items-center px-8 py-5 bg-white rounded-[2rem] border border-slate-200 shadow-sm italic-none">
                        <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mr-5 shrink-0 border border-orange-100">
                            <i class="fas fa-info-circle text-lg"></i>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[11px] font-black text-slate-800 uppercase tracking-widest leading-none italic-none">Academic Enforcement</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase leading-none italic-none">Grading will be capped at the <span class="text-blue-600">Max Score</span> set above.</p>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-10">
                        <a href="{{ route('teacher.assignments.index') }}" class="text-xs font-black text-slate-400 hover:text-red-500 uppercase tracking-[0.2em] transition-all italic-none">Discard Draft</a>
                        <button type="submit" class="px-20 py-6 bg-blue-600 text-white font-black rounded-[2.2rem] shadow-2xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-1.5 transition-all active:scale-95 uppercase tracking-[0.1em] text-xs italic-none">
                            Publish Assignment
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-teacher-layout>