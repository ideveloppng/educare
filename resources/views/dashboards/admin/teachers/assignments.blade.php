<x-admin-layout>
    <div x-data="{ 
        showModal: false, 
        showDeleteModal: false,
        activeName: '',
        activeUrl: '',
        triggerDelete(name, url) {
            this.activeName = name;
            this.activeUrl = url;
            this.showDeleteModal = true;
        }
    }">
        
        <!-- Top Navigation & Back Button -->
        <div class="flex items-center space-x-4 mb-8">
            <a href="{{ route('admin.teachers') }}" 
               class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-400 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all shadow-sm group">
                <i class="fas fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <nav class="flex items-center space-x-3 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
                <a href="{{ route('admin.teachers') }}" class="hover:text-blue-600 transition-colors italic-none">Faculty Directory</a>
                <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
                <span class="text-slate-800">Workload Assignments</span>
            </nav>
        </div>

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Academic Workload</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] tracking-[0.2em]">Mapping staff to specific classes & subjects</p>
            </div>
            <button @click="showModal = true" class="mt-4 md:mt-0 px-8 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs">
                <i class="fas fa-link mr-2"></i> Create New Assignment
            </button>
        </div>

        <!-- Assignments Table Card -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50">
                            <th class="px-8 py-6">Faculty Member</th>
                            <th class="px-8 py-6">Subject</th>
                            <th class="px-8 py-6">Class Room</th>
                            <th class="px-8 py-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($assignments as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6 flex items-center">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black mr-4 border border-blue-100 uppercase italic-none shadow-sm">
                                    {{ substr($item->teacher->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-black text-slate-800 leading-none uppercase text-sm group-hover:text-blue-600 transition-colors">{{ $item->teacher->user->name }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase mt-1 tracking-widest">{{ $item->teacher->staff_id }}</p>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 rounded-full bg-orange-400 mr-3"></div>
                                    <span class="text-sm font-black text-slate-700 uppercase italic-none">{{ $item->subject->name }}</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-lg uppercase tracking-widest border border-blue-100 shadow-sm">
                                    {{ $item->schoolClass->name }} ({{ $item->schoolClass->section ?? 'General' }})
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <button @click="triggerDelete('{{ $item->teacher->user->name }}', '{{ route('admin.teachers.assignments.destroy', $item) }}')" 
                                        class="w-10 h-10 rounded-xl border border-slate-100 text-slate-300 hover:bg-red-50 hover:text-red-600 transition-all flex items-center justify-center ml-auto shadow-sm">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 text-3xl mb-4 border border-slate-100 border-dashed">
                                        <i class="fas fa-unlink"></i>
                                    </div>
                                    <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.3em]">No academic assignments registered</p>
                                    <button @click="showModal = true" class="mt-4 text-blue-600 font-black text-xs uppercase hover:underline tracking-widest">Assign Faculty</button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- CREATE ASSIGNMENT MODAL -->
        <!-- ========================================== -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div x-transition.opacity @click="showModal = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-md"></div>
            
            <form action="{{ route('admin.teachers.assignments.store') }}" method="POST" x-show="showModal" x-transition.scale.95 
                 class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl overflow-hidden p-10 border border-slate-100">
                @csrf
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4 border border-blue-100">
                        <i class="fas fa-link"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tight italic-none uppercase">Assign Faculty</h3>
                    <p class="text-slate-400 font-medium text-[10px] uppercase tracking-widest mt-2 italic-none">Link Teacher to Class & Subject</p>
                </div>

                <div class="space-y-6">
                    <!-- Teacher -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Select Staff Member</label>
                        <div class="relative">
                            <select name="teacher_id" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50/50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none appearance-none text-sm uppercase italic-none">
                                <option value="">Choose Teacher</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none text-[10px]"></i>
                        </div>
                    </div>

                    <!-- Subject -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Academic Subject</label>
                        <div class="relative">
                            <select name="subject_id" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50/50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none appearance-none text-sm uppercase italic-none">
                                <option value="">Choose Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none text-[10px]"></i>
                        </div>
                    </div>

                    <!-- Class -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Target Class Room</label>
                        <div class="relative">
                            <select name="school_class_id" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50/50 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none appearance-none text-sm uppercase italic-none">
                                <option value="">Choose Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }} ({{ $class->section ?? 'General' }})</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex flex-col space-y-3">
                    <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all uppercase tracking-widest text-[10px]">
                        Link Staff Member
                    </button>
                    <button type="button" @click="showModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px] tracking-widest hover:text-slate-600 transition-colors">Discard</button>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- DELETE CONFIRMATION MODAL -->
        <!-- ========================================== -->
        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div x-transition.opacity @click="showDeleteModal = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-md"></div>
            <div x-transition.scale.95 class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl p-12 text-center border border-slate-100">
                <div class="w-24 h-24 bg-red-50 text-red-500 rounded-[2rem] flex items-center justify-center mx-auto mb-8 text-4xl shadow-inner border border-red-100">
                    <i class="fas fa-unlink"></i>
                </div>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight leading-none mb-3 italic-none uppercase">Unlink Staff?</h3>
                <p class="text-slate-400 font-medium mb-10 leading-relaxed italic-none">
                    You are unlinking <span class="text-slate-800 font-black uppercase underline" x-text="activeName"></span> from this specific class workload.
                </p>
                <div class="flex flex-col space-y-4">
                    <form :action="activeUrl" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full py-5 bg-red-600 text-white font-black rounded-2xl shadow-xl shadow-red-100 hover:bg-red-700 transition-all uppercase tracking-widest text-xs">Confirm Removal</button>
                    </form>
                    <button @click="showDeleteModal = false" class="w-full py-5 bg-white text-slate-400 font-black rounded-2xl hover:text-slate-600 transition-all uppercase tracking-widest text-xs">Keep Assignment</button>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>