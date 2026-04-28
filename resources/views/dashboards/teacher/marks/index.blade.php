<x-teacher-layout>
    <div class="max-w-6xl mx-auto pb-24">
        <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tight leading-none italic-none mb-10">Assessment Center</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($workload as $item)
            <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden group hover:shadow-xl transition-all">
                <div class="p-8">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl mb-6 shadow-inner italic-none border border-emerald-100">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h3 class="text-lg font-black text-slate-800 uppercase italic-none leading-tight">{{ $item->subject->name }}</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2">{{ $item->schoolClass->full_name }}</p>
                    
                    <a href="{{ route('teacher.marks.entry', [$item->schoolClass->id, $item->subject->id]) }}" class="mt-8 block w-full py-4 bg-slate-900 text-white text-center font-black rounded-2xl shadow-lg hover:bg-blue-600 transition-all uppercase tracking-widest text-[10px] italic-none">
                        Enter Marks
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-teacher-layout>