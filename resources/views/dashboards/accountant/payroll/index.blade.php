<x-accountant-layout>
    <div x-data="{ 
        showModal: false, 
        activeStaff: { id: '', name: '', salary: 0 },
        gross: 0, housing: 0, feeding: 0, transport: 0, medical: 0,
        pension: 0, tax: 0, union: 0, coop: 0,
        get netPay() {
            return (parseFloat(this.gross || 0) + parseFloat(this.housing || 0) + parseFloat(this.feeding || 0) + parseFloat(this.transport || 0) + parseFloat(this.medical || 0)) 
                 - (parseFloat(this.pension || 0) + parseFloat(this.tax || 0) + parseFloat(this.union || 0) + parseFloat(this.coop || 0))
        }
    }">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Staff Payroll</span>
        </nav>

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">Staff Payroll</h1>
                <p class="text-slate-400 font-medium mt-2 uppercase text-[10px] font-black tracking-widest italic-none">Monthly salary distribution and tax processing</p>
            </div>
            
            <form action="{{ route('accountant.payroll') }}" method="GET" class="flex items-center gap-3">
                <select name="month" onchange="this.form.submit()" class="px-5 py-3 border border-slate-200 bg-white rounded-2xl font-black text-[10px] uppercase focus:ring-4 focus:ring-blue-500/5 outline-none italic-none">
                    @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $m)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
                <select name="year" onchange="this.form.submit()" class="px-5 py-3 border border-slate-200 bg-white rounded-2xl font-black text-[10px] uppercase focus:ring-4 focus:ring-blue-500/5 outline-none italic-none">
                    <option value="2026" {{ $year == '2026' ? 'selected' : '' }}>2026</option>
                    <option value="2025" {{ $year == '2025' ? 'selected' : '' }}>2025</option>
                </select>
            </form>
        </div>

        <!-- Summary Cards (Original Design Restored) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="bg-white p-8 rounded-[3rem] border border-slate-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 italic-none">Gross Commitment</p>
                    <h3 class="text-3xl font-black text-slate-800 italic-none">₦{{ number_format($totalPayroll, 2) }}</h3>
                </div>
                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center border border-blue-100 italic-none shadow-inner"><i class="fas fa-users"></i></div>
            </div>
            <div class="bg-blue-900 p-8 rounded-[3rem] shadow-2xl shadow-blue-200 flex items-center justify-between text-white">
                <div>
                    <p class="text-[10px] font-black text-blue-300 uppercase tracking-widest mb-1 italic-none">Disbursed (Net)</p>
                    <h3 class="text-3xl font-black text-white italic-none">₦{{ number_format($paidAmount, 2) }}</h3>
                </div>
                <div class="text-right">
                    <p class="text-[24px] font-black text-emerald-400 leading-none italic-none">{{ number_format(($paidAmount / ($totalPayroll ?: 1)) * 100) }}%</p>
                    <p class="text-[8px] font-bold text-blue-400 uppercase tracking-widest mt-1 italic-none">PROCESSED</p>
                </div>
            </div>
        </div>

        <!-- Payroll Table -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mb-10">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                            <th class="px-10 py-6">Staff Member</th>
                            <th class="px-10 py-6">Role</th>
                            <th class="px-10 py-6">Basic Gross</th>
                            <th class="px-10 py-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($employees as $emp)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-10 py-7">
                                <p class="font-black text-slate-800 uppercase text-sm italic-none">{{ $emp->name }}</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">{{ $emp->email }}</p>
                            </td>
                            <td class="px-10 py-7">
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[9px] font-black rounded-lg uppercase italic-none border border-slate-200">{{ $emp->role }}</span>
                            </td>
                            <td class="px-10 py-7">
                                <span class="text-base font-black text-slate-800 italic-none">₦{{ number_format($emp->base_salary, 2) }}</span>
                            </td>
                            <td class="px-10 py-7 text-right">
                                @if($emp->is_paid)
                                    <div class="flex items-center justify-end space-x-4">
                                        <span class="text-emerald-500 font-black text-[10px] uppercase tracking-widest italic-none">
                                            <i class="fas fa-check-circle mr-1"></i> Disbursed
                                        </span>
                                        <!-- PRINT BUTTON ADDED HERE -->
                                        <a href="{{ route('accountant.payroll.print', $emp->current_payroll_id) }}" target="_blank" 
                                           class="w-10 h-10 bg-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all shadow-sm italic-none">
                                            <i class="fas fa-print text-xs"></i>
                                        </a>
                                    </div>
                                @else
                                    <button @click="activeStaff = { id: '{{ $emp->id }}', name: '{{ $emp->name }}', salary: {{ $emp->base_salary }} }; gross = {{ $emp->base_salary }}; showModal = true"
                                            class="px-6 py-2.5 bg-blue-600 text-white font-black rounded-xl text-[9px] uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-100 italic-none">
                                        Process Pay
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- MODAL: SALARY BREAKDOWN (With Input Titles) -->
        <!-- ========================================== -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
            <form action="{{ route('accountant.payroll.process') }}" method="POST" x-transition.scale.95 
                 class="relative bg-white w-full max-w-4xl rounded-[3.5rem] shadow-2xl overflow-hidden border border-slate-100 flex flex-col max-h-[95vh]">
                @csrf
                <input type="hidden" name="user_id" x-model="activeStaff.id">
                <input type="hidden" name="month" value="{{ $month }}">
                <input type="hidden" name="year" value="{{ $year }}">

                <div class="p-10 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 uppercase italic-none leading-none">Salary Breakdown</h3>
                        <p class="text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-2 italic-none" x-text="'Employee: ' + activeStaff.name"></p>
                    </div>
                    <button type="button" @click="showModal = false" class="text-slate-300 hover:text-red-500"><i class="fas fa-times text-xl"></i></button>
                </div>

                <div class="p-10 space-y-12 bg-white overflow-y-auto no-scrollbar">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                        <!-- Left: Base & Deductions -->
                        <div class="space-y-10">
                            <div>
                                <label class="text-[11px] font-black text-slate-800 uppercase tracking-widest block mb-4 italic-none">Basic Monthly Salary (₦)</label>
                                <input type="number" name="gross_amount" x-model="gross" required class="w-full px-6 py-5 bg-slate-50 border border-slate-100 rounded-2xl font-black text-xl text-blue-600 outline-none italic-none shadow-inner">
                            </div>

                            <div class="space-y-6">
                                <p class="text-[10px] font-black text-red-500 uppercase tracking-[0.2em] italic-none border-b border-red-50 pb-2">Statutory Deductions</p>
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Union Dues</label>
                                        <input type="number" name="union" x-model="union" class="w-full px-4 py-4 border border-slate-100 bg-slate-50 rounded-xl font-bold text-xs uppercase italic-none outline-none focus:bg-white transition-all">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">PAYE Tax</label>
                                        <input type="number" name="tax" x-model="tax" class="w-full px-4 py-4 border border-slate-100 bg-slate-50 rounded-xl font-bold text-xs uppercase italic-none outline-none focus:bg-white transition-all">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Pension (8%)</label>
                                        <input type="number" name="pension" x-model="pension" class="w-full px-4 py-4 border border-slate-100 bg-slate-50 rounded-xl font-bold text-xs uppercase italic-none outline-none focus:bg-white transition-all">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Cooperative</label>
                                        <input type="number" name="cooperative" x-model="coop" class="w-full px-4 py-4 border border-slate-100 bg-slate-50 rounded-xl font-bold text-xs uppercase italic-none outline-none focus:bg-white transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Allowances -->
                        <div class="space-y-10">
                            <div class="space-y-6">
                                <p class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em] italic-none border-b border-emerald-50 pb-2">Allowances & Benefits</p>
                                <div class="space-y-5">
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Housing Allowance</label>
                                        <input type="number" name="housing" x-model="housing" class="w-full px-4 py-4 border border-slate-100 bg-slate-50 rounded-xl font-bold text-xs italic-none outline-none focus:bg-white transition-all">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Feeding Allowance</label>
                                        <input type="number" name="feeding" x-model="feeding" class="w-full px-4 py-4 border border-slate-100 bg-slate-50 rounded-xl font-bold text-xs italic-none outline-none focus:bg-white transition-all">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Transport Allowance</label>
                                        <input type="number" name="transport" x-model="transport" class="w-full px-4 py-4 border border-slate-100 bg-slate-50 rounded-xl font-bold text-xs italic-none outline-none focus:bg-white transition-all">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1 italic-none">Medical Benefit</label>
                                        <input type="number" name="medical" x-model="medical" class="w-full px-4 py-4 border border-slate-100 bg-slate-50 rounded-xl font-bold text-xs italic-none outline-none focus:bg-white transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Net Pay Result -->
                    <div class="p-8 bg-slate-900 rounded-[2.5rem] shadow-2xl relative overflow-hidden text-center mt-6">
                        <p class="text-[10px] font-black text-blue-300 uppercase tracking-widest mb-2 italic-none relative z-10">Calculated Net Payable Amount</p>
                        <h4 class="text-4xl font-black text-white italic-none tracking-tighter relative z-10" x-text="'₦' + Number(netPay).toLocaleString(undefined, {minimumFractionDigits: 2})"></h4>
                        <div class="absolute inset-0 bg-blue-600/10 z-0"></div>
                        <i class="fas fa-check-double absolute -bottom-4 -right-4 text-7xl text-white/5"></i>
                    </div>
                </div>

                <div class="p-10 bg-slate-50 border-t border-slate-100 flex flex-col space-y-3 italic-none">
                    <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl shadow-xl hover:bg-blue-700 transition-all uppercase tracking-widest text-[11px] italic-none">
                        Confirm & Generate Payslip
                    </button>
                    <button type="button" @click="showModal = false" class="w-full py-4 text-slate-400 font-bold uppercase text-[10px] italic-none hover:text-slate-600 transition-colors">Discard Calculation</button>
                </div>
            </form>
        </div>

    </div>
</x-accountant-layout>