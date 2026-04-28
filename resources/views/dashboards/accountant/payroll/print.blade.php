<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip_{{ $payroll->user->name }}_{{ $payroll->month }}_{{ $payroll->year }}</title>
    
    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CDN for Print rendering -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; padding: 0 !important; }
            .print-container { 
                box-shadow: none !important; 
                border: none !important; 
                padding: 0 !important; 
                margin: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
            }
        }

        /* Specific Institutional Styling */
        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .italic-none { font-style: normal !important; }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 150px;
            font-weight: 900;
            color: rgba(0, 0, 0, 0.02);
            pointer-events: none;
            text-transform: uppercase;
            z-index: 0;
            white-space: nowrap;
        }
    </style>
</head>
<body class="p-6 md:p-12">

    <!-- 1. PRINT TOOLBAR (Hidden during print) -->
    <div class="no-print max-w-4xl mx-auto mb-10 flex justify-between items-center bg-slate-900 text-white p-6 rounded-[2rem] shadow-2xl">
        <div class="flex items-center space-x-4">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center">
                <i class="fas fa-print"></i>
            </div>
            <div>
                <p class="font-black uppercase tracking-widest text-[10px] italic-none">Payslip Terminal</p>
                <p class="text-[9px] text-slate-400 font-bold uppercase italic-none">Ready for high-quality export</p>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <button onclick="window.close()" class="text-xs font-black uppercase text-slate-400 hover:text-white transition-colors italic-none">Close</button>
            <button onclick="window.print()" class="bg-blue-600 px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30 italic-none">
                Print Statement
            </button>
        </div>
    </div>

    <!-- 2. MAIN PAYSLIP DOCUMENT -->
    <div class="print-container max-w-4xl mx-auto bg-white p-12 md:p-20 shadow-sm border border-slate-100 min-h-[1100px] relative overflow-hidden flex flex-col">
        
        <!-- Watermark -->
        <div class="watermark italic-none">APPROVED</div>

        <!-- Document Header -->
        <div class="text-center mb-24 relative z-10">
            <h1 class="text-5xl font-black text-slate-900 uppercase tracking-tighter mb-3 italic-none leading-none">
                {{ auth()->user()->school->name }}
            </h1>
            <p class="text-sm font-bold text-slate-400 uppercase tracking-[0.5em] italic-none">Official Payslip Statement</p>
        </div>

        <!-- Employee & Period Identification -->
        <div class="border-y-4 border-slate-900 py-8 mb-16 flex justify-between items-center relative z-10 italic-none">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 italic-none">Employee Name</p>
                <h2 class="text-3xl font-black text-slate-800 uppercase italic-none tracking-tight">{{ $payroll->user->name }}</h2>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 italic-none">Payment Period</p>
                <h2 class="text-3xl font-black text-slate-800 uppercase italic-none tracking-tighter">
                    {{ $payroll->year }}-{{ str_pad(\Carbon\Carbon::parse($payroll->month)->month, 2, '0', STR_PAD_LEFT) }}
                </h2>
            </div>
        </div>

        <!-- Financial Breakdown -->
        <div class="flex-1 space-y-16 relative z-10">
            
            <!-- Basic Salary Section -->
            <div class="flex justify-between items-end border-b border-slate-100 pb-6">
                <h3 class="text-xl font-black text-slate-900 uppercase italic-none tracking-widest">Basic Monthly Salary</h3>
                <span class="text-3xl font-black text-slate-900 italic-none tracking-tighter">₦{{ number_format($payroll->gross_amount, 2) }}</span>
            </div>

            <div class="grid grid-cols-1 gap-16">
                
                <!-- Section: Deductions -->
                <div>
                    <h4 class="text-xs font-black text-red-500 uppercase tracking-[0.3em] mb-8 border-b border-red-100 pb-3 italic-none">Statutory Deductions</h4>
                    <div class="space-y-5">
                        <div class="flex justify-between text-sm font-bold text-slate-500 uppercase italic-none">
                            <span>Union Dues</span>
                            <span>- {{ number_format($payroll->union_dues, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold text-slate-500 uppercase italic-none">
                            <span>Personal Income Tax (PAYE)</span>
                            <span>- {{ number_format($payroll->tax_deduction, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold text-slate-500 uppercase italic-none">
                            <span>Pension Contribution</span>
                            <span>- {{ number_format($payroll->pension_deduction, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold text-slate-500 uppercase italic-none">
                            <span>Cooperative Contribution</span>
                            <span>- {{ number_format($payroll->cooperative_deduction, 2) }}</span>
                        </div>
                        
                        <!-- Total Deductions Row -->
                        <div class="flex justify-between text-xl font-black text-red-500 uppercase pt-6 border-t-2 border-red-50 mt-6 italic-none">
                            <span>Total Deductions</span>
                            @php
                                $totalDeductions = $payroll->union_dues + $payroll->tax_deduction + $payroll->pension_deduction + $payroll->cooperative_deduction;
                            @endphp
                            <span>(₦{{ number_format($totalDeductions, 2) }})</span>
                        </div>
                    </div>
                </div>

                <!-- Section: Allowances -->
                <div>
                    <h4 class="text-xs font-black text-emerald-600 uppercase tracking-[0.3em] mb-8 border-b border-emerald-100 pb-3 italic-none">Allowances & Benefits</h4>
                    <div class="space-y-5">
                        <div class="flex justify-between text-sm font-bold text-slate-600 uppercase italic-none">
                            <span>Housing Allowance</span>
                            <span>{{ number_format($payroll->housing_allowance, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold text-slate-600 uppercase italic-none">
                            <span>Feeding Allowance</span>
                            <span>{{ number_format($payroll->feeding_allowance, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold text-slate-600 uppercase italic-none">
                            <span>Transport Allowance</span>
                            <span>{{ number_format($payroll->transport_allowance, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm font-bold text-slate-600 uppercase italic-none">
                            <span>Medical Benefit</span>
                            <span>{{ number_format($payroll->medical_benefit, 2) }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- 3. NET PAYABLE FOOTER (Matches your Page 2 style) -->
        <div class="mt-20 relative z-10">
            <div class="bg-slate-50 rounded-[3rem] p-10 md:p-14 flex flex-col md:flex-row items-center justify-between border border-slate-100 shadow-inner">
                <div class="text-center md:text-left mb-6 md:mb-0">
                    <h3 class="text-2xl font-black text-slate-800 uppercase tracking-tighter italic-none leading-none">Net Payable Amount</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 italic-none">(Basic + Allowances) - Deductions</p>
                </div>
                <div class="text-5xl md:text-6xl font-black text-slate-900 italic-none tracking-tighter">
                    ₦{{ number_format($payroll->amount, 2) }}
                </div>
            </div>
        </div>

        <!-- System Authentication -->
        <div class="mt-12 flex justify-between items-center text-[9px] font-black text-slate-300 uppercase tracking-[0.2em] italic-none">
            <p>Digital Reference: {{ $payroll->reference }}</p>
            <p>Generated: {{ now()->format('d/m/Y H:i') }}</p>
        </div>

    </div>

</body>
</html>