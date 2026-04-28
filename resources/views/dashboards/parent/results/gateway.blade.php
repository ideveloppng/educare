<x-parent-layout>
    <div class="max-w-2xl mx-auto pb-24">
        <nav class="flex items-center space-x-3 mb-10 text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
            <a href="{{ route('parent.results') }}" class="hover:text-blue-600 transition-colors italic-none">Select Child</a>
            <i class="fas fa-chevron-right text-[8px] text-slate-300"></i>
            <span class="text-slate-800 uppercase italic-none">{{ $student->user->name }}</span>
        </nav>

        <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-12 text-center border-b border-slate-50 bg-slate-50/30">
                <div class="w-20 h-20 bg-blue-600 rounded-[1.8rem] flex items-center justify-center text-white text-3xl mx-auto mb-6 shadow-2xl border-4 border-white italic-none"><i class="fas fa-key"></i></div>
                <h2 class="text-2xl font-black text-slate-800 uppercase italic-none">Verification Gateway</h2>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 italic-none">Enter scratch card details for academic transcript</p>
            </div>

            <form action="{{ route('parent.results.check', $student->id) }}" method="POST" class="p-12 space-y-8">
                @csrf
                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 italic-none">Session</label>
                        <select name="session" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none uppercase text-xs italic-none">
                            @foreach($sessions as $session)
                                <option value="{{ $session }}" {{ Auth::user()->school->current_session == $session ? 'selected' : '' }}>{{ $session }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-2 italic-none">Term</label>
                        <select name="term" required class="w-full px-5 py-4 border border-slate-100 bg-slate-50 rounded-2xl font-bold outline-none uppercase text-xs italic-none">
                            <option value="First Term" {{ Auth::user()->school->current_term == 'First Term' ? 'selected' : '' }}>First Term</option>
                            <option value="Second Term" {{ Auth::user()->school->current_term == 'Second Term' ? 'selected' : '' }}>Second Term</option>
                            <option value="Third Term" {{ Auth::user()->school->current_term == 'Third Term' ? 'selected' : '' }}>Third Term</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-6">
                    <input type="text" name="serial_number" required placeholder="CARD SERIAL NUMBER" class="w-full px-6 py-5 border border-slate-100 bg-slate-50 rounded-2xl font-black text-lg focus:ring-8 focus:ring-blue-500/5 outline-none uppercase tracking-widest italic-none">
                    <input type="text" name="pin" required placeholder="SCRATCH CARD PIN" class="w-full px-6 py-5 border border-slate-100 bg-slate-50 rounded-2xl font-black text-lg focus:ring-8 focus:ring-blue-500/5 outline-none tracking-[0.4em] italic-none">
                </div>

                <button type="submit" class="w-full py-6 bg-blue-600 text-white font-black rounded-[2rem] shadow-2xl shadow-blue-200 hover:bg-blue-700 transition-all uppercase tracking-widest text-xs italic-none">
                    Verify & Load Report Card
                </button>
            </form>
        </div>
    </div>
</x-parent-layout>