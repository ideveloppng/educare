<x-super-admin-layout>
    <div x-data="{ 
        showModal: false, 
        activePayment: { school: { name: '' }, plan: { name: '' }, amount: 0 },
        proofUrl: '',
        actionUrl: ''
    }" class="max-w-7xl mx-auto pb-24">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Subscription Revenue</h1>
                <p class="text-slate-400 font-medium mt-1 uppercase text-[10px] font-black tracking-widest italic-none">Verify school payments and authorize portal access</p>
            </div>
        </div>

        <!-- Payments Table -->
        <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-6">Institution</th>
                            <th class="px-8 py-6">Selected Plan</th>
                            <th class="px-8 py-6">Amount</th>
                            <th class="px-8 py-6 text-center">Status</th>
                            <th class="px-8 py-6 text-right">Verification</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 italic-none">
                        @forelse($payments as $pay)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-8">
                                <p class="font-black text-slate-800 uppercase text-sm leading-none">{{ $pay->school->name }}</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $pay->transaction_id }}</p>
                            </td>
                            <td class="px-8 py-8">
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-black rounded-lg border border-blue-100 uppercase">
                                    {{ $pay->plan->name }}
                                </span>
                            </td>
                            <td class="px-8 py-8">
                                <span class="text-lg font-black text-slate-700 tracking-tighter">₦{{ number_format($pay->amount, 0) }}</span>
                            </td>
                            <td class="px-8 py-8 text-center">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border shadow-sm
                                    {{ $pay->status == 'approved' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : '' }}
                                    {{ $pay->status == 'pending' ? 'bg-orange-50 text-orange-600 border-orange-100' : '' }}
                                    {{ $pay->status == 'rejected' ? 'bg-red-50 text-red-600 border-red-100' : '' }}">
                                    {{ $pay->status }}
                                </span>
                            </td>
                            <td class="px-8 py-8 text-right">
                                <button @click="activePayment = {{ $pay->toJson() }}; proofUrl = '{{ asset('storage/'.$pay->proof_of_payment) }}'; actionUrl = '{{ route('super_admin.payments.update', $pay->id) }}'; showModal = true" 
                                        class="px-6 py-3 bg-slate-900 text-white font-black rounded-xl text-[10px] uppercase tracking-widest hover:bg-blue-600 transition-all shadow-lg shadow-slate-200">
                                    Review Proof
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="p-24 text-center text-slate-300 font-black uppercase text-xs italic-none">No payments found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: VERIFICATION INTERFACE -->
        <!-- ========================================== -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <div x-show="showModal" x-transition.scale.95 
                 class="relative bg-white w-full max-w-5xl rounded-[3.5rem] shadow-2xl overflow-hidden border border-slate-100 flex flex-col md:flex-row max-h-[90vh]">
                
                <!-- Proof Viewer (Left) -->
                <div class="md:w-3/5 bg-slate-50 p-6 flex items-center justify-center overflow-hidden border-r border-slate-100 italic-none">
                    <template x-if="proofUrl.toLowerCase().endsWith('.pdf')">
                        <iframe :src="proofUrl" class="w-full h-full min-h-[500px] rounded-3xl border-none shadow-inner"></iframe>
                    </template>
                    <template x-if="!proofUrl.toLowerCase().endsWith('.pdf')">
                        <img :src="proofUrl" class="max-w-full max-h-full object-contain rounded-3xl shadow-2xl border-4 border-white">
                    </template>
                </div>

                <!-- Form Panel (Right) -->
                <div class="md:w-2/5 p-12 bg-white flex flex-col justify-between overflow-y-auto custom-scrollbar italic-none">
                    <div>
                        <h3 class="text-3xl font-black text-slate-800 uppercase tracking-tight leading-none mb-2">Audit Payment</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-10">Institutional Renewal Request</p>

                        <div class="space-y-6 mb-10">
                            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Institution</p>
                                <p class="text-sm font-black text-slate-800 uppercase" x-text="activePayment.school.name"></p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Plan</p>
                                    <p class="text-sm font-black text-blue-600 uppercase" x-text="activePayment.plan.name"></p>
                                </div>
                                <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Amount</p>
                                    <p class="text-sm font-black text-slate-800" x-text="'₦' + Number(activePayment.amount).toLocaleString()"></p>
                                </div>
                            </div>
                        </div>

                        <form :action="actionUrl" method="POST" id="verifyForm">
                            @csrf @method('PATCH')
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 mb-2 block">Audit Internal Notes</label>
                            <textarea name="notes" rows="3" class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none text-xs focus:ring-4 focus:ring-blue-500/5 transition-all uppercase" placeholder="E.G. BANK TRANSFER CONFIRMED IN GTBANK STATEMENT"></textarea>
                        </form>
                    </div>

                    <div class="mt-10 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <button type="submit" form="verifyForm" name="status" value="approved" class="py-5 bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-100 hover:bg-emerald-700 transition-all uppercase tracking-widest text-[11px]">
                                Approve & Extend
                            </button>
                            <button type="submit" form="verifyForm" name="status" value="rejected" class="py-5 bg-white border-2 border-red-100 text-red-600 font-black rounded-2xl hover:bg-red-50 transition-all uppercase tracking-widest text-[11px]">
                                Reject Proof
                            </button>
                        </div>
                        <button @click="showModal = false" class="w-full py-4 text-slate-400 font-black uppercase text-[10px] hover:text-slate-600 transition-colors">Discard & Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-super-admin-layout>