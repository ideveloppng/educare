<x-admin-layout>
    <div class="max-w-6xl mx-auto pb-24">
        
        <!-- Header -->
        <div class="flex items-center space-x-5 mb-10">
            <a href="{{ route('admin.finance') }}" class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 hover:text-blue-600 transition-all shadow-sm">
                <i class="fas fa-arrow-left text-xs"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">General Ledger</h1>
                <p class="text-slate-400 font-medium mt-1 uppercase text-[10px] font-black tracking-widest italic-none">Complete Audit Trail of Inflow and Outflow</p>
            </div>
        </div>

        <!-- Transaction Table -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-6">Transaction Date</th>
                        <th class="px-8 py-6">Description</th>
                        <th class="px-8 py-6">Type</th>
                        <th class="px-8 py-6">Category</th>
                        <th class="px-8 py-6 text-right">Amount (₦)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6 text-sm font-bold text-slate-400">{{ $trx->date->format('d M, Y') }}</td>
                        <td class="px-8 py-6 font-black text-slate-700 uppercase text-xs">{{ $trx->title }}</td>
                        <td class="px-8 py-6">
                            @if($trx->type === 'income')
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[9px] font-black rounded-lg uppercase tracking-widest border border-emerald-100">
                                    <i class="fas fa-arrow-down mr-1"></i> Credit
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-50 text-red-500 text-[9px] font-black rounded-lg uppercase tracking-widest border border-red-100">
                                    <i class="fas fa-arrow-up mr-1"></i> Debit
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $trx->category }}</span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <span class="text-base font-black italic-none {{ $trx->type === 'income' ? 'text-emerald-600' : 'text-red-500' }}">
                                {{ $trx->type === 'income' ? '+' : '-' }} ₦{{ number_format($trx->amount, 2) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-slate-300 font-black uppercase text-xs">No transactions found in ledger</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $transactions->links() }}
        </div>
    </div>
</x-admin-layout>