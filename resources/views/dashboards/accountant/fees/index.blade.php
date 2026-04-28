<x-accountant-layout>
    <div class="max-w-6xl mx-auto pb-24" x-data="{ showBreakdown: false, activeClass: {name: '', fees: []} }">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Pricing Reference</span>
        </nav>

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Class Fee List</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em] italic-none">Official termly billings defined by administration</p>
            </div>
            
            <div class="px-6 py-4 bg-white border border-slate-100 rounded-3xl shadow-sm italic-none flex items-center">
                <div class="w-10 h-10 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center mr-4 border border-emerald-100">
                    <i class="fas fa-check-double text-xs"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Fee Status</p>
                    <p class="text-xs font-black text-slate-700 uppercase leading-none">Termly Rates Verified</p>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                            <th class="px-10 py-6">Academic Arm</th>
                            <th class="px-10 py-6 text-center">Components</th>
                            <th class="px-10 py-6 text-center">Total Termly Amount</th>
                            <th class="px-10 py-6 text-right">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($classes as $class)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <!-- Class Information -->
                            <td class="px-10 py-8">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black mr-5 uppercase text-xs border border-blue-100 italic-none shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                        {{ substr($class->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 uppercase text-sm italic-none">{{ $class->full_name }}</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">{{ $class->section ?? 'General Section' }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Item Count -->
                            <td class="px-10 py-8 text-center">
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[9px] font-black rounded-lg uppercase italic-none border border-slate-200">
                                    {{ $class->fees->count() }} Sub-Items
                                </span>
                            </td>

                            <!-- Total Sum -->
                            <td class="px-10 py-8 text-center">
                                <span class="text-lg font-black text-slate-900 italic-none tracking-tighter">
                                    ₦{{ number_format($class->fees->sum('amount'), 0) }}
                                </span>
                            </td>

                            <!-- Breakdown Trigger -->
                            <td class="px-10 py-8 text-right">
                                <button @click="activeClass = {{ $class->load('fees')->toJson() }}; showBreakdown = true" 
                                   class="px-6 py-3 bg-slate-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all shadow-lg shadow-slate-200 italic-none inline-block">
                                    Full Breakdown
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-10 py-24 text-center">
                                <p class="text-slate-300 font-bold uppercase text-[10px] tracking-[0.2em] italic-none">No class fee structures defined</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: ITEMISED FEE BREAKDOWN -->
        <!-- ========================================== -->
        <div x-show="showBreakdown" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <div x-show="showBreakdown" x-transition.scale.95 
                 class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl overflow-hidden border border-slate-100 flex flex-col max-h-[85vh]">
                
                <div class="p-10 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 uppercase italic-none leading-none" x-text="activeClass.name + ' BILLING'"></h3>
                        <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-2 italic-none">Read-Only Price Reference</p>
                    </div>
                    <button @click="showBreakdown = false" class="text-slate-300 hover:text-red-500 transition-colors italic-none"><i class="fas fa-times text-xl"></i></button>
                </div>

                <div class="p-10 space-y-4 overflow-y-auto custom-scrollbar bg-white">
                    <template x-for="fee in activeClass.fees" :key="fee.id">
                        <div class="flex items-center justify-between bg-slate-50 p-5 rounded-2xl border border-slate-100">
                            <div>
                                <p class="text-[10px] font-black text-slate-700 uppercase italic-none leading-none" x-text="fee.title"></p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase mt-1 italic-none">Official Charge</p>
                            </div>
                            <span class="text-sm font-black text-slate-900 italic-none" x-text="'₦' + Number(fee.amount).toLocaleString()"></span>
                        </div>
                    </template>
                </div>

                <div class="p-10 bg-slate-900 flex items-center justify-between">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic-none">Cumulative Total</span>
                    <span class="text-2xl font-black text-white italic-none tracking-tighter" x-text="'₦' + activeClass.fees.reduce((sum, f) => sum + Number(f.amount), 0).toLocaleString()"></span>
                </div>
            </div>
        </div>

        <!-- Protection Note -->
        <div class="mt-8 flex items-center px-8 py-5 bg-white rounded-[2rem] border border-slate-200 w-fit shadow-sm">
            <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center mr-4 border border-blue-100 italic-none">
                <i class="fas fa-shield-alt text-[10px]"></i>
            </div>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest italic-none leading-none">
                Pricing is strictly managed by the Administrative Office. Contact the Principal to modify these rates.
            </p>
        </div>

    </div>
</x-accountant-layout>