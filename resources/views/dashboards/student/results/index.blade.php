<x-student-layout>
    <div class="max-w-2xl mx-auto py-10">
        
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition-colors italic-none">Dashboard</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">Result Portal</span>
        </nav>

        <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-12 text-center border-b border-slate-50 bg-slate-50/30">
                <div class="w-20 h-20 bg-blue-600 rounded-[1.8rem] flex items-center justify-center text-white text-3xl mx-auto mb-6 shadow-2xl shadow-blue-200 border-4 border-white">
                    <i class="fas fa-certificate"></i>
                </div>
                <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tight italic-none">Result Checker</h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">Select academic period and enter PIN</p>
            </div>

            <form action="{{ route('student.results.check') }}" method="POST" class="p-12 space-y-8">
                @csrf
                
                <!-- Academic Selection Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-2 italic-none">Select Session</label>
                        <div class="relative">
                            <select name="session" required class="w-full pl-6 pr-10 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none appearance-none text-sm uppercase italic-none">
                                @foreach($sessions as $session)
                                    <option value="{{ $session }}" {{ Auth::user()->school->current_session == $session ? 'selected' : '' }}>{{ $session }} Session</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none text-[10px]"></i>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-2 italic-none">Select Term</label>
                        <div class="relative">
                            <select name="term" required class="w-full pl-6 pr-10 py-4 bg-slate-50 border border-slate-100 rounded-2xl font-bold focus:ring-4 focus:ring-blue-500/5 outline-none appearance-none text-sm uppercase italic-none">
                                <option value="First Term" {{ Auth::user()->school->current_term == 'First Term' ? 'selected' : '' }}>First Term</option>
                                <option value="Second Term" {{ Auth::user()->school->current_term == 'Second Term' ? 'selected' : '' }}>Second Term</option>
                                <option value="Third Term" {{ Auth::user()->school->current_term == 'Third Term' ? 'selected' : '' }}>Third Term</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <div class="h-px bg-slate-100 w-full my-4"></div>

                <!-- PIN Details -->
                <div class="space-y-6">
                    <div class="space-y-3">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-2 italic-none">Serial Number</label>
                        <input type="text" name="serial_number" required class="w-full px-6 py-5 border border-slate-100 bg-slate-50 rounded-2xl font-black text-lg focus:ring-8 focus:ring-blue-500/5 outline-none uppercase placeholder:text-slate-200 shadow-sm" placeholder="SN1000000">
                    </div>

                    <div class="space-y-3">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-2 italic-none">Scratch Card PIN</label>
                        <input type="text" name="pin" required class="w-full px-6 py-5 border border-slate-100 bg-slate-50 rounded-2xl font-black text-lg focus:ring-8 focus:ring-blue-500/5 outline-none tracking-[0.3em] placeholder:text-slate-200 shadow-sm" placeholder="XXXX-XXXX-XXXX">
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-6 bg-blue-600 text-white font-black rounded-3xl shadow-2xl shadow-blue-200 hover:bg-blue-700 transition-all uppercase tracking-widest text-xs italic-none">
                        Verify & View Transcript
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-student-layout>