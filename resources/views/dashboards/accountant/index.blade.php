<x-accountant-layout>
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Accounting Dashboard</h1>
            <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em]">Financial performance oversight • {{ now()->format('M Y') }}</p>
        </div>
    </div>

    <!-- Financial Stats Grid (2x2 Mobile, 4 Desktop) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
        <!-- Revenue -->
        <div class="bg-white p-5 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between transition-all hover:shadow-md relative overflow-hidden">
            <div class="flex justify-between items-start mb-4 relative z-10">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none italic-none">Revenue</p>
                <div class="w-8 h-8 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500 text-xs shadow-sm"><i class="fas fa-arrow-down"></i></div>
            </div>
            <h3 class="text-xl md:text-2xl font-black text-slate-800 italic-none relative z-10">₦{{ number_format($totalIncome, 0) }}</h3>
            <span class="mt-2 text-[8px] md:text-[9px] font-black text-emerald-500 uppercase tracking-tighter italic-none relative z-10">Inflow Total</span>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-emerald-500"></div>
        </div>

        <!-- Expenses -->
        <div class="bg-white p-5 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between transition-all hover:shadow-md relative overflow-hidden">
            <div class="flex justify-between items-start mb-4 relative z-10">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none italic-none">Expenses</p>
                <div class="w-8 h-8 bg-red-50 rounded-xl flex items-center justify-center text-red-500 text-xs shadow-sm"><i class="fas fa-arrow-up"></i></div>
            </div>
            <h3 class="text-xl md:text-2xl font-black text-slate-800 italic-none relative z-10">₦{{ number_format($totalExpenses, 0) }}</h3>
            <span class="mt-2 text-[8px] md:text-[9px] font-black text-red-500 uppercase tracking-tighter italic-none relative z-10">Outflow Total</span>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-red-500"></div>
        </div>

        <!-- Pending Collections -->
        <div class="bg-white p-5 md:p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col justify-between transition-all hover:shadow-md relative overflow-hidden">
            <div class="flex justify-between items-start mb-4 relative z-10">
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none italic-none">Unverified</p>
                <div class="w-8 h-8 bg-orange-50 rounded-xl flex items-center justify-center text-orange-500 text-xs shadow-sm"><i class="fas fa-clock"></i></div>
            </div>
            <h3 class="text-xl md:text-2xl font-black text-slate-800 italic-none relative z-10">{{ $pendingFees }}</h3>
            <span class="mt-2 text-[8px] md:text-[9px] font-black text-orange-500 uppercase tracking-tighter italic-none relative z-10">Proofs Pending</span>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-orange-500"></div>
        </div>

        <!-- Net Balance -->
        <div class="bg-slate-900 p-5 md:p-8 rounded-[2.5rem] shadow-2xl shadow-blue-200 flex flex-col justify-between transition-all relative overflow-hidden">
            <div class="flex justify-between items-start mb-4 relative z-10">
                <p class="text-[9px] md:text-[10px] font-black text-blue-300 uppercase tracking-widest leading-none italic-none">Net Balance</p>
                <div class="w-8 h-8 bg-blue-600 rounded-xl flex items-center justify-center text-white text-xs shadow-lg shadow-blue-400"><i class="fas fa-balance-scale"></i></div>
            </div>
            <h3 class="text-xl md:text-2xl font-black text-white italic-none relative z-10">₦{{ number_format($totalIncome - $totalExpenses, 0) }}</h3>
            <span class="mt-2 text-[8px] md:text-[9px] font-black text-blue-400 uppercase tracking-tighter italic-none relative z-10">Available Funds</span>
        </div>
    </div>

    <!-- Secondary Management Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            <!-- Pending Collections Action Card -->
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest italic-none">Unverified Fee Collections</h4>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">Incoming bank transfers awaiting approval</p>
                    </div>
                    <a href="#" class="text-[9px] font-black text-blue-600 uppercase tracking-widest hover:underline italic-none">Go to Ledger</a>
                </div>

                <div class="py-12 text-center border-2 border-dashed border-slate-50 rounded-[2.5rem] bg-slate-50/30 flex flex-col items-center justify-center">
                    <i class="fas fa-hand-holding-usd text-slate-200 text-4xl mb-4"></i>
                    <p class="text-slate-300 font-bold uppercase text-[10px] tracking-widest italic-none">Verification queue is empty</p>
                </div>
            </div>
        </div>

        <!-- Sidebar Payroll Card -->
        <div class="space-y-8">
            <div class="bg-blue-900 rounded-[3rem] p-10 text-white shadow-2xl shadow-blue-200 relative overflow-hidden group">
                <div class="relative z-10">
                    <p class="text-[10px] font-black text-blue-300 uppercase tracking-widest mb-6 italic-none">Personnel Budget</p>
                    <h4 class="text-xl font-black uppercase italic-none leading-tight mb-8">Process Staff Salaries</h4>
                    <p class="text-2xl font-black mb-8 italic-none">₦{{ number_format($monthlyPayroll, 0) }}</p>
                    <a href="{{ route('accountant.payroll') }}" class="inline-block px-8 py-4 bg-blue-600 hover:bg-white hover:text-blue-900 transition-all rounded-2xl text-[10px] font-black uppercase tracking-widest italic-none shadow-lg">
                        Manage Payroll
                    </a>
                </div>
                <i class="fas fa-users-cog absolute -bottom-10 -right-10 text-[160px] opacity-10 group-hover:scale-110 transition-transform duration-700"></i>
            </div>
        </div>
    </div>
</x-accountant-layout>