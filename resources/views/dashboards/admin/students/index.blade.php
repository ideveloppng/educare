<x-admin-layout>
    <div x-data="{ 
        showDeleteModal: false, 
        showStatusModal: false,
        activeName: '',
        activeUrl: '',
        activeStatus: '',

        triggerDelete(name, url) {
            this.activeName = name;
            this.activeUrl = url;
            this.showDeleteModal = true;
        },
        triggerStatus(name, url, status) {
            this.activeName = name;
            this.activeUrl = url;
            this.activeStatus = status;
            this.showStatusModal = true;
        }
    }">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase">Student Registry</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] tracking-widest">Database of all enrolled learners</p>
            </div>
            <a href="{{ route('admin.students.create') }}" class="mt-4 md:mt-0 px-8 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all uppercase tracking-widest text-xs">
                <i class="fas fa-plus mr-2"></i> New Admission
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm mb-8 flex flex-wrap items-center gap-4">
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 px-4">Filter:</span>
            @foreach($classes as $class)
                <a href="?class_id={{ $class->id }}" class="px-5 py-2.5 {{ request('class_id') == $class->id ? 'bg-blue-600 text-white shadow-lg' : 'bg-slate-50 text-slate-500 border border-slate-100' }} rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                    {{ $class->name }}
                </a>
            @endforeach
            @if(request('class_id'))
                <a href="{{ route('admin.students') }}" class="text-[10px] font-black text-red-500 ml-auto uppercase tracking-widest px-4">Clear All</a>
            @endif
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50">
                        <th class="px-8 py-6">Student Information</th>
                        <th class="px-8 py-6">Admission No</th>
                        <th class="px-8 py-6">Class Placement</th>
                        <th class="px-8 py-6 text-center">Status</th>
                        <th class="px-8 py-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($students as $student)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-6 flex items-center">
                            <div class="w-12 h-12 rounded-xl border border-slate-100 overflow-hidden mr-4 shrink-0 shadow-sm bg-slate-50 flex items-center justify-center">
                                @if($student->student_photo)
                                    <img src="{{ asset('storage/'.$student->student_photo) }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-user text-slate-200"></i>
                                @endif
                            </div>
                            <div>
                                <p class="font-black text-slate-800 leading-none group-hover:text-blue-600 transition-colors uppercase">{{ $student->user->name }}</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase mt-1 tracking-widest">{{ $student->gender }}</p>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-sm font-black text-slate-700 tracking-tighter">{{ $student->admission_number }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-lg uppercase tracking-widest border border-blue-100">
                                <!-- Use full_name here -->
                                {{ $student->schoolClass->full_name }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @if($student->status === 'active')
                                <span class="text-emerald-500 font-black text-[9px] uppercase tracking-widest flex items-center justify-center">
                                    <i class="fas fa-circle text-[5px] mr-2"></i> Active
                                </span>
                            @else
                                <span class="text-red-400 font-black text-[9px] uppercase tracking-widest flex items-center justify-center">
                                    <i class="fas fa-circle text-[5px] mr-2"></i> Suspended
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.students.show', $student) }}" class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-blue-600 hover:bg-blue-50 flex items-center justify-center transition-all" title="View Profile">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.students.edit', $student) }}" class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-orange-600 hover:bg-orange-50 flex items-center justify-center transition-all" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button @click="triggerStatus('{{ $student->user->name }}', '{{ route('admin.students.toggle', $student) }}', '{{ $student->status }}')" class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-orange-500 hover:bg-orange-50 flex items-center justify-center transition-all" title="Suspend/Activate">
                                    <i class="fas fa-ban"></i>
                                </button>
                                <button @click="triggerDelete('{{ $student->user->name }}', '{{ route('admin.students.destroy', $student) }}')" class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-red-600 hover:bg-red-50 flex items-center justify-center transition-all" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-24 text-center text-slate-300 font-black uppercase text-xs tracking-widest">Registry is empty</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- DELETE MODAL -->
        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div x-transition.opacity @click="showDeleteModal = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-md"></div>
            <div x-transition.scale.95 class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl p-12 text-center border border-slate-100">
                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-[1.5rem] flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner"><i class="fas fa-trash-alt"></i></div>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight leading-none mb-3">Delete Student?</h3>
                <p class="text-slate-400 font-medium mb-10 leading-relaxed italic-none">Permanently remove <span class="text-slate-800 font-black uppercase underline" x-text="activeName"></span> and all their academic history?</p>
                <div class="flex flex-col space-y-3">
                    <form :action="activeUrl" method="POST">@csrf @method('DELETE')
                        <button type="submit" class="w-full py-4 bg-red-600 text-white font-black rounded-2xl shadow-xl shadow-red-100 hover:bg-red-700 transition-all uppercase tracking-widest text-xs">Confirm Delete</button>
                    </form>
                    <button @click="showDeleteModal = false" class="w-full py-4 bg-white text-slate-400 font-bold uppercase tracking-widest text-xs">Keep Student</button>
                </div>
            </div>
        </div>

        <!-- SUSPEND MODAL -->
        <div x-show="showStatusModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div x-transition.opacity @click="showStatusModal = false" class="absolute inset-0 bg-slate-900/60 backdrop-blur-md"></div>
            <div x-transition.scale.95 class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl p-12 text-center border border-slate-100">
                <div class="w-20 h-20 bg-orange-50 text-orange-500 rounded-[1.5rem] flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner"><i class="fas fa-user-shield"></i></div>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight mb-3" x-text="activeStatus === 'active' ? 'Suspend Student?' : 'Activate Student?'"></h3>
                <p class="text-slate-400 font-medium mb-10 leading-relaxed italic-none">
                    Change access for <span class="text-slate-800 font-black uppercase" x-text="activeName"></span>. 
                    <span x-show="activeStatus === 'active'">Suspending prevents the student from checking results.</span>
                </p>
                <div class="flex flex-col space-y-3">
                    <form :action="activeUrl" method="POST">@csrf @method('PATCH')
                        <button type="submit" class="w-full py-4 bg-orange-500 text-white font-black rounded-2xl shadow-xl shadow-orange-100 hover:bg-orange-600 uppercase tracking-widest text-xs" x-text="activeStatus === 'active' ? 'Confirm Suspension' : 'Confirm Activation'"></button>
                    </form>
                    <button @click="showStatusModal = false" class="w-full py-4 bg-white text-slate-400 font-bold uppercase tracking-widest text-xs">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>