<x-accountant-layout>
    <div x-data="{ 
        showModal: false, 
        activePayment: {},
        proofUrl: '',
        actionUrl: '',

        openVerify(payment, proof, url) {
            this.activePayment = payment;
            this.proofUrl = proof;
            this.actionUrl = url;
            this.showModal = true;
        }
    }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Fees Collection</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-widest italic-none">Verify bank transfers and update student accounts</p>
            </div>
        </div>

        <!-- Payments Table -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-6">Student / Ref</th>
                            <th class="px-8 py-6">Amount Paid</th>
                            <th class="px-8 py-6 text-center">Session/Term</th>
                            <th class="px-8 py-6 text-center">Status</th>
                            <th class="px-8 py-6 text-right">Verification</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($payments as $pay)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-7">
                                <p class="font-black text-slate-800 uppercase text-sm italic-none">{{ $pay->student->user->name }}</p>
                                <p class="text-[9px] font-bold text-blue-600 uppercase tracking-widest mt-1 italic-none">{{ $pay->reference }}</p>
                            </td>
                            <td class="px-8 py-7">
                                <span class="text-base font-black text-slate-800 italic-none">₦{{ number_format($pay->amount, 2) }}</span>
                                <p class="text-[8px] font-bold text-slate-400 uppercase italic-none">{{ $pay->method }}</p>
                            </td>
                            <td class="px-8 py-7 text-center">
                                <p class="text-[10px] font-black text-slate-700 uppercase italic-none">{{ $pay->term }}</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase italic-none">{{ $pay->session }}</p>
                            </td>
                            <td class="px-8 py-7 text-center">
                                @php
                                    $statusStyle = [
                                        'pending' => 'bg-orange-50 text-orange-500 border-orange-100',
                                        'approved' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                        'rejected' => 'bg-red-50 text-red-600 border-red-100',
                                    ][$pay->status];
                                @endphp
                                <span class="px-3 py-1 {{ $statusStyle }} text-[9px] font-black rounded-full uppercase tracking-widest border shadow-sm italic-none">
                                    {{ $pay->status }}
                                </span>
                            </td>
                            <td class="px-8 py-7 text-right">
                                <button @click="openVerify({{ $pay->toJson() }}, '{{ asset('storage/'.$pay->proof_of_payment) }}', '{{ route('accountant.collections.verify', $pay) }}')" 
                                        class="px-5 py-2.5 bg-slate-900 text-white font-black rounded-xl text-[9px] uppercase tracking-widest hover:bg-blue-600 transition-all italic-none shadow-lg shadow-slate-200">
                                    Review Proof
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-24 text-center">
                                <i class="fas fa-hand-holding-usd text-slate-100 text-6xl mb-4 italic-none"></i>
                                <p class="text-slate-300 font-bold uppercase text-[10px] tracking-[0.2em] italic-none">No payments found in registry</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: PAYMENT VERIFICATION -->
        <!-- ========================================== -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
            <!-- Backdrop -->
            <div x-show="showModal" x-transition.opacity @click="showModal = false" class="fixed inset-0 bg-slate-900/80 backdrop-blur-md"></div>
            
            <!-- Modal Content -->
            <div x-show="showModal" x-transition.scale.95 
                 class="relative bg-white w-full max-w-4xl rounded-[3.5rem] shadow-2xl overflow-hidden flex flex-col md:flex-row border border-slate-100 max-h-[90vh]">
                
                <!-- Proof Viewer (Left) -->
                <div class="md:w-1/2 bg-slate-50 p-4 border-r border-slate-100 flex items-center justify-center overflow-hidden">
                    <template x-if="proofUrl.toLowerCase().endsWith('.pdf')">
                        <iframe :src="proofUrl" class="w-full h-full rounded-2xl border-none"></iframe>
                    </template>
                    <template x-if="!proofUrl.toLowerCase().endsWith('.pdf')">
                        <img :src="proofUrl" class="max-w-full max-h-full object-contain rounded-2xl shadow-xl border-4 border-white" alt="Payment Proof">
                    </template>
                </div>

                <!-- Form Area (Right) -->
                <div class="md:w-1/2 p-10 flex flex-col bg-white overflow-y-auto custom-scrollbar">
                    <div class="mb-8">
                        <h3 class="text-2xl font-black text-slate-800 uppercase italic-none mb-1">Verify Receipt</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic-none">Reference: <span class="text-blue-600" x-text="activePayment.reference"></span></p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-8 bg-slate-50 p-6 rounded-3xl border border-slate-100 italic-none">
                        <div>
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Payer Name</p>
                            <p class="text-sm font-black text-slate-800 uppercase" x-text="activePayment.student?.user?.name"></p>
                        </div>
                        <div>
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Declared Amount</p>
                            <p class="text-sm font-black text-blue-600" x-text="'₦' + Number(activePayment.amount).toLocaleString()"></p>
                        </div>
                    </div>

                    <form :action="actionUrl" method="POST" class="space-y-6 flex-1">
                        @csrf @method('PATCH')
                        
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2 ml-1 italic-none">Internal Audit Remark</label>
                            <textarea name="admin_notes" rows="3" class="w-full px-6 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none text-xs uppercase italic-none focus:ring-4 focus:ring-blue-500/5 transition-all shadow-sm" placeholder="E.G. TRANSACTION CONFIRMED ON BANK PORTAL"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <button type="submit" name="status" value="approved" class="py-5 bg-emerald-600 text-white font-black rounded-2xl shadow-xl shadow-emerald-100 hover:bg-emerald-700 transition-all uppercase tracking-widest text-[10px] italic-none">
                                <i class="fas fa-check-circle mr-2"></i> Approve
                            </button>
                            <button type="submit" name="status" value="rejected" class="py-5 bg-white border-2 border-red-100 text-red-600 font-black rounded-2xl hover:bg-red-50 transition-all uppercase tracking-widest text-[10px] italic-none">
                                <i class="fas fa-times-circle mr-2"></i> Reject
                            </button>
                        </div>
                    </form>

                    <button type="button" @click="showModal = false" class="mt-8 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 italic-none">Discard & Close</button>
                </div>
            </div>
        </div>

    </div>
</x-accountant-layout>