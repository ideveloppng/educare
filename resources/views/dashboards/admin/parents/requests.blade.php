<x-admin-layout>
    <div x-data="{ 
        showRejectModal: false, 
        activeRequestId: '', 
        activeParentName: '',
        activeChildName: '' 
    }">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('admin.parents') }}" class="hover:text-blue-600 transition-colors italic-none">Parents Registry</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Linking Requests</span>
        </nav>

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
            <div class="flex items-center space-x-5">
                <a href="{{ route('admin.parents') }}" class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 hover:text-blue-600 transition-all shadow-sm">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Linking Requests</h1>
                    <p class="text-slate-400 font-medium mt-1 uppercase text-[10px] font-black tracking-widest italic-none">Verify family connections and approve portal access</p>
                </div>
            </div>
        </div>

        <!-- Requests Table -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-6">Parent Account</th>
                            <th class="px-8 py-6">Requested Child</th>
                            <th class="px-8 py-6">Date Submitted</th>
                            <th class="px-8 py-6 text-right">Verification Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($requests as $req)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <!-- Parent Column -->
                            <td class="px-8 py-8">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black mr-4 border border-blue-100 italic-none">
                                        <i class="fas fa-user-friends text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 uppercase text-sm italic-none">{{ $req->guardian->user->name }}</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">{{ $req->guardian->phone }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Child Column -->
                            <td class="px-8 py-8">
                                <div>
                                    <p class="font-black text-blue-600 uppercase text-sm italic-none">{{ $req->student_name }}</p>
                                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-1 italic-none">ID: {{ $req->admission_number }}</p>
                                </div>
                            </td>

                            <!-- Date Column -->
                            <td class="px-8 py-8">
                                <span class="text-xs font-bold text-slate-400 uppercase italic-none">
                                    {{ $req->created_at->format('d M, Y • h:i A') }}
                                </span>
                            </td>

                            <!-- Action Column -->
                            <td class="px-8 py-8 text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    <!-- Approval Form -->
                                    <form action="{{ route('admin.parents.requests.process', $req->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100 italic-none">
                                            Approve Link
                                        </button>
                                    </form>

                                    <!-- Rejection Trigger -->
                                    <button @click="activeRequestId = '{{ $req->id }}'; activeParentName = '{{ $req->guardian->user->name }}'; activeChildName = '{{ $req->student_name }}'; showRejectModal = true" 
                                            class="px-6 py-2.5 bg-white border border-slate-200 text-red-500 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-50 hover:text-red-600 transition-all italic-none">
                                        Decline
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-32 text-center flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 text-3xl mb-4 border border-slate-50 border-dashed italic-none">
                                    <i class="fas fa-link"></i>
                                </div>
                                <p class="text-slate-300 font-bold uppercase text-[11px] tracking-[0.2em] italic-none">Queue Clear: No pending link requests</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- REJECT REQUEST MODAL -->
        <!-- ========================================== -->
        <div x-show="showRejectModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <form :action="'/admin/linking-requests/' + activeRequestId + '/process'" method="POST" 
                  x-transition:enter="ease-out duration-300"
                  x-transition:enter-start="opacity-0 scale-95"
                  x-transition:enter-end="opacity-100 scale-100"
                  class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl overflow-hidden p-10 border border-slate-100">
                @csrf
                <input type="hidden" name="action" value="reject">

                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mx-auto mb-4 italic-none shadow-sm"><i class="fas fa-times-circle"></i></div>
                    <h3 class="text-2xl font-black text-slate-800 uppercase italic-none mb-2">Decline Link</h3>
                    <p class="text-slate-400 font-medium text-[10px] uppercase tracking-widest italic-none">
                        Reject connection between <span class="text-slate-800" x-text="activeParentName"></span> and <span class="text-slate-800" x-text="activeChildName"></span>.
                    </p>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1 italic-none">Reason for Rejection (Optional)</label>
                        <textarea name="reason" rows="3" class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold focus:ring-4 focus:ring-red-500/5 outline-none uppercase text-xs italic-none transition-all" placeholder="E.G. ADMISSION NUMBER MISMATCH"></textarea>
                    </div>
                </div>

                <div class="mt-10 flex flex-col space-y-3">
                    <button type="submit" class="w-full py-5 bg-red-600 text-white font-black rounded-2xl shadow-xl uppercase tracking-widest text-[10px] italic-none">Confirm Rejection</button>
                    <button type="button" @click="showRejectModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px] italic-none">Go Back</button>
                </div>
            </form>
        </div>

    </div>
</x-admin-layout>