<x-student-layout>
    <div class="max-w-6xl mx-auto pb-24">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Financial Account</span>
        </nav>

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-12">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Tuition & Fees</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] tracking-[0.2em]">Current Academic Period: {{ Auth::user()->school->current_term }}</p>
            </div>
            <a href="{{ route('student.fees.pay') }}" 
            class="mt-6 md:mt-0 px-10 py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs italic-none">
                <i class="fas fa-credit-card mr-2"></i> Make Online Payment
            </a>
        </div>

        <!-- Status Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- Total Bill -->
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm relative overflow-hidden">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 italic-none">Total Termly Bill</p>
                <h3 class="text-4xl font-black text-slate-800 tracking-tighter italic-none">₦{{ number_format($totalBill, 2) }}</h3>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-slate-200"></div>
            </div>

            <!-- Amount Paid -->
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm relative overflow-hidden">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 italic-none">Amount Paid</p>
                <h3 class="text-4xl font-black text-emerald-600 tracking-tighter italic-none">₦{{ number_format($totalPaid, 2) }}</h3>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-emerald-500"></div>
            </div>

            <!-- Balance -->
            <div class="bg-slate-900 p-8 rounded-[3rem] shadow-2xl shadow-blue-200 relative overflow-hidden">
                <p class="text-[10px] font-black text-blue-300 uppercase tracking-widest mb-4 italic-none">Outstanding Balance</p>
                <h3 class="text-4xl font-black text-white tracking-tighter italic-none">₦{{ number_format($balance, 2) }}</h3>
                <div class="mt-4 flex items-center">
                    @if($balance <= 0)
                        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[9px] font-black rounded-full uppercase border border-emerald-500/30">Cleared</span>
                    @else
                        <span class="px-3 py-1 bg-orange-500/20 text-orange-400 text-[9px] font-black rounded-full uppercase border border-orange-500/30">Pending Payment</span>
                    @endif
                </div>
                <i class="fas fa-wallet absolute -bottom-6 -right-6 text-8xl text-white/5"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Left: Fee Breakdown -->
            <div class="lg:col-span-1 space-y-6">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-4 italic-none">Itemized Billing</h4>
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8 space-y-6">
                    @forelse($classFees as $fee)
                        <div class="flex items-center justify-between border-b border-slate-50 pb-4 last:border-0 last:pb-0">
                            <div>
                                <p class="text-xs font-black text-slate-700 uppercase italic-none">{{ $fee->title }}</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter mt-1 italic-none">Required Component</p>
                            </div>
                            <span class="text-sm font-black text-slate-800 italic-none">₦{{ number_format($fee->amount, 0) }}</span>
                        </div>
                    @empty
                        <p class="text-center text-slate-300 font-bold uppercase text-[10px] py-10">No fees configured for your class</p>
                    @endforelse
                </div>
            </div>

            <!-- Right: Payment History -->
            <div class="lg:col-span-2 space-y-6">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-4 italic-none">Transaction History</h4>
                <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[9px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 border-b border-slate-100">
                                <th class="px-8 py-5">Date</th>
                                <th class="px-8 py-5">Reference</th>
                                <th class="px-8 py-5">Method</th>
                                <th class="px-8 py-5 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($payments as $pay)
                            <tr class="group hover:bg-slate-50 transition-colors">
                                <td class="px-8 py-6 text-xs font-bold text-slate-500 italic-none">{{ $pay->created_at->format('d M, Y') }}</td>
                                <td class="px-8 py-6">
                                    <p class="text-[10px] font-black text-slate-700 uppercase italic-none leading-none">{{ $pay->reference }}</p>
                                    <p class="text-[8px] font-bold text-blue-500 uppercase mt-1 italic-none">Success</p>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[9px] font-black rounded-lg uppercase italic-none">{{ $pay->method }}</span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="text-sm font-black text-emerald-600 italic-none">₦{{ number_format($pay->amount, 2) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-file-invoice-dollar text-slate-100 text-4xl mb-4"></i>
                                        <p class="text-slate-300 font-bold uppercase text-[10px] tracking-widest italic-none">No payments found for this term</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-student-layout>