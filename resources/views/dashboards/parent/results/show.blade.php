<x-parent-layout>
    <div class="max-w-5xl mx-auto pb-24">
        
        <!-- Top Toolbar -->
        <div class="flex flex-col md:flex-row items-center justify-between mb-10 gap-6">
            <a href="{{ route('parent.results.gateway', $student->id) }}" class="flex items-center text-slate-400 hover:text-blue-600 font-black text-[10px] uppercase tracking-widest transition-all italic-none">
                <i class="fas fa-arrow-left mr-2"></i> Back to Gateway
            </a>
            <button onclick="window.print()" class="px-8 py-3 bg-white border border-slate-200 text-slate-700 font-black rounded-xl text-[10px] uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm italic-none">
                <i class="fas fa-print mr-2"></i> Print Report Card
            </button>
        </div>

        <div class="bg-white rounded-[3.5rem] border-2 border-slate-100 shadow-2xl overflow-hidden print:border-0 print:shadow-none italic-none">
            
            <!-- INSTITUTIONAL HEADER -->
            <div class="p-12 border-b-8 border-blue-600 flex flex-col md:flex-row items-center justify-between gap-8 bg-slate-50/50">
                <div class="flex items-center text-center md:text-left">
                    @if($school->logo)
                        <img src="{{ asset('storage/'.$school->logo) }}" class="w-24 h-24 rounded-2xl object-cover mr-8 shadow-xl border-4 border-white bg-white">
                    @else
                        <div class="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-3xl mr-6 shadow-xl border-4 border-white italic-none">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                    @endif
                    <div>
                        <h2 class="text-4xl font-black text-slate-900 uppercase tracking-tight italic-none leading-none">{{ $school->name }}</h2>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.3em] mt-3 italic-none">{{ $school->address ?? 'Institutional Education Portal' }}</p>
                    </div>
                </div>
                <div class="text-center md:text-right space-y-2">
                    <h3 class="text-2xl font-black text-blue-600 uppercase italic-none tracking-tight">Terminal Report</h3>
                    <div class="px-4 py-1.5 bg-blue-100 rounded-lg inline-block border border-blue-200">
                        <span class="text-[10px] font-black text-blue-700 uppercase tracking-widest italic-none">
                            {{ $token->term }} • {{ $token->session }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- STUDENT PROFILE SUMMARY -->
            <div class="px-12 py-10 bg-white border-b border-slate-100 grid grid-cols-1 md:grid-cols-4 gap-8 italic-none">
                <div class="space-y-1">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic-none">Student Name</p>
                    <p class="text-sm font-black text-slate-800 uppercase italic-none">{{ $student->user->name }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic-none">Admission ID</p>
                    <p class="text-sm font-black text-slate-800 uppercase italic-none">{{ $student->admission_number }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic-none">Class Level</p>
                    <p class="text-sm font-black text-slate-800 uppercase italic-none">{{ $student->schoolClass->full_name }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic-none">Verification</p>
                    <p class="text-sm font-black text-emerald-600 uppercase italic-none">Authenticated By Parent</p>
                </div>
            </div>

            <!-- TERMINAL SCORE SHEET -->
            <div class="p-8 md:p-12">
                <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden">
                    <div class="overflow-x-auto no-scrollbar">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 border-b border-slate-100">
                                    <th class="px-8 py-6">Subject</th>
                                    <th class="px-4 py-6 text-center">CA Total (30)</th>
                                    <th class="px-4 py-6 text-center">Exam (70)</th>
                                    <th class="px-4 py-6 text-center">Final (100)</th>
                                    <th class="px-4 py-6 text-center">Grade</th>
                                    <th class="px-8 py-6 text-right">Instructor Remark</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($results as $res)
                                <tr class="group italic-none">
                                    <td class="px-8 py-6">
                                        <p class="font-black text-slate-800 uppercase text-sm italic-none">{{ $res->subject->name }}</p>
                                    </td>
                                    <td class="px-4 py-6 text-center font-bold text-slate-600 italic-none">
                                        {{ (float)($res->ca1 + $res->ca2 + $res->ca3) }}
                                    </td>
                                    <td class="px-4 py-6 text-center font-bold text-slate-600 italic-none">
                                        {{ (float)$res->exam }}
                                    </td>
                                    <td class="px-4 py-6 text-center">
                                        <span class="text-lg font-black text-blue-600 italic-none tracking-tighter">{{ (float)$res->total }}</span>
                                    </td>
                                    <td class="px-4 py-6 text-center">
                                        <span class="px-4 py-1.5 rounded-xl font-black text-sm uppercase italic-none shadow-sm
                                            {{ $res->grade == 'A' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-blue-50 text-blue-600 border border-blue-100' }}">
                                            {{ $res->grade }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight italic-none max-w-[150px] ml-auto leading-relaxed">
                                            {{ $res->remarks ?? 'NO REMARK' }}
                                        </p>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-10 py-32 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 text-3xl mb-4 border-2 border-dashed border-slate-100 italic-none">
                                                <i class="fas fa-hourglass-half"></i>
                                            </div>
                                            <p class="text-slate-300 font-black uppercase text-[11px] tracking-[0.2em] italic-none">Academic Records currently processing</p>
                                            <p class="text-slate-300 mt-1 text-[9px] uppercase italic-none">Please check back once the directorate publishes all scores.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- SECURITY FOOTER -->
            <div class="p-12 bg-slate-900 text-white flex flex-col md:flex-row items-center justify-between gap-8 italic-none">
                <div class="flex items-center bg-white/5 border border-white/10 px-8 py-5 rounded-3xl shadow-xl">
                    <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center mr-5 shadow-2xl shadow-blue-500/50 italic-none border border-blue-400">
                        <i class="fas fa-shield-check text-xl"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-blue-300 uppercase tracking-widest italic-none">Parental Verification</p>
                        <p class="text-xs font-black text-white uppercase italic-none mt-1 tracking-tighter">
                            Ref: {{ strtoupper($token->batch_number) }}-{{ $token->serial_number }}
                        </p>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-[0.2em] italic-none">Generated via Parent Portal</p>
                    <p class="text-[10px] font-black text-slate-400 uppercase mt-2 italic-none">Date: {{ now()->format('d/m/Y • H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-parent-layout>