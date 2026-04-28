<x-teacher-layout>
    <div class="max-w-6xl mx-auto pb-24">
        
        <!-- Header -->
        <div class="flex items-center space-x-5 mb-10">
            <a href="{{ route('teacher.classes.index') }}" class="w-12 h-12 bg-white border border-slate-200 rounded-2xl flex items-center justify-center text-slate-400 hover:text-blue-600 transition-all shadow-sm italic-none">
                <i class="fas fa-arrow-left text-xs"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase italic-none">{{ $class->full_name }} Registry</h1>
                <p class="text-slate-400 font-medium mt-1 uppercase text-[10px] font-black tracking-widest italic-none">Complete student list for this academic arm</p>
            </div>
        </div>

        <!-- Student Table -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto no-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50/50 border-b border-slate-100">
                            <th class="px-10 py-6">Student Information</th>
                            <th class="px-10 py-6">Admission No</th>
                            <th class="px-10 py-6">Gender</th>
                            <th class="px-10 py-6 text-right">Registry Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($students as $student)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-10 py-8">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden mr-5 shrink-0 shadow-sm italic-none">
                                        @if($student->student_photo)
                                            <img src="{{ asset('storage/'.$student->student_photo) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <i class="fas fa-user text-xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800 uppercase text-sm italic-none group-hover:text-blue-600 transition-colors">
                                            {{ $student->user->name }}
                                        </p>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic-none">
                                            Guardian: {{ $student->parent_phone ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <span class="text-sm font-bold text-slate-600 tracking-widest italic-none">{{ $student->admission_number }}</span>
                            </td>
                            <td class="px-10 py-8">
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest italic-none">{{ $student->gender }}</span>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <span class="px-4 py-1.5 {{ $student->status === 'active' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-red-50 text-red-600 border-red-100' }} rounded-full text-[9px] font-black uppercase tracking-widest border italic-none">
                                    {{ $student->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-10 py-24 text-center">
                                <p class="text-slate-300 font-bold uppercase text-[10px] tracking-[0.2em] italic-none">No students found in this class registry</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-teacher-layout>