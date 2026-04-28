<x-admin-layout>
    <div x-data="{ 
        showCreateModal: false, 
        showDeleteModal: false,
        activeClassName: '',
        activeActionUrl: '',

        triggerDelete(name, url) {
            this.activeClassName = name;
            this.activeActionUrl = url;
            this.showDeleteModal = true;
        }
    }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none">Class Management</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] tracking-[0.2em]">Define academic levels and seat capacity</p>
            </div>
            <button @click="showCreateModal = true" class="mt-4 md:mt-0 px-8 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs">
                <i class="fas fa-plus mr-2"></i> Add New Class
            </button>
        </div>

        <!-- Classes Table -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50">
                            <th class="px-8 py-6">Class Name</th>
                            <th class="px-8 py-6">Section / Arm</th>
                            <th class="px-8 py-6 text-center">Max Capacity</th>
                            <th class="px-8 py-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($classes as $class)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black mr-4 border border-blue-100 uppercase">
                                        {{ substr($class->name, 0, 1) }}
                                    </div>
                                    <p class="font-black text-slate-800 text-base tracking-tight leading-none uppercase">{{ $class->name }}</p>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[10px] font-black rounded-lg uppercase tracking-widest">
                                    {{ $class->section ?? 'No Section' }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="inline-flex items-center space-x-2 bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
                                    <i class="fas fa-users text-blue-400 text-[10px]"></i>
                                    <span class="text-xs font-black text-blue-600">{{ $class->max_capacity }} Seats</span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-end">
                                    <button @click="triggerDelete('{{ $class->name }}', '{{ route('admin.classes.destroy', $class) }}')" 
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
                                    <i class="fas fa-layer-group text-5xl text-slate-100 mb-4"></i>
                                    <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.3em]">No Classes Defined Yet</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- CREATE CLASS MODAL -->
        <!-- ========================================== -->
        <div x-show="showCreateModal" 
            x-cloak 
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md"
            role="dialog" 
            aria-modal="true">
            
            <!-- Modal Content Card -->
            <form action="{{ route('admin.classes.store') }}" 
                method="POST" 
                x-show="showCreateModal" 
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                @click.away="showCreateModal = false"
                class="relative bg-white w-full max-w-md rounded-[3.5rem] shadow-2xl overflow-hidden p-10 border border-slate-100 flex flex-col">
                
                @csrf
                
                <!-- Header Section -->
                <div class="text-center mb-10">
                    <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-[1.8rem] flex items-center justify-center text-3xl mx-auto mb-6 shadow-inner border border-blue-100 italic-none">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Create Class</h3>
                    <p class="text-slate-400 font-medium text-[10px] uppercase tracking-widest mt-3 italic-none">Add a new academic level and arm</p>
                </div>

                <!-- Form Fields -->
                <div class="space-y-6">
                    
                    <!-- Class Name / Level -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 italic-none">Class Level</label>
                        <div class="relative group">
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors">
                                <i class="fas fa-graduation-cap text-sm"></i>
                            </div>
                            <input type="text" name="name" required 
                                class="w-full pl-14 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none uppercase text-sm italic-none transition-all shadow-sm" 
                                placeholder="E.G. JSS 1">
                        </div>
                    </div>

                    <!-- Grid for Arm and Capacity -->
                    <div class="grid grid-cols-2 gap-5">
                        <!-- Section / Arm -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 italic-none">Arm / Section</label>
                            <div class="relative group">
                                <div class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors">
                                    <i class="fas fa-tag text-sm"></i>
                                </div>
                                <input type="text" name="section" required 
                                    class="w-full pl-14 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none uppercase text-sm italic-none transition-all shadow-sm" 
                                    placeholder="E.G. A">
                            </div>
                        </div>

                        <!-- Max Capacity -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 italic-none">Capacity</label>
                            <div class="relative group">
                                <div class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-blue-600 transition-colors">
                                    <i class="fas fa-users text-sm"></i>
                                </div>
                                <input type="number" name="max_capacity" required value="40" min="1" 
                                    class="w-full pl-14 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none text-sm italic-none transition-all shadow-sm" 
                                    placeholder="40">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contextual Info -->
                    <div class="p-4 bg-blue-50/50 rounded-2xl border border-blue-100 flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3 text-xs"></i>
                        <p class="text-[9px] font-bold text-blue-600 uppercase tracking-widest leading-relaxed italic-none">
                            This will create a specific arm. Students and teachers will be assigned to this unique class ID.
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-10 flex flex-col space-y-3">
                    <button type="submit" 
                        class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-1 transition-all active:scale-95 uppercase tracking-widest text-[11px] italic-none">
                        Confirm & Create Class
                    </button>
                    <button type="button" 
                        @click="showCreateModal = false" 
                        class="w-full py-4 bg-white text-slate-400 font-black rounded-2xl hover:text-slate-600 transition-all uppercase tracking-widest text-[10px] italic-none">
                        Discard Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- DELETE MODAL (REMAINS THE SAME) -->
        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div x-show="showDeleteModal" x-transition.opacity @click="showDeleteModal = false" class="absolute inset-0 bg-blue-900/60 backdrop-blur-md"></div>
            <div x-show="showDeleteModal" x-transition.scale.95 class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl overflow-hidden p-10 text-center border border-slate-100">
                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center mx-auto mb-6 text-3xl"><i class="fas fa-trash-alt"></i></div>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight leading-none mb-2">Remove Class?</h3>
                <p class="text-slate-400 font-medium mb-8 leading-relaxed italic-none">You are deleting <span class="text-slate-800 font-black uppercase" x-text="activeClassName"></span>. This action is permanent.</p>
                <div class="flex flex-col space-y-3">
                    <form :action="activeActionUrl" method="POST">@csrf @method('DELETE')
                        <button type="submit" class="w-full py-4 bg-red-600 text-white font-black rounded-2xl shadow-xl shadow-red-100 hover:bg-red-700 transition-all uppercase tracking-widest text-xs">Confirm Deletion</button>
                    </form>
                    <button @click="showDeleteModal = false" class="w-full py-4 bg-white text-slate-400 font-black rounded-2xl hover:text-slate-600 transition-all uppercase tracking-widest text-xs">Keep Class</button>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>