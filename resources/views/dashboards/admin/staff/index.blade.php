<x-admin-layout>
    <div class="max-w-6xl mx-auto pb-24">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Staff Registry</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em] italic-none">Management of non-academic and support personnel</p>
            </div>
            <!-- THE BUTTON TO ACCESS CREATE PAGE -->
            <a href="{{ route('admin.staff.create') }}" class="px-8 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs italic-none">
                <i class="fas fa-plus-circle mr-2 text-sm"></i> Register Staff Member
            </a>
        </div>

        <!-- Staff Table Card -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-6">Staff Member</th>
                            <th class="px-8 py-6">System Role</th>
                            <th class="px-8 py-6">Designation</th>
                            <th class="px-8 py-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($staff as $member)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-7">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden mr-4 shrink-0 shadow-sm flex items-center justify-center italic-none">
                                        @if($member->photo)
                                            <img src="{{ asset('storage/'.$member->photo) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-user-shield text-slate-300"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 uppercase text-sm italic-none group-hover:text-blue-600 transition-colors">{{ $member->user->name }}</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">{{ $member->staff_id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-7">
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[9px] font-black rounded-lg uppercase tracking-widest border border-emerald-100 italic-none">
                                    {{ $member->user->role }}
                                </span>
                            </td>
                            <td class="px-8 py-7">
                                <p class="text-xs font-black text-slate-600 uppercase italic-none">{{ $member->designation }}</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase mt-1 italic-none">{{ $member->phone }}</p>
                            </td>
                            <td class="px-8 py-7 text-right">
                                <button class="w-10 h-10 rounded-xl border border-slate-100 text-slate-300 hover:text-blue-600 hover:bg-blue-50 transition-all inline-flex items-center justify-center italic-none shadow-sm">
                                    <i class="fas fa-pen text-xs"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 text-3xl mb-4 border border-slate-50 border-dashed italic-none">
                                        <i class="fas fa-users-cog"></i>
                                    </div>
                                    <p class="text-slate-300 font-bold uppercase text-[10px] tracking-[0.2em] italic-none">No support staff registered yet</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($staff->hasPages())
                <div class="px-8 py-4 bg-slate-50/50 border-t border-slate-100">
                    {{ $staff->links() }}
                </div>
            @endif
        </div>

        <!-- Registry Info -->
        <div class="mt-12 p-8 bg-blue-900 rounded-[3rem] text-white shadow-2xl relative overflow-hidden group">
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h4 class="text-xl font-black uppercase italic-none mb-2">Staff Access Control</h4>
                    <p class="text-blue-300 text-xs font-medium max-w-xl italic-none leading-relaxed">
                        Accountants and Librarians created here will have specific dashboard access tied to their roles. Ensure you assign the correct role to maintain school data security.
                    </p>
                </div>
                <div class="shrink-0">
                    <i class="fas fa-shield-check text-5xl text-blue-700 opacity-50"></i>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>