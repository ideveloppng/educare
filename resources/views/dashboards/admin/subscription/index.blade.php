<x-admin-layout>
    <div x-data="{ 
        showPayModal: false, 
        selectedPlan: { id: '', name: '', price: 0 },
        fileName: '' 
    }" class="max-w-6xl mx-auto pb-24">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Subscription Management</span>
        </nav>

        <!-- Current Status Card -->
        <div class="bg-blue-900 rounded-[3rem] p-10 mb-12 text-white shadow-2xl shadow-blue-200 relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div>
                    <span class="px-4 py-1.5 bg-blue-800 text-blue-200 text-[10px] font-black rounded-lg uppercase tracking-widest border border-blue-700 italic-none">
                        Current Status: {{ strtoupper($school->plan) }}
                    </span>
                    <h2 class="text-4xl font-black italic-none tracking-tighter mt-6">
                        @if($daysLeft > 0)
                            Expires in {{ $daysLeft }} {{ Str::plural('Day', $daysLeft) }}
                        @else
                            <span class="text-red-400">Subscription Expired</span>
                        @endif
                    </h2>
                    <p class="text-blue-300 text-xs font-bold uppercase tracking-widest mt-2 italic-none">
                        Renewal Date: {{ $expiryDate ? $expiryDate->format('F d, Y') : 'N/A' }}
                    </p>
                </div>
                <div class="shrink-0">
                    <div class="w-20 h-20 bg-blue-800 rounded-[1.5rem] flex items-center justify-center border border-blue-700 shadow-xl">
                        <i class="fas fa-crown text-3xl text-blue-200"></i>
                    </div>
                </div>
            </div>
            <i class="fas fa-gem absolute -bottom-10 -right-10 text-[180px] opacity-5 italic-none"></i>
        </div>

        <!-- Available Plans Grid -->
        <div class="mb-16">
            <h4 class="text-xs font-black text-slate-800 uppercase tracking-[0.3em] mb-8 ml-4 italic-none">Available Subscription Tiers</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($plans as $plan)
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col transition-all hover:shadow-xl hover:-translate-y-1 group">
                    <h3 class="text-lg font-black text-slate-800 uppercase italic-none">{{ $plan->name }}</h3>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">Full System Access</p>
                    
                    <div class="my-8">
                        <span class="text-3xl font-black text-slate-900 tracking-tighter italic-none">₦{{ number_format($plan->price, 0) }}</span>
                    </div>

                    <button @click="selectedPlan = {id: '{{ $plan->id }}', name: '{{ $plan->name }}', price: '{{ $plan->price }}'}; showPayModal = true" 
                            class="w-full py-4 bg-slate-50 text-blue-600 font-black rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-all uppercase tracking-widest text-[10px] italic-none">
                        Select Plan
                    </button>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Payment History -->
        <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                <h4 class="text-sm font-black text-slate-800 uppercase tracking-widest italic-none">Recent Renewals</h4>
                <i class="fas fa-history text-slate-300"></i>
            </div>
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[9px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50">
                        <th class="px-8 py-5">Reference</th>
                        <th class="px-8 py-5">Plan</th>
                        <th class="px-8 py-5 text-center">Status</th>
                        <th class="px-8 py-5 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($payments as $pay)
                    <tr>
                        <td class="px-8 py-6 text-xs font-bold text-slate-700 italic-none">{{ $pay->transaction_id }}</td>
                        <td class="px-8 py-6 text-xs font-black text-slate-500 uppercase italic-none">{{ $pay->plan->name }}</td>
                        <td class="px-8 py-6 text-center">
                            <span class="px-3 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest border
                                {{ $pay->status == 'approved' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-orange-50 text-orange-600 border-orange-100' }}">
                                {{ $pay->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right font-black text-slate-800 italic-none">₦{{ number_format($pay->amount, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-12 text-center text-slate-300 font-bold uppercase text-[10px]">No transaction history found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: UPLOAD PROOF -->
        <!-- ========================================== -->
        <div x-show="showPayModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            
            <!-- ADDED enctype="multipart/form-data" -->
            <form action="{{ route('admin.subscription.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="relative bg-white w-full max-w-xl rounded-[3.5rem] shadow-2xl border border-slate-100 overflow-hidden flex flex-col italic-none">
                
                @csrf
                <input type="hidden" name="plan_id" x-model="selectedPlan.id">
                <input type="hidden" name="amount" x-model="selectedPlan.price">

                <!-- Modal Header -->
                <div class="p-10 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 uppercase italic-none">Verify Payment</h3>
                        <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-1 italic-none" x-text="'Selected: ' + selectedPlan.name"></p>
                    </div>
                    <button type="button" @click="showPayModal = false" class="text-slate-300 hover:text-red-500"><i class="fas fa-times text-xl"></i></button>
                </div>

                <div class="p-10 space-y-8 bg-white">
                    <!-- Bank Card -->
                    <div class="p-8 bg-blue-900 rounded-[2.5rem] text-white shadow-xl relative overflow-hidden italic-none">
                        <div class="relative z-10">
                            @if($activeBank)
                                <p class="text-[10px] font-black text-blue-300 uppercase tracking-widest mb-4">Subscription Receiving Account</p>
                                <h4 class="text-lg font-black uppercase mb-1">{{ $activeBank->account_name }}</h4>
                                <p class="text-3xl font-black tracking-widest mb-6">{{ $activeBank->account_number }}</p>
                                <p class="text-xs font-bold text-blue-200 uppercase tracking-widest">{{ $activeBank->bank_name }}</p>
                            @else
                                <p class="text-xs font-bold text-red-300 uppercase">Contact System Admin for Bank Details</p>
                            @endif
                            <i class="fas fa-university absolute -bottom-6 -right-6 text-8xl text-white/5"></i>
                        </div>
                    </div>

                    <!-- File Upload Field -->
                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-2 block italic-none">Upload Transfer Receipt</label>
                        <label class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-slate-200 rounded-[2.5rem] bg-slate-50 hover:bg-white hover:border-blue-400 transition-all cursor-pointer group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fas fa-cloud-upload-alt text-4xl text-slate-300 group-hover:text-blue-500 mb-4"></i>
                                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest" x-text="fileName ? 'Ready: ' + fileName : 'Click to select receipt'"></p>
                                <p class="text-[8px] font-bold text-slate-400 uppercase mt-2">PDF, JPEG or PNG (MAX 10MB)</p>
                            </div>
                            <!-- Added proper name="proof" -->
                            <input type="file" name="proof" required class="hidden" @change="fileName = $event.target.files[0].name">
                        </label>
                    </div>
                </div>


                <!-- Footer -->
                <div class="p-10 bg-slate-50 border-t border-slate-100 flex flex-col space-y-4">
                    <div class="flex justify-between items-center mb-2 px-4 italic-none">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Amount:</span>
                        <span class="text-2xl font-black text-slate-900" x-text="'₦' + Number(selectedPlan.price).toLocaleString()"></span>
                    </div>
                    <button type="submit" class="w-full py-6 bg-blue-600 text-white font-black rounded-3xl shadow-xl hover:bg-blue-700 transition-all uppercase tracking-widest text-xs italic-none">
                        Submit Payment Proof
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-admin-layout>