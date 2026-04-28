<x-admin-layout>
    <div class="max-w-6xl mx-auto pb-20">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Finance Overview</span>
        </nav>

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-12">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Institutional Finance</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] tracking-[0.2em]">Comprehensive Revenue & Expenditure Oversight</p>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="bg-white px-6 py-3 rounded-2xl border border-slate-100 shadow-sm flex items-center">
                    <div class="w-2 h-2 bg-blue-600 rounded-full mr-3 animate-pulse"></div>
                    <p class="text-[10px] font-black text-slate-700 uppercase tracking-widest italic-none">Fiscal Session: 2024 / 2025</p>
                </div>
            </div>
        </div>

        <!-- Big Number Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- Income Card -->
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm relative overflow-hidden group">
                <div class="flex justify-between items-start mb-6">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic-none">Total Revenue</p>
                    <div class="w-10 h-10 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center border border-emerald-100 shadow-sm italic-none">
                        <i class="fas fa-arrow-down text-xs"></i>
                    </div>
                </div>
                <h3 class="text-4xl font-black text-slate-800 tracking-tighter italic-none">₦{{ number_format($totalIncome, 0) }}</h3>
                <p class="text-[10px] font-bold text-emerald-500 mt-2 uppercase italic-none tracking-widest">General Inflow</p>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-emerald-500"></div>
            </div>

            <!-- Expense Card -->
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm relative overflow-hidden">
                <div class="flex justify-between items-start mb-6">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic-none">Total Expenses</p>
                    <div class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center border border-red-100 shadow-sm italic-none">
                        <i class="fas fa-arrow-up text-xs"></i>
                    </div>
                </div>
                <h3 class="text-4xl font-black text-slate-800 tracking-tighter italic-none">₦{{ number_format($totalExpenses, 0) }}</h3>
                <p class="text-[10px] font-bold text-red-400 mt-2 uppercase italic-none tracking-widest">Operational Outflow</p>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-red-500"></div>
            </div>

            <!-- Net Balance Card -->
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm relative overflow-hidden">
                <div class="flex justify-between items-start mb-6">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic-none">Net Balance</p>
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center border border-blue-100 shadow-sm italic-none">
                        <i class="fas fa-balance-scale text-xs"></i>
                    </div>
                </div>
                <h3 class="text-4xl font-black text-slate-800 tracking-tighter italic-none">₦{{ number_format($netCashflow, 0) }}</h3>
                <p class="text-[10px] font-bold text-blue-400 mt-2 uppercase italic-none tracking-widest">Institutional Profit/Loss</p>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-600"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Navigation Cards -->
            <div class="space-y-6">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-4 italic-none">Management Areas</h4>
                
                <a href="{{ route('admin.finance.fees') }}" class="flex items-center p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mr-5 shadow-inner border border-blue-100 group-hover:bg-blue-600 group-hover:text-white transition-all italic-none">
                        <i class="fas fa-list-ol text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-black text-slate-800 uppercase tracking-tight italic-none">Class Fee List</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic-none">Pricing Strategy</p>
                    </div>
                </a>

                <!-- UPDATED TO GENERAL LEDGER -->
                <a href="{{ route('admin.finance.ledger') }}" class="flex items-center p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center mr-5 shadow-inner border border-slate-100 group-hover:bg-slate-900 group-hover:text-white transition-all italic-none">
                        <i class="fas fa-book text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-black text-slate-800 uppercase tracking-tight italic-none">General Ledger</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic-none">Audit Transactions</p>
                    </div>
                </a>

                <a href="{{ route('admin.finance.payroll') }}" class="flex items-center p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mr-5 shadow-inner border border-purple-100 group-hover:bg-purple-600 group-hover:text-white transition-all italic-none">
                        <i class="fas fa-user-check text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-black text-slate-800 uppercase tracking-tight italic-none">Staff Payroll</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic-none">Salary Commitment</p>
                    </div>
                </a>
            </div>

            <!-- Recent Ledger Activity -->
            <div class="lg:col-span-2 bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                    <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest italic-none">Recent Ledger Activity</h4>
                    <a href="{{ route('admin.finance.ledger') }}" class="text-[10px] font-bold text-blue-600 uppercase tracking-widest hover:underline italic-none transition-all">View Full Ledger</a>
                </div>
                <div class="p-8 flex-1">
                    <div class="space-y-8">
                        @forelse($recentActivity as $activity)
                        <div class="flex items-center justify-between group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-xl {{ $activity->type == 'income' ? 'bg-emerald-50 text-emerald-500' : 'bg-red-50 text-red-500' }} flex items-center justify-center mr-5 border border-slate-100 italic-none transition-colors">
                                    <i class="fas {{ $activity->type == 'income' ? 'fa-plus' : 'fa-minus' }} text-[10px]"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-700 uppercase italic-none">{{ $activity->title }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase mt-1.5 tracking-widest">
                                        {{ $activity->date->format('d M, Y') }} • <span class="text-slate-300 uppercase">{{ $activity->category }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-base font-black italic-none {{ $activity->type == 'income' ? 'text-emerald-600' : 'text-slate-800' }}">
                                    {{ $activity->type == 'income' ? '+' : '-' }} ₦{{ number_format($activity->amount, 0) }}
                                </p>
                            </div>
                        </div>
                        @empty
                        <div class="py-20 text-center flex flex-col items-center">
                            <i class="fas fa-folder-open text-slate-100 text-5xl mb-4 italic-none"></i>
                            <p class="text-slate-300 font-bold uppercase text-[10px] tracking-[0.2em] italic-none">No records found</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>