<x-admin-layout>
    <div x-data="{ 
        showCreateModal: false, 
        showDeleteModal: false,
        activeSubjectName: '',
        activeActionUrl: '',

        triggerDelete(name, url) {
            this.activeSubjectName = name;
            this.activeActionUrl = url;
            this.showDeleteModal = true;
        }
    }">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase text-sans">Curriculum / Subjects</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em]">Assign academic subjects to specific school classes</p>
            </div>
            <button @click="showCreateModal = true" class="mt-4 md:mt-0 px-8 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs">
                <i class="fas fa-plus mr-2"></i> Add New Subject
            </button>
        </div>

        <!-- Subjects Table Card -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50">
                            <th class="px-8 py-6">Subject Detail</th>
                            <th class="px-8 py-6">Subject Code</th>
                            <th class="px-8 py-6">Assigned Classes</th>
                            <th class="px-8 py-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($subjects as $subject)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6 flex items-center">
                                <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center font-black mr-4 border border-orange-100 text-lg shadow-sm">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <div>
                                    <p class="font-black text-slate-800 leading-none group-hover:text-blue-600 transition-colors uppercase">{{ $subject->name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase mt-1 tracking-widest">Core Subject</p>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[10px] font-black rounded-lg uppercase tracking-widest border border-slate-200">
                                    {{ $subject->subject_code ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-wrap gap-1.5 max-w-xs">
                                    @forelse($subject->classes as $class)
                                        <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[9px] font-black rounded uppercase border border-blue-100 tracking-tighter">
                                            {{ $class->name }}
                                        </span>
                                    @empty
                                        <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Unassigned</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-end space-x-2">
                                    <button @click="triggerDelete('{{ $subject->name }}', '{{ route('admin.subjects.destroy', $subject) }}')" 
                                            class="w-10 h-10 rounded-xl border border-slate-100 text-slate-300 hover:bg-red-50 hover:text-red-600 transition-all flex items-center justify-center">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 text-3xl mb-4 border border-slate-100 border-dashed">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.3em]">No subjects defined in curriculum</p>
                                    <button @click="showCreateModal = true" class="mt-4 text-blue-600 font-black text-xs uppercase hover:underline tracking-widest">Build Curriculum</button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- CREATE SUBJECT MODAL (NARROW VERSION) -->
        <!-- ========================================== -->
        <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <!-- Backdrop -->
            <div x-show="showCreateModal" x-transition.opacity @click="showCreateModal = false" class="absolute inset-0 bg-blue-900/60 backdrop-blur-md"></div>
            
            <!-- Modal Content (Reduced to max-w-md) -->
            <form action="{{ route('admin.subjects.store') }}" method="POST" x-show="showCreateModal" x-transition.scale.95 
                 class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl overflow-hidden p-8 md:p-10 border border-slate-100">
                @csrf
                
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl shadow-sm mx-auto mb-4">
                        <i class="fas fa-plus"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tight leading-none italic-none">Add Subject</h3>
                    <p class="text-slate-400 font-medium text-[10px] uppercase tracking-widest mt-2 italic-none">Update School Curriculum</p>
                </div>

                <div class="space-y-5">
                    <!-- Name -->
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1">Subject Title</label>
                        <input type="text" name="name" required class="w-full px-5 py-3.5 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none uppercase placeholder:text-slate-300 text-sm" placeholder="e.g. BIOLOGY">
                    </div>

                    <!-- Code -->
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1">Subject Code</label>
                        <input type="text" name="subject_code" class="w-full px-5 py-3.5 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none uppercase placeholder:text-slate-300 text-sm" placeholder="e.g. BIO 101">
                    </div>
                    
                    <!-- Class Selection List -->
                    <div>
                        <label class="text-[10px] font-black text-blue-600 uppercase tracking-widest block mb-3 ml-1">Assign to Classes</label>
                        <div class="space-y-2 max-h-48 overflow-y-auto p-2 bg-slate-50 rounded-2xl border border-slate-100 custom-scrollbar">
                            @foreach($classes as $class)
                            <label class="flex items-center p-3 bg-white rounded-xl border border-slate-100 cursor-pointer hover:border-blue-500 transition-all group">
                                <input type="checkbox" name="class_ids[]" value="{{ $class->id }}" class="w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                                <div class="ml-3">
                                    <span class="block text-xs font-black text-slate-700 uppercase leading-none group-hover:text-blue-600">{{ $class->name }}</span>
                                    <span class="block text-[9px] text-slate-400 font-bold uppercase tracking-tighter mt-1">{{ $class->section ?? 'General' }}</span>
                                </div>
                            </label>
                            @endforeach
                            
                            @if($classes->isEmpty())
                                <div class="p-4 text-center">
                                    <p class="text-[10px] text-orange-500 font-bold uppercase leading-tight">
                                        <i class="fas fa-exclamation-triangle block mb-1 text-lg"></i>
                                        Create a class first
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex flex-col space-y-3">
                    <button type="submit" @if($classes->isEmpty()) disabled @endif class="w-full py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all uppercase tracking-widest text-[10px] disabled:opacity-50 disabled:cursor-not-allowed">
                        Confirm & Save
                    </button>
                    <button type="button" @click="showCreateModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px] tracking-widest hover:text-slate-600 transition-colors">Discard</button>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- DELETE SUBJECT MODAL -->
        <!-- ========================================== -->
        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div x-show="showDeleteModal" x-transition.opacity @click="showDeleteModal = false" class="absolute inset-0 bg-blue-900/60 backdrop-blur-md"></div>
            
            <div x-show="showDeleteModal" x-transition.scale.95 class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl overflow-hidden p-12 text-center border border-slate-100">
                <div class="w-24 h-24 bg-red-50 text-red-500 rounded-[2rem] flex items-center justify-center mx-auto mb-8 text-4xl shadow-inner">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight leading-none mb-3 italic-none">Remove Subject?</h3>
                <p class="text-slate-400 font-medium mb-10 leading-relaxed italic-none">
                    You are removing <span class="text-slate-800 font-black uppercase underline" x-text="activeSubjectName"></span> from the school database. Students will no longer be able to enroll in this subject.
                </p>
                
                <div class="flex flex-col space-y-4">
                    <form :action="activeActionUrl" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full py-5 bg-red-600 text-white font-black rounded-2xl shadow-xl shadow-red-200 hover:bg-red-700 transition-all uppercase tracking-widest text-xs">
                            Confirm Permanent Removal
                        </button>
                    </form>
                    <button @click="showDeleteModal = false" class="w-full py-4 bg-white text-slate-400 font-black rounded-2xl hover:text-slate-600 transition-all uppercase tracking-widest text-xs">
                        Keep Subject
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>