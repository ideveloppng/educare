<x-admin-layout>
    <div x-data="{ 
        showLinkModal: false, 
        activeParentName: '', 
        activeParentId: '',
        search: '' 
    }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Parent Registry</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-widest">Management of student guardians and family links</p>
            </div>
            <a href="{{ route('admin.parents.create') }}" class="mt-4 md:mt-0 px-8 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all uppercase tracking-widest text-xs">
                <i class="fas fa-user-plus mr-2"></i> Register New Parent
            </a>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50">
                        <th class="px-8 py-6">Parent Info</th>
                        <th class="px-8 py-6">Contact Details</th>
                        <th class="px-8 py-6">Linked Children</th>
                        <th class="px-8 py-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($parents as $parent)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-6 flex items-center">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black mr-4 border border-blue-100 uppercase italic-none">
                                {{ substr($parent->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-black text-slate-800 leading-none uppercase text-sm group-hover:text-blue-600 transition-colors">{{ $parent->user->name }}</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase mt-1 tracking-widest">{{ $parent->occupation ?? 'NOT SPECIFIED' }}</p>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-xs font-bold text-slate-700 italic-none">{{ $parent->phone }}</p>
                            <p class="text-[10px] text-slate-400 font-medium italic-none">{{ $parent->user->email }}</p>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-wrap gap-2">
                                @forelse($parent->students as $child)
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[9px] font-black rounded-lg uppercase tracking-tighter border border-emerald-100">
                                        <i class="fas fa-child mr-1"></i> {{ $child->user->name }}
                                    </span>
                                @empty
                                    <span class="text-[9px] font-bold text-slate-300 uppercase tracking-widest italic-none">No children linked</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <button @click="activeParentId = '{{ $parent->id }}'; activeParentName = '{{ $parent->user->name }}'; showLinkModal = true" 
                                        class="px-4 py-2 bg-slate-900 text-white rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all italic-none shadow-sm">
                                    <i class="fas fa-link mr-1"></i> Link Child
                                </button>
                                <button class="w-9 h-9 rounded-lg border border-slate-100 text-slate-400 hover:text-blue-600 flex items-center justify-center transition-all italic-none">
                                    <i class="fas fa-eye text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-20 text-center text-slate-300 font-black uppercase text-xs">No parents registered</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- LINK STUDENT MODAL -->
        <div x-show="showLinkModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <form :action="'/admin/parents/' + activeParentId + '/link'" method="POST" x-transition.scale.95 
                 class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl overflow-hidden p-10 border border-slate-100">
                @csrf
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-blue-100 shadow-sm italic-none"><i class="fas fa-child"></i></div>
                    <h3 class="text-2xl font-black text-slate-800 uppercase italic-none">Link Student</h3>
                    <p class="text-slate-400 font-medium text-[10px] uppercase tracking-widest mt-2 italic-none">Parent: <span class="text-blue-600" x-text="activeParentName"></span></p>
                </div>
                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1 italic-none">Select Student</label>
                        <!-- In a real app, use a searchable select here. For now, a simple select. -->
                        <select name="student_id" required class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none uppercase text-sm italic-none focus:ring-4 focus:ring-blue-500/5">
                            <option value="">Choose a child...</option>
                            @php
                                $allStudents = \App\Models\Student::where('school_id', auth()->user()->school_id)->with('user')->get();
                            @endphp
                            @foreach($allStudents as $std)
                                <option value="{{ $std->id }}">{{ $std->user->name }} ({{ $std->admission_number }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-10 flex flex-col space-y-3">
                    <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl uppercase tracking-widest text-[10px] italic-none">Confirm Connection</button>
                    <button type="button" @click="showLinkModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px] italic-none">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>