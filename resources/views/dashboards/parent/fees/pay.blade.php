<x-parent-layout>
    <div class="max-w-5xl mx-auto pb-24" x-data="{ fileName: '' }">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('parent.fees') }}" class="hover:text-blue-600 transition-colors italic-none">Financials</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Pay for {{ $student->user->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-10">
            
            <!-- Left: School Bank Details (2/5) -->
            <div class="lg:col-span-2 space-y-8">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-4 italic-none">Receiving Account</h4>
                
                <div class="bg-blue-900 rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden italic-none">
                    <div class="relative z-10">
                        @if($activeBank)
                            <p class="text-[9px] font-black text-blue-300 uppercase tracking-widest mb-1">Receiving Account</p>
                            <h4 class="text-lg font-black uppercase mb-6">{{ $activeBank->bank_name }}</h4>
                            <p class="text-3xl font-black tracking-widest mb-6">{{ $activeBank->account_number }}</p>
                            <p class="text-sm font-black uppercase">{{ $activeBank->account_name }}</p>
                        @else
                            <p class="text-sm font-black text-red-300 uppercase">Bank Details Unavailable. Contact School.</p>
                        @endif
                    </div>
                    <i class="fas fa-university absolute -bottom-10 -left-10 text-[150px] opacity-5"></i>
                </div>

                <div class="p-8 bg-orange-50 rounded-[2.5rem] border border-orange-100 italic-none">
                    <div class="flex items-center text-orange-600 mb-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest">Process Note</span>
                    </div>
                    <p class="text-xs text-orange-700 font-medium leading-relaxed uppercase">
                        Ensure the student name or admission number is used as the transfer narration for faster verification.
                    </p>
                </div>
            </div>

            <!-- Right: Submission Form (3/5) -->
            <div class="lg:col-span-3 space-y-6">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] ml-4 italic-none">Payment Details</h4>
                
                <form action="{{ route('parent.fees.submit', $student->id) }}" method="POST" enctype="multipart/form-data" 
                      class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm p-10 space-y-10">
                    @csrf
                    
                    <!-- Child Identity Header -->
                    <div class="flex items-center p-6 bg-slate-50 rounded-3xl border border-slate-100">
                        <div class="w-12 h-12 rounded-xl border-2 border-white shadow-md overflow-hidden mr-4 italic-none shrink-0">
                            @if($student->student_photo)
                                <img src="{{ asset('storage/'.$student->student_photo) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300 bg-white"><i class="fas fa-user"></i></div>
                            @endif
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1 italic-none">Paying For:</p>
                            <p class="text-sm font-black text-slate-800 uppercase italic-none leading-none">{{ $student->user->name }}</p>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-2 italic-none">Amount Transferred (₦)</label>
                        <div class="relative group">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-slate-300 group-focus-within:text-blue-600 italic-none text-lg">₦</span>
                            <input type="number" name="amount" required step="0.01"
                                class="w-full pl-14 pr-6 py-6 bg-slate-50 border border-slate-100 rounded-[2rem] font-black text-3xl text-slate-800 focus:ring-8 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all shadow-sm italic-none" 
                                placeholder="0.00">
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="space-y-4">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-2 italic-none">Proof of Payment</label>
                        <label class="flex flex-col items-center justify-center w-full h-52 border-2 border-dashed border-slate-200 rounded-[2.5rem] bg-slate-50 hover:bg-white hover:border-blue-400 transition-all cursor-pointer group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm mb-4 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-cloud-upload-alt text-blue-600"></i>
                                </div>
                                <p class="text-[11px] font-black text-slate-500 uppercase tracking-widest" x-text="fileName ? 'Attached: ' + fileName : 'Upload Receipt'"></p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter mt-2 italic-none">PDF, JPEG or PNG (Max 5MB)</p>
                            </div>
                            <input type="file" name="proof" class="hidden" required accept="image/*,application/pdf" 
                                @change="fileName = $event.target.files[0].name" />
                        </label>
                    </div>

                    <div class="pt-4 flex items-center space-x-8">
                        <a href="{{ route('parent.fees') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic-none hover:text-red-500 transition-colors">Discard</a>
                        <button type="submit" class="flex-1 py-6 bg-blue-600 text-white font-black rounded-[2rem] shadow-2xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-1.5 transition-all active:scale-95 uppercase tracking-widest text-xs italic-none">
                            Submit for Verification
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-parent-layout>