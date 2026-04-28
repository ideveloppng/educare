<x-accountant-layout>
    <div x-data="{ showModal: false, showDeleteModal: false, activeTitle: '', activeUrl: '' }">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Finance Ledger</span>
        </nav>

        <!-- Header & Stats Summary -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-8">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">General Ledger</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em] italic-none">Full audit trail of institutional cashflow</p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="bg-white px-8 py-4 rounded-[2rem] border border-slate-100 shadow-sm text-center italic-none">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Available Balance</p>
                    <p class="text-xl font-black text-slate-800 tracking-tighter">₦{{ number_format($balance, 2) }}</p>
                </div>
                <button @click="showModal = true" class="px-8 py-5 bg-blue-600 text-white font-black rounded-3xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all uppercase tracking-widest text-xs italic-none">
                    <i class="fas fa-plus mr-2"></i> Record Entry
                </button>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="flex items-center gap-4 mb-8 overflow-x-auto no-scrollbar">
            <a href="{{ route('accountant.ledger') }}" class="px-5 py-2.5 {{ !request('type') ? 'bg-slate-900 text-white shadow-lg' : 'bg-white text-slate-500 border border-slate-100' }} rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">All History</a>
            <a href="?type=income" class="px-5 py-2.5 {{ request('type') == 'income' ? 'bg-emerald-600 text-white shadow-lg' : 'bg-white text-slate-500 border border-slate-100' }} rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Income Only</a>
            <a href="?type=expense" class="px-5 py-2.5 {{ request('type') == 'expense' ? 'bg-red-600 text-white shadow-lg' : 'bg-white text-slate-500 border border-slate-100' }} rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">Expenses Only</a>
        </div>

        <!-- Ledger Table Card -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-6">Transaction Detail</th>
                            <th class="px-8 py-6">Reference Category</th>
                            <th class="px-8 py-6">Date</th>
                            <th class="px-8 py-6 text-right">Value (₦)</th>
                            <th class="px-8 py-6 text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($transactions as $trx)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-7">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-xl {{ $trx->type == 'income' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-red-50 text-red-600 border-red-100' }} border flex items-center justify-center mr-4 shrink-0 italic-none">
                                        <i class="fas {{ $trx->type == 'income' ? 'fa-arrow-down' : 'fa-arrow-up' }} text-[10px]"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 uppercase text-sm italic-none">{{ $trx->title }}</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $trx->type == 'income' ? 'Credit Entry' : 'Debit Entry' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-7">
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[9px] font-black rounded-lg uppercase tracking-tighter italic-none">{{ $trx->category }}</span>
                            </td>
                            <td class="px-8 py-7 text-xs font-bold text-slate-400 uppercase italic-none">
                                {{ $trx->date->format('M d, Y') }}
                            </td>
                            <td class="px-8 py-7 text-right">
                                <span class="text-base font-black italic-none {{ $trx->type == 'income' ? 'text-emerald-600' : 'text-red-500' }}">
                                    {{ $trx->type == 'income' ? '+' : '-' }} ₦{{ number_format($trx->amount, 2) }}
                                </span>
                            </td>
                            <td class="px-8 py-7 text-right">
                                <button @click="activeTitle='{{ $trx->title }}'; activeUrl='{{ route('accountant.ledger.destroy', $trx) }}'; showDeleteModal=true" class="text-slate-300 hover:text-red-600 transition-colors"><i class="fas fa-trash-alt text-xs"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-8 py-24 text-center text-slate-300 font-black uppercase text-xs">No records found for the selected period</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mb-20">
            {{ $transactions->links() }}
        </div>

        <!-- ========================================== -->
        <!-- MODAL: RECORD NEW TRANSACTION -->
        <!-- ========================================== -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <form action="{{ route('accountant.ledger.store') }}" method="POST" x-transition.scale.95 
                 class="relative bg-white w-full max-w-lg rounded-[3.5rem] shadow-2xl overflow-hidden p-10 border border-slate-100">
                @csrf
                <div class="text-center mb-10">
                    <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-[1.8rem] flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner border border-blue-100"><i class="fas fa-calculator"></i></div>
                    <h3 class="text-2xl font-black text-slate-800 uppercase italic-none">New Entry</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 italic-none">Manually update general ledger</p>
                </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="income" class="hidden peer" required checked>
                            <div class="py-4 border-2 border-slate-100 peer-checked:border-emerald-600 peer-checked:bg-emerald-50 peer-checked:text-emerald-600 rounded-2xl text-center text-[10px] font-black uppercase tracking-widest transition-all text-slate-400">Credit (Income)</div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="type" value="expense" class="hidden peer">
                            <div class="py-4 border-2 border-slate-100 peer-checked:border-red-600 peer-checked:bg-red-50 peer-checked:text-red-600 rounded-2xl text-center text-[10px] font-black uppercase tracking-widest transition-all text-slate-400">Debit (Expense)</div>
                        </label>
                    </div>

                    <div class="space-y-4">
                        <input type="text" name="title" required placeholder="Transaction Description (e.g. Sale of Books)" class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none uppercase text-sm italic-none focus:ring-4 focus:ring-blue-500/5">
                        
                        <div class="grid grid-cols-2 gap-4">
                            <input type="text" name="category" required placeholder="Category" class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none uppercase text-sm italic-none focus:ring-4 focus:ring-blue-500/5">
                            <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none italic-none focus:ring-4 focus:ring-blue-500/5">
                        </div>

                        <div class="relative">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-slate-300 italic-none text-xl">₦</span>
                            <input type="number" name="amount" required step="0.01" class="w-full pl-12 pr-6 py-5 border border-slate-100 bg-slate-50 rounded-[1.8rem] font-black text-3xl text-slate-800 outline-none italic-none focus:ring-8 focus:ring-blue-500/5" placeholder="0.00">
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex flex-col space-y-3">
                    <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-[2rem] shadow-xl uppercase tracking-widest text-[11px] italic-none">Post to Ledger</button>
                    <button type="button" @click="showModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px] italic-none">Discard</button>
                </div>
            </form>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: DELETE CONFIRMATION -->
        <!-- ========================================== -->
        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-[120] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <div x-transition.scale.95 class="relative bg-white w-full max-w-sm rounded-[3rem] shadow-2xl p-10 text-center border border-slate-100">
                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-[1.5rem] flex items-center justify-center mx-auto mb-6 text-3xl shadow-inner border border-red-100 italic-none"><i class="fas fa-trash-alt"></i></div>
                <h3 class="text-xl font-black text-slate-800 uppercase italic-none mb-3">Void Transaction?</h3>
                <p class="text-slate-400 font-medium mb-10 leading-relaxed text-xs uppercase italic-none">Remove <span class="text-slate-800 font-black" x-text="activeTitle"></span>? This will revert the institutional balance.</p>
                <div class="flex flex-col space-y-3">
                    <form :action="activeUrl" method="POST">@csrf @method('DELETE')
                        <button type="submit" class="w-full py-4 bg-red-600 text-white font-black rounded-2xl shadow-xl shadow-red-100 hover:bg-red-700 transition-all uppercase tracking-widest text-[10px] italic-none">Confirm Void</button>
                    </form>
                    <button @click="showDeleteModal = false" class="w-full py-4 bg-white text-slate-400 font-black rounded-2xl hover:text-slate-600 transition-all uppercase tracking-widest text-[10px] italic-none">Keep Record</button>
                </div>
            </div>
        </div>

    </div>
</x-accountant-layout>