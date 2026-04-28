<x-admin-layout>
    <div x-data="{ showModal: false, showDeleteModal: false, activeTitle: '', activeUrl: '' }">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Notice Board</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] tracking-widest italic-none">Broadcast announcements to the school community</p>
            </div>
            <button @click="showModal = true" class="mt-4 md:mt-0 px-8 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs">
                <i class="fas fa-bullhorn mr-2"></i> Create Announcement
            </button>
        </div>

        <!-- Notices Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            @forelse($notices as $notice)
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col transition-all hover:shadow-xl hover:shadow-slate-200/50">
                <div class="p-8 border-b border-slate-50 flex items-start justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center mr-4 shadow-sm italic-none
                            {{ $notice->priority == 'urgent' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }}">
                            <i class="fas {{ $notice->priority == 'urgent' ? 'fa-exclamation-triangle' : 'fa-info-circle' }} text-lg"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-800 uppercase text-sm italic-none leading-tight">{{ $notice->title }}</h3>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">
                                {{ $notice->created_at->format('M d, Y • h:i A') }}
                            </p>
                        </div>
                    </div>
                    <!-- Delete Trigger -->
                    <button @click="activeTitle='{{ $notice->title }}'; activeUrl='{{ route('admin.noticeboard.destroy', $notice) }}'; showDeleteModal=true" 
                            class="text-slate-300 hover:text-red-500 transition-colors">
                        <i class="fas fa-trash-alt text-xs"></i>
                    </button>
                </div>

                <div class="p-8 flex-1">
                    <p class="text-sm text-slate-600 leading-relaxed italic-none">{{ $notice->content }}</p>
                </div>

                <!-- Footer Badges -->
                <div class="px-8 py-5 bg-slate-50 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <span class="px-3 py-1 bg-white border border-slate-200 text-slate-500 text-[9px] font-black rounded-full uppercase tracking-tighter italic-none">
                            Audience: {{ $notice->target_audience }}
                        </span>
                        <span class="px-3 py-1 bg-white border border-slate-200 text-slate-500 text-[9px] font-black rounded-full uppercase tracking-tighter italic-none">
                            Priority: {{ $notice->priority }}
                        </span>
                    </div>
                    <div class="flex items-center text-emerald-500 text-[9px] font-black uppercase tracking-widest italic-none">
                        <i class="fas fa-check-circle mr-1.5"></i> Live
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-32 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-100 flex flex-col items-center">
                <i class="fas fa-bullhorn text-slate-100 text-6xl mb-6"></i>
                <p class="text-slate-400 font-black uppercase text-xs tracking-widest">No Active Announcements Found</p>
            </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $notices->links() }}
        </div>

        <!-- CREATE ANNOUNCEMENT MODAL -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <form action="{{ route('admin.noticeboard.store') }}" method="POST" x-transition.scale.95 
                 class="relative bg-white w-full max-w-xl rounded-[3rem] shadow-2xl overflow-hidden p-10 border border-slate-100">
                @csrf
                <h3 class="text-2xl font-black text-slate-800 uppercase italic-none mb-8 text-center">New Announcement</h3>

                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1 italic-none">Announcement Title</label>
                        <input type="text" name="title" required class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none uppercase text-sm italic-none focus:ring-4 focus:ring-blue-500/5">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1 italic-none">Target Audience</label>
                            <select name="target_audience" required class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none uppercase text-xs italic-none">
                                <option value="all">Everyone</option>
                                <option value="students">Students Only</option>
                                <option value="teachers">Teachers Only</option>
                                <option value="parents">Parents Only</option>
                                <option value="staff">Staff Only</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1 italic-none">Priority Level</label>
                            <select name="priority" required class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none uppercase text-xs italic-none">
                                <option value="low">Low</option>
                                <option value="normal" selected>Normal</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1 italic-none">Message Body</label>
                        <textarea name="content" rows="4" required class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-[2rem] font-bold outline-none text-sm italic-none focus:ring-4 focus:ring-blue-500/5"></textarea>
                    </div>
                </div>

                <div class="mt-10 flex flex-col space-y-3">
                    <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl uppercase tracking-widest text-[10px] italic-none">Post Announcement</button>
                    <button type="button" @click="showModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px] italic-none">Discard</button>
                </div>
            </form>
        </div>

        <!-- CUSTOM DELETE POPUP -->
        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <div x-transition.scale.95 class="relative bg-white w-full max-w-sm rounded-[3rem] shadow-2xl p-10 text-center border border-slate-100">
                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-[1.5rem] flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner border border-red-100 italic-none"><i class="fas fa-trash-alt"></i></div>
                <h3 class="text-xl font-black text-slate-800 uppercase italic-none mb-3">Delete Post?</h3>
                <p class="text-slate-400 font-medium mb-10 leading-relaxed text-xs uppercase italic-none">Remove <span class="text-slate-800 font-black" x-text="activeTitle"></span> from the board?</p>
                <div class="flex flex-col space-y-3">
                    <form :action="activeUrl" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full py-4 bg-red-600 text-white font-black rounded-2xl shadow-xl shadow-red-100 hover:bg-red-700 transition-all uppercase tracking-widest text-[10px] italic-none">Confirm Delete</button>
                    </form>
                    <button @click="showDeleteModal = false" class="w-full py-4 bg-white text-slate-400 font-black rounded-2xl hover:text-slate-600 transition-all uppercase tracking-widest text-[10px] italic-none">Discard</button>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>