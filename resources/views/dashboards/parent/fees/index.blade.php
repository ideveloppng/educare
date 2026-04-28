<x-parent-layout>
    <div class="max-w-6xl mx-auto pb-24">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Family Financials</span>
        </nav>

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-12">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Fees & Payments</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-[0.2em] italic-none">Combined billing for all linked children</p>
            </div>
            <div class="mt-6 md:mt-0 flex items-center bg-white px-6 py-3 rounded-2xl border border-slate-100 shadow-sm italic-none">
                <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse mr-3"></div>
                <p class="text-[10px] font-black text-slate-700 uppercase tracking-widest leading-none">Status: Active Billing</p>
            </div>
        </div>

        <!-- Grand Totals Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <!-- Total Family Debt -->
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm relative overflow-hidden">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 italic-none">Total Family Bill</p>
                <h3 class="text-4xl font-black text-slate-800 tracking-tighter italic-none">₦{{ number_format($grandTotalBill, 2) }}</h3>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-slate-100"></div>
            </div>

            <!-- Total Paid -->
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm relative overflow-hidden">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 italic-none">Total Amount Paid</p>
                <h3 class="text-4xl font-black text-emerald-600 tracking-tighter italic-none">₦{{ number_format($grandTotalPaid, 2) }}</h3>
                <div class="absolute bottom-0 left-0 w-full h-1 bg-emerald-500"></div>
            </div>

            <!-- Net Balance -->
            <div class="bg-slate-900 p-8 rounded-[3rem] shadow-2xl shadow-blue-200 relative overflow-hidden">
                <p class="text-[10px] font-black text-blue-300 uppercase tracking-widest mb-4 italic-none">Outstanding Balance</p>
                <h3 class="text-4xl font-black text-white tracking-tighter italic-none">₦{{ number_format($grandBalance, 2) }}</h3>
                <div class="mt-4">
                    @if($grandBalance <= 0)
                        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[9px] font-black rounded-full border border-emerald-500/30 uppercase italic-none">Cleared</span>
                    @else
                        <span class="px-3 py-1 bg-red-500/20 text-red-400 text-[9px] font-black rounded-full border border-red-500/30 uppercase italic-none">Action Required</span>
                    @endif
                </div>
                <i class="fas fa-wallet absolute -bottom-8 -right-8 text-9xl text-white/5 italic-none"></i>
            </div>
        </div>

        <!-- Child-by-Child Breakdown -->
        <div class="space-y-10">
            <h4 class="text-xs font-black text-slate-800 uppercase tracking-[0.3em] ml-6 italic-none flex items-center">
                <i class="fas fa-layer-group mr-3 text-blue-600"></i> Individual Breakdowns
            </h4>

            @foreach($familyData as $data)
            <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col md:flex-row transition-all hover:shadow-xl">
                <!-- Left: Child Info -->
                <div class="p-10 md:w-80 border-b md:border-b-0 md:border-r border-slate-50 bg-slate-50/30 flex flex-col items-center text-center">
                    <div class="w-20 h-20 rounded-[1.5rem] bg-white border-4 border-white shadow-xl overflow-hidden mb-4">
                        @if($data['student']->student_photo)
                            <img src="{{ asset('storage/'.$data['student']->student_photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-200 bg-slate-50"><i class="fas fa-user text-2xl"></i></div>
                        @endif
                    </div>
                    <h5 class="text-sm font-black text-slate-800 uppercase italic-none">{{ $data['student']->user->name }}</h5>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">{{ $data['student']->schoolClass->full_name }}</p>
                    <span class="mt-4 px-3 py-1 bg-white border border-slate-200 text-slate-500 text-[8px] font-black rounded-lg uppercase italic-none tracking-widest">
                        {{ $data['student']->admission_number }}
                    </span>
                </div>

                <!-- Right: Financials -->
                <div class="p-10 flex-1 flex flex-col justify-center">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 italic-none">Assigned Bill</p>
                            <p class="text-xl font-black text-slate-800 italic-none">₦{{ number_format($data['bill'], 2) }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 italic-none">Payment Applied</p>
                            <p class="text-xl font-black text-emerald-600 italic-none">₦{{ number_format($data['paid'], 2) }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1 italic-none">Current Balance</p>
                            <p class="text-xl font-black {{ $data['balance'] > 0 ? 'text-red-500' : 'text-slate-800' }} italic-none">₦{{ number_format($data['balance'], 2) }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-10 pt-8 border-t border-slate-50 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-info-circle text-slate-300 text-xs italic-none"></i>
                            <p class="text-[10px] font-medium text-slate-400 italic-none uppercase tracking-tight">Based on {{ $data['student']->schoolClass->fees->count() }} itemized class charges</p>
                        </div>
                        <a href="{{ route('parent.fees.pay', $data['student']->id) }}" 
                        class="px-8 py-3 bg-blue-600 text-white font-black rounded-xl text-[10px] uppercase tracking-widest hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all italic-none">
                            Submit Payment for {{ explode(' ', $data['student']->user->name)[0] }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Help Section -->
        <div class="mt-16 p-10 bg-white rounded-[3rem] border border-slate-100 shadow-sm flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex items-center">
                <div class="w-14 h-14 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mr-6 border border-orange-100 italic-none shadow-inner">
                    <i class="fas fa-question-circle text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-black text-slate-800 uppercase italic-none">Payment Assistance</p>
                    <p class="text-[11px] text-slate-400 font-medium italic-none mt-1">If you have made a transfer that hasn't reflected, please upload your receipt via the payment portal.</p>
                </div>
            </div>
            <a href="#" class="px-10 py-4 bg-slate-900 text-white font-black rounded-2xl text-[10px] uppercase tracking-widest hover:bg-blue-600 transition-all italic-none shadow-xl">Contact Bursary</a>
        </div>

    </div>
</x-parent-layout>