<x-admin-layout>
    <div class="max-w-6xl mx-auto pb-24">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <a href="{{ route('admin.finance') }}" class="hover:text-blue-600 transition-colors italic-none">Finance</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Class Fee Registry</span>
        </nav>

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
            <div class="flex items-center space-x-5">
                <a href="{{ route('admin.finance') }}" class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 hover:text-blue-600 transition-all shadow-sm">
                    <i class="fas fa-arrow-left text-xs"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Class Fees</h1>
                    <p class="text-slate-400 font-medium mt-1 uppercase text-[10px] tracking-widest italic-none">Institutional pricing structure per academic level</p>
                </div>
            </div>
        </div>

        <!-- Main Classes Table -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-6">Academic Class</th>
                            <th class="px-8 py-6 text-center">Fee Components</th>
                            <th class="px-8 py-6 text-center">Total Termly Amount</th>
                            <th class="px-8 py-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($classes as $class)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <!-- Class Information -->
                            <td class="px-8 py-8">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black mr-4 uppercase text-xs border border-blue-100 italic-none shadow-sm">
                                        {{ substr($class->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 uppercase text-sm italic-none">{{ $class->name }}</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">{{ $class->section ?? 'General Section' }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Item Count -->
                            <td class="px-8 py-8 text-center">
                                <div class="inline-flex items-center px-3 py-1.5 bg-slate-50 rounded-xl border border-slate-100">
                                    <i class="fas fa-layer-group text-slate-300 mr-2 text-[10px]"></i>
                                    <span class="text-[10px] font-black text-slate-600 uppercase italic-none">
                                        {{ $class->fees->count() }} Items Listed
                                    </span>
                                </div>
                            </td>

                            <!-- Total Sum -->
                            <td class="px-8 py-8 text-center">
                                <span class="text-lg font-black text-slate-800 italic-none tracking-tighter">
                                    ₦{{ number_format($class->fees->sum('amount'), 0) }}
                                </span>
                            </td>

                            <!-- Link to Breakdown -->
                            <td class="px-8 py-8 text-right">
                                <a href="{{ route('admin.finance.fees.show', $class) }}" 
                                   class="px-6 py-3 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all shadow-lg shadow-slate-200 italic-none inline-block">
                                    View Fee Breakdown
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-100 text-3xl mb-4 border border-slate-50 border-dashed">
                                        <i class="fas fa-calculator"></i>
                                    </div>
                                    <p class="text-slate-300 font-bold uppercase text-[10px] tracking-[0.2em] italic-none">No academic classes found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Helper Note -->
        <div class="mt-8 flex items-center px-8 py-4 bg-blue-50/50 rounded-2xl border border-blue-100 w-fit">
            <i class="fas fa-info-circle text-blue-600 mr-3 text-xs"></i>
            <p class="text-[10px] font-bold text-blue-800 uppercase tracking-widest italic-none">
                All fees listed above are applied per term for every student in the class.
            </p>
        </div>

    </div>
</x-admin-layout>