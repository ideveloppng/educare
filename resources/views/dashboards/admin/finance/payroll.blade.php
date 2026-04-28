<x-admin-layout>
    <div class="max-w-6xl mx-auto pb-24">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <a href="{{ route('admin.finance') }}" class="hover:text-blue-600 transition-colors italic-none">Finance</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Staff Payroll</span>
        </nav>

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-12">
            <div class="flex items-center space-x-5">
                <a href="{{ route('admin.finance') }}" class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 hover:text-blue-600 transition-all shadow-sm">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Staff Payroll</h1>
                    <p class="text-slate-400 font-medium mt-1 uppercase text-[10px] tracking-widest italic-none">Monthly salary distribution and staff commitments</p>
                </div>
            </div>
        </div>

        <!-- Payroll Summary Card -->
        <div class="bg-blue-900 rounded-[3rem] p-10 mb-12 text-white shadow-2xl shadow-blue-200 relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div>
                    <p class="text-[10px] font-black text-blue-300 uppercase tracking-[0.3em] mb-4 italic-none">Total Monthly Commitment</p>
                    <h2 class="text-5xl font-black italic-none tracking-tighter">₦{{ number_format($totalPayroll, 2) }}</h2>
                    <div class="mt-6 flex items-center space-x-4">
                        <div class="px-4 py-2 bg-blue-800 rounded-xl border border-blue-700">
                            <span class="text-[9px] font-black text-blue-200 uppercase tracking-widest block italic-none">Total Staff</span>
                            <span class="text-sm font-black italic-none">{{ $teachers->count() }} Members</span>
                        </div>
                        <div class="px-4 py-2 bg-emerald-500/10 rounded-xl border border-emerald-500/20">
                            <span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest block italic-none">Status</span>
                            <span class="text-sm font-black text-emerald-400 italic-none">System Active</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="w-24 h-24 bg-blue-800 rounded-[2rem] flex items-center justify-center border border-blue-700 shadow-xl">
                        <i class="fas fa-users-cog text-3xl text-blue-200"></i>
                    </div>
                </div>
            </div>
            <!-- Decoration -->
            <i class="fas fa-coins absolute -bottom-10 -right-10 text-[200px] opacity-5"></i>
        </div>

        <!-- Staff List Table -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-50 bg-slate-50/30">
                <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest italic-none">Faculty & Staff Breakdown</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                            <th class="px-10 py-6">Staff Member</th>
                            <th class="px-10 py-6">Designation</th>
                            <th class="px-10 py-6">Staff ID</th>
                            <th class="px-10 py-6 text-right">Base Salary</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($teachers as $staff)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-10 py-8">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden mr-4 shrink-0 shadow-sm">
                                        @if($staff->photo)
                                            <img src="{{ asset('storage/'.$staff->photo) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <i class="fas fa-user-tie"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 uppercase text-sm italic-none group-hover:text-blue-600 transition-colors">{{ $staff->user->name }}</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">{{ $staff->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-blue-600 uppercase tracking-tighter italic-none bg-blue-50 px-2 py-1 rounded w-fit border border-blue-100">
                                        {{ $staff->role ?? 'TEACHER' }}
                                    </span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase mt-1 italic-none">{{ $staff->qualification }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <span class="text-sm font-bold text-slate-600 tracking-widest italic-none">{{ $staff->staff_id }}</span>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <span class="text-lg font-black text-slate-900 italic-none">₦{{ number_format($staff->base_salary, 2) }}</span>
                                <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest italic-none">Monthly Net</p>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-10 py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-users-slash text-slate-100 text-5xl mb-4 italic-none"></i>
                                    <p class="text-slate-300 font-bold uppercase text-[10px] tracking-[0.2em] italic-none">No staff records found in payroll</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Information Footer -->
        <div class="mt-8 flex items-center px-8 py-5 bg-white rounded-[2rem] border border-slate-200 w-fit shadow-sm">
            <div class="w-8 h-8 bg-orange-50 text-orange-600 rounded-lg flex items-center justify-center mr-4 border border-orange-100 italic-none">
                <i class="fas fa-info-circle text-[10px]"></i>
            </div>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest italic-none leading-none">
                Salaries are calculated based on the base amounts set during staff registration.
            </p>
        </div>

    </div>
</x-admin-layout>